<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './classes/db_connection.php';
require_once './classes/Product.php';

session_start();

$db = new DbConnection();
$conn = $db->getConnection();
$product = new Product($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "POST request received.<br>"; // Debug statement
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $provider_id = $_SESSION['user_id']; // Change this if needed
    $image_path = '';

    if (!empty($_FILES['image']['name'])) {
        $image_name = "prod_img_" . basename($_FILES['image']['name']);
        // Use __DIR__ to get the absolute path to the current PHP file
        $target_dir = "C:/xampp/htdocs/GitHub_Projects/Project1/WellassaUniHub/assets/img/products/";

        $target_file = $target_dir . $image_name;

        // Debug paths
        echo "Target Directory: " . $target_dir . "<br>";
        echo "Target File: " . $target_file . "<br>";

        // Make sure the directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
            echo "Directory created.<br>"; // Debug statement
        }

        // Move the uploaded file to the correct directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Save the relative path to the database (for display in HTML)
            $image_path = "/assets/img/products/" . $image_name;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    if ($product->addProduct($name, $price, $quantity, $description, $category, $provider_id, $image_path)) {
        header("Location: ../shop.php");
        exit();
    } else {
        echo "Error adding product.";
    }
} else {
    echo "Invalid request method: " . $_SERVER["REQUEST_METHOD"]; // Debug statement
    http_response_code(405);
    echo "Method Not Allowed";
}
