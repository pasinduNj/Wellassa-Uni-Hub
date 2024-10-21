<?php
// process_payment.php
include './classes/db_connection.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];
    //timeslotID
    $timeslot_id = $_POST['timeslot_id'];
    $user_id = $_POST['user_id'];
    //current_id
    $user = $_SESSION['user_id'];
    //provider_id
    $userId = $_POST['cus_id'];
    // Fetch reservation details
    // $reservation_sql = "SELECT r.cus_id, t.provider_id, t.price FROM reservations r
    //                     JOIN timeslots t ON r.timeslot_id = t.timeslot_id
    //                     WHERE r.reservation_id = ?";
    // $stmt = $conn->prepare($reservation_sql);
    // $stmt->bind_param("s", $reservation_id);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $reservation = $result->fetch_assoc();
    $reservation = true;

    if ($reservation) {
        $customer_id = $user;
        $provider_id = $userId;
        $price = 100;
        $product_id = 'TIMESLOT'; // You might want to adjust this based on your system
        $quantity = 1; // Assuming one timeslot per reservation
        $total = $price * $quantity;
        $date_time = date('Y-m-d H:i:s');
        $status = 'paid'; // You might want to adjust this based on your payment flow

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert payment data
            $payment_sql = "INSERT INTO payment (customer_id, provider_id, reservation_id,timeslot_id, price, quantity, total, date_time, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $payment_stmt = $conn->prepare($payment_sql);
            $payment_stmt->bind_param("ssssdidss", $customer_id, $provider_id, $reservation_id, $timeslot_id, $price, $quantity, $total, $date_time, $status);
            $payment_stmt->execute();

            // Update reservation status to 'paid'
            $update_sql = "UPDATE reservations SET payment_status = 'paid' WHERE reservation_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("s", $reservation_id);
            $update_stmt->execute();

            // Commit transaction
            $conn->commit();

            $_SESSION['payment_message'] = "Payment successful! Your reservation is confirmed.";
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $_SESSION['payment_message'] = "Payment failed. Please try again.";
        }
    } else {
        $_SESSION['payment_message'] = "Reservation not found. Please try again.";
    }

    // Redirect to confirmation page
    header("Location: reservation_confirmation.php?userId=" . $user_id);
    exit();
} else {
    // Redirect to home page if accessed directly without proper data
    header("Location: Bindex.php");
    exit();
}
