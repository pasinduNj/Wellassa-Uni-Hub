<?php
require './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

$sql = "SELECT payment_id, customer_id, price, date_time, status FROM payment";

$result = $conn->query($sql);

$payments = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
}

$conn->close();

echo json_encode($payments);
?>


