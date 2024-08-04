<?php
include_once('./Untitled/project Source code/php/classes/db_connection.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // For now, we use a static provider_id. Adjust this as per your needs.
    $provider_id = "static_provider_id";

    $product_id = uniqid(); 
    $targetDir = "uploads/";
    $uploadOk = 1;
    $imagePath = "";

    // Handle single image upload
    $imageName = basename($_FILES['item_image']['name']);
    $targetFilePath = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFilePath)) {
        echo "Sorry, file {$imageName} already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES['item_image']['size'] > 5000000) {
        echo "Sorry, your file {$imageName} is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. {$imageName} is not allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file {$imageName} was not uploaded.<br>";
    } else {
        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;
        } else {
            echo "Sorry, there was an error uploading your file {$imageName}.<br>";
            $uploadOk = 0;
        }
    }

    if ($uploadOk == 1 && !empty($imagePath)) {
        // Establish connection
        $db = new DbConnection();
        $conn = $db->getConnection();

        // Create SQL query
        $sql = "INSERT INTO product (product_id, name, price, quantity, description, category, provider_id, image_path) 
                VALUES ('$product_id', '$name', '$price', '$quantity', '$description', '$category', '$provider_id', '$imagePath')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Record successfully inserted!";
            // Redirect to shop.php after successful addition
            header("Location: shop.php");
            exit();
        } else {
            echo "Error: " . $conn->error . "<br>";
        }

        // Close the connection
        $db->close();
    } else {
        echo "Sorry, your file was not uploaded.<br>";
    }
} else {
    echo "Invalid request method.";
}
?>
