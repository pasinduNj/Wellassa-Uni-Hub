<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
include './classes/db_connection.php';
include './classes/UserClass.php';

// Initialize database connection
$db = new DbConnection();
$conn = $db->getConnection();

function processPayment($conn, $customer_id, $provider_id, $product_id, $price, $quantity = 1)
{
    $total = $price * $quantity;
    $status = 'paid';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into payment table
        $sql = "INSERT INTO payment (customer_id, provider_id, product_id, price, quantity, total, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiis", $customer_id, $provider_id, $product_id, $price, $quantity, $total, $status);
        $paymentInserted = $stmt->execute();

        if ($paymentInserted) {
            // Update product quantity
            $sql = "UPDATE product SET quantity = quantity - 1 WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $product_id);
            $quantityUpdated = $stmt->execute();

            if ($quantityUpdated) {
                // If both operations are successful, commit the transaction
                $conn->commit();
                return ['success' => true, 'message' => 'Payment processed successfully'];
            }
        }

        // If we reach here, something went wrong
        throw new Exception("Failed to process payment");
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $conn->rollback();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function sendEmail($customer_email, $provider_email, $product_id, $price)
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
        $mail->Body    = 'Product with ID ' . $product_id . ' Payment of ' . $price . ' was successful';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? '';
    $provider_id = $_POST['provider_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $price = $_POST['price'] ?? 0;

    if (!$customer_id || !$provider_id || !$product_id || !$price) {
        $result = ['success' => false, 'message' => 'Missing required parameters'];
    } else {
        $result = processPayment($conn, $customer_id, $provider_id, $product_id, $price);

        if ($result['success']) {
            $provider = User::constructSPWithUserId($conn, $provider_id);
            $customer = User::constructCUSWithUserId($conn, $customer_id);
            $customer_email = $customer->getEmail();
            $provider_email = $provider->getEmail();

            $emailResult = sendEmail($customer_email, $provider_email, $product_id, $price);
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
