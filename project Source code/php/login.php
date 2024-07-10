<?php
include '.\classes\db_connection.php';
session_start();

$email = htmlspecialchars($_POST['email']);
$password = $_POST['password'];
$rememberMe = isset($_POST['rememberMe']);

$query = "SELECT * FROM customers WHERE email = '$email' UNION SELECT * FROM service_providers WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = isset($row['cus_id']) ? $row['cus_id'] : $row['sp_id'];
        $_SESSION['user_type'] = isset($row['cus_id']) ? 'customer' : 'serviceProvider';

        if ($rememberMe) {
            setcookie('email', $email, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");
        }

        header("Location: ../index.html");
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with this email.";
}

$conn->close();
?>
