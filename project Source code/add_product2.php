<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './php/classes/db_connection.php';

// Create a class for handling product operations
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addProduct($name, $price, $quantity, $description, $category, $provider_id, $image_path) {
        $stmt = $this->conn->prepare("INSERT INTO product (name, price, quantity, description, category, provider_id, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdissss", $name, $price, $quantity, $description, $category, $provider_id, $image_path);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

// Initialize database connection and product class
$db = new DbConnection();
$conn = $db->getConnection();
$product = new Product($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $provider_id = 'default_provider'; // Change this if needed
    $image_path = '';

    if (!empty($_FILES['image']['name'])) {
        $image_name = "prod_img_" . basename($_FILES['image']['name']);
        $target_dir = "assets/img/products/";
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    if ($product->addProduct($name, $price, $quantity, $description, $category, $provider_id, $image_path)) {
        header("Location: shop.php");
        exit();
    } else {
        echo "Error adding product.";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
