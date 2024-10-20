<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
include './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

$email = htmlspecialchars(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
$contactNumber = htmlspecialchars($_POST['contactNumber']);
$password1 = htmlspecialchars($_POST['password']);
$password2 = htmlspecialchars($_POST['confirmPassword']);

if (empty($email) || empty($contactNumber) || empty($password1) || empty($password2)) {
    header("Location: ../forgot_password.php?S=1");
    exit();
}

if ($password1 != $password2) {
    header("Location: ../forgot_password.php?S=2");
    exit();
}

$query = "SELECT * FROM user WHERE email = '$email' AND contact_number = '$contactNumber'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (isset($row['user_id'])) {
        $user_id = $row['user_id'];
        $password = password_hash($password1, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        $query = "INSERT INTO verify (token, user_id, password, created_at, expires_at) 
        VALUES ('$token', '$user_id', '$password', NOW(), DATE_ADD(NOW(), INTERVAL 10 MINUTE))";

        if ($conn->query($query) === TRUE) {
            $link = "http://localhost/GitHub/WellassaUniHub/php/verify_email.php?token=$token";


            //Mail Function
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'unihubservice@gmail.com';
                $mail->Password   = 'smpssoqnmcelimrg';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->SMTPDebug = SMTP::DEBUG_SERVER;

                // Recipients
                $mail->setFrom('unihubservice@gmail.com', 'WellassaUniHub');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body    = 'Click the link below to reset your password: <a href="' . $link . '">Click here</a>';

                if ($mail->send()) {
                    header('Location: ../forgot_password.php?S=3');
                    exit();
                } else {
                    header('Location: ../forgot_password.php?S=4');
                    exit();
                }
            } catch (Exception $e) {
                header('Location: ../forgot_password.php?S=4');
                exit();
            }
        } else {
            header("Location: ../forgot_password.php?S=5");
            exit();
        }
    } else {
        header("Location: ../forgot_password.php?S=6");
        exit();
    }
} else {
    header("Location: ../forgot_password.php?S=6");
    exit();
}

$db->close();
