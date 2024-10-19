<?php
require './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

$sql = "SELECT product_id, name, provider_id, price, quantity FROM product";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo json_encode([]);
    exit;
}

$conn->close();

echo json_encode($products);
?>