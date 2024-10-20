<?php
require './php/classes/db_connection.php';
session_start();

$dbconnector = new DBConnection();
$conn = $dbconnector->getConnection();

$payment_id = $_POST['payment_id'];
$status = $_POST['status'];

if($session['user_type'] == "sp_freelance"){

    if (isset($payment_id) && isset($status)) {
        // Prepare an SQL statement with placeholders
        $sql = "UPDATE payment SET status = ? WHERE payment_id = ?";
    
        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('si', $status, $payment_id);
    
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the user profile with a success message
                echo $payment_id;
                echo $status;
                header("Location: ./user_profile.php?status=status_updated");
                exit; 
            } else {
                // Redirect to the user profile with an execution error
                header("Location: ./user_profile.php?error=exec_error");
                exit;
            }
    
            // Close the statement
            $stmt->close();
        } else {
            // Log or display any errors if statement preparation fails
            error_log("SQL error: " . $conn->error);
            header("Location: ./user_profile.php?error=database_prepare_failed");
            exit;
        }
    } else {
        // Redirect with an error message if data is missing
        header("Location: ./user_profile.php?error=missing_data");
        exit;
    }
    
    // Close the connection
    $conn->close();

}