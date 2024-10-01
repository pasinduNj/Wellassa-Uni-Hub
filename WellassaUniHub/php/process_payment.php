<?php
// process_payment.php
include './classes/db_connection.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $user_id = $_POST['user_id'];

    // Simulate payment processing
    $payment_successful = true; // In reality, this would be determined by your payment gateway

    if ($payment_successful) {
        // Update reservation payment status
        $sql = "UPDATE reservations SET payment_status = 'paid' WHERE reservation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $reservation_id);

        if ($stmt->execute()) {
            $_SESSION['payment_message'] = "Payment successful! Your reservation is confirmed.";
        } else {
            $_SESSION['payment_message'] = "Error updating payment status: " . $stmt->error;
        }
    } else {
        $_SESSION['payment_message'] = "Payment failed. Please try again.";
    }

    // Redirect to confirmation page
    header("Location: reservation_confirmation.php?userId=" . $user_id);
    exit();
}
