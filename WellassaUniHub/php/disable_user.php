<?php
require './classes/db_connection.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    $db = new DbConnection();
    $conn = $db->getConnection();

    $query = "UPDATE user SET status='disabled' WHERE user_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    if ($stmt->execute()) {
        echo "User disabled successfully.";
    } else {
        echo "Error disabling user.";
    }

    $stmt->close();
    $conn->close();
}
