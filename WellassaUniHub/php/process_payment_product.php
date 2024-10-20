<?php
require_once './classes/db_connection.php';

// Initialize database connection
$db = new DbConnection();
$conn = $db->getConnection();

// Function to insert payment and update product quantity
function processPayment($conn, $customer_id, $provider_id, $product_id, $price, $quantity = 1)
{
    $total = $price * $quantity;
    $status = 'paid';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into payment table
        $sql = "INSERT INTO payment (customer_id, provider_id, product_id, price, quantity, total, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiis", $customer_id, $provider_id, $product_id, $price, $quantity, $total, $status);
        $paymentInserted = $stmt->execute();

        if ($paymentInserted) {
            // Update product quantity
            // Note: We've changed 'id' to 'product_id' here. Adjust if your column name is different.
            $sql = "UPDATE product SET quantity = quantity - 1 WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $product_id);
            $quantityUpdated = $stmt->execute();

            if ($quantityUpdated) {
                // If both operations are successful, commit the transaction
                $conn->commit();
                return ['success' => true, 'message' => 'Payment processed successfully'];
            }
        }

        // If we reach here, something went wrong
        throw new Exception("Failed to process payment");
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $conn->rollback();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? '';
    $provider_id = $_POST['provider_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $price = $_POST['price'] ?? 0;

    if (!$customer_id || !$provider_id || !$product_id || !$price) {
        $result = ['success' => false, 'message' => 'Missing required parameters'];
    } else {
        $result = processPayment($conn, $customer_id, $provider_id, $product_id, $price);
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
