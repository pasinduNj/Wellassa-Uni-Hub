<?php
require './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

$query = "SELECT user_id, first_name, last_name, email, contact_number, user_type, status FROM user WHERE user_id != 'Admin-Main' ";
$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);

$conn->close();
