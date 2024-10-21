<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');  // Replace with an actual path where you have write permissions
error_reporting(E_ALL);

require_once 'classes/db_connection.php';
require_once 'classes/UserClass.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$db = new DBConnection();
$conn = $db->getConnection();

function processPayment($conn, $customer_id, $provider_id, $price, $quantity = 1)
{
    $total = $price * $quantity;
    $status = 'paid';

    $conn->begin_transaction();

    try {
        $sql = "INSERT INTO payment (customer_id, provider_id, price, quantity, total, status)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssdiis", $customer_id, $provider_id, $price, $quantity, $total, $status);
        $paymentInserted = $stmt->execute();

        if (!$paymentInserted) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $conn->commit();
        return ['success' => true, 'message' => 'Payment processed successfully'];
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Payment processing error: " . $e->getMessage());
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function sendEmail($customer_email, $provider_email, $price)
{
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

        // Recipients
        $mail->setFrom('unihubservice@gmail.com', 'WellassaUniHub');
        $mail->addAddress($customer_email, 'Customer');
        $mail->addCC($provider_email, 'Service Provider');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Successful';
        $mail->Body    = 'Customer with email ' . $customer_email . ' and Service Provider with email ' . $provider_email . ' paid for Freelance Service. Payment of ' . $price . ' was successful';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending error: " . $e->getMessage());
        return $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? '';
    $provider_id = $_POST['provider_id'] ?? '';
    $provider_email = $_POST['provider_email'] ?? '';
    $price = $_POST['price'] ?? 0;

    if (!$customer_id || !$provider_id || !$provider_email || !$price) {
        $result = ['success' => false, 'message' => 'Missing required parameters'];
    } else {
        $result = processPayment($conn, $customer_id, $provider_id, $price);

        if ($result['success']) {
            $customer = User::constructCUSWithUserId($conn, $customer_id);
            $customer_email = $customer->getEmail();

            $emailResult = sendEmail($customer_email, $provider_email, $price);
            if ($emailResult !== true) {
                $result['message'] .= '. Email sending failed: ' . $emailResult;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
