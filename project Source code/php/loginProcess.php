<?php
session_start();
include './classes/db_connection.php';

function sanitize_input($data)
{
    return htmlspecialchars(trim($data));
}

function generate_auth_key()
{
    return bin2hex(random_bytes(16)); // Generates a 32-character random string
}

function set_remember_me($auth_key)
{
    $cookie_time = time() + (86400 * 30); // 30 days
    setcookie('auth_key', $auth_key, $cookie_time, "/");
}

$email = '';
$passwordInput = '';
$rememberMe = false;

$db = new DbConnection();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);
    $passwordInput = sanitize_input($_POST['password']);
    $rememberMe = isset($_POST['rememberMe']);
}


if (!empty($email) && !empty($passwordInput)) {
    $checkQuery = "SELECT user_id, user_type, password FROM user WHERE email = ?";
    if ($stmt = $conn->prepare($checkQuery)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $user_type, $password);
            $stmt->fetch();
            if (password_verify($passwordInput, $password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_type'] = $user_type;

                if ($rememberMe) {
                    $auth_key = generate_auth_key();
                    $auth_key_expires = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days
                    $updateQuery = "UPDATE user SET auth_key = ?, auth_key_expires = ? WHERE user_id = ?";
                    if ($updateStmt = $conn->prepare($updateQuery)) {
                        $updateStmt->bind_param('sss', $auth_key, $auth_key_expires, $user_id);
                        $updateStmt->execute();
                        $updateStmt->close();
                    }
                    set_remember_me($auth_key);
                }
                if ($user_type == "admin") {
                    header("Location: ../php/add_ad.php");
                    exit;
                }

                header("Location: ../index.html");
                exit;
            } else {
                echo "<script>alert('Invalid Email or Password.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password.'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error occurred.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Please fill in email and password fields.'); window.history.back();</script>";
}

$conn->close();
