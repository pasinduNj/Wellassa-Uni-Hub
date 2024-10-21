<?php
require './php/classes/db_connection.php';
session_start();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_id']) && isset($_POST['status'])) {
    $db = new DBConnection();
    $dbconn = $db->getConnection();

    $payment_id = $_POST['payment_id'];
    $status = $_POST['status'];

    // Validate status
    if (!in_array($status, ['pending', 'reserved'])) {
        echo json_encode($response);
        exit;
    }

    $query = "UPDATE payment SET process_status = ? WHERE payment_id = ?";
    $stmt = $dbconn->prepare($query);
    $stmt->bind_param("si", $status, $payment_id);

    if ($stmt->execute()) {
        $response['success'] = true;
    }

    $stmt->close();
    $dbconn->close();
}

echo json_encode($response);
