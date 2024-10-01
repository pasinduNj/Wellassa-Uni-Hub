<?php
// cancel_reservation.php
include './classes/db_connection.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();

if (isset($_SESSION['reservation_id']) && isset($_SESSION['timeslot_id'])) {
    $reservation_id = $_SESSION['reservation_id'];
    $timeslot_id = $_SESSION['timeslot_id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete the reservation
        $delete_sql = "DELETE FROM reservations WHERE reservation_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $reservation_id);
        $delete_stmt->execute();

        // Update timeslot status back to 'available'
        $update_sql = "UPDATE timeslots SET status = 'free' WHERE timeslot_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("s", $timeslot_id);
        $update_stmt->execute();

        // Commit transaction
        $conn->commit();

        // Clear session variables
        unset($_SESSION['reservation_id']);
        unset($_SESSION['timeslot_id']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
    }
}

// Redirect back to the timeslots page
$userId = isset($_GET['userId']) ? '?userId=' . $_GET['userId'] : '';
header("Location: Bindex.php" . $userId);
exit();
