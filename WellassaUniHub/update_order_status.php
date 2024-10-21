<?php
require './php/classes/db_connection.php';
session_start();

$dbconnector = new DBConnection();
$conn = $dbconnector->getConnection();

$payment_id = $_POST['payment_id'];
$process_status = $_POST['status'];

if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    if($_SESSION['user_type'] == "sp_freelance" || $_SESSION['user_type'] == "customer" || $_SESSION['user_type'] == "sp_products"){
        if (isset($payment_id) && isset($process_status)) {
            // Prepare an SQL statement with placeholders
            $sql = "UPDATE payment SET process_status = ? WHERE payment_id = ?";
        
            // Prepare the statement
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('si', $process_status, $payment_id);
        
                // Execute the statement
                if ($stmt->execute()) {
                    // Redirect to the user profile with a success message
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
    }
    
    // Close the connection
    $conn->close();

}