<?php
include_once('./productsdbconnector.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $provider_id = "SP-004";
 // Generate a unique product ID
    $targetDir = "uploads/";

    $uploadOk = 1;
    $imagePaths = []; // Array to store paths of successfully uploaded images

    foreach ($_FILES['item_image']['name'] as $key => $imageName) {
        $targetFilePath = $targetDir . basename($imageName);
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFilePath)) {
            echo "Sorry, file {$imageName} already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES['item_image']['size'][$key] > 5000000) {
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
            if (move_uploaded_file($_FILES['item_image']['tmp_name'][$key], $targetFilePath)) {
                $imagePaths[] = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file {$imageName}.<br>";
            }
        }
    }

    if ($uploadOk == 1 && !empty($imagePaths)) {
        // Convert the array of image paths to a JSON string
        $imagePathsJson = json_encode($imagePaths);

        // Insert product into database
        $stmt = $pdo->prepare("INSERT INTO product (name, price, quantity, description, category, provider_id, image_paths) VALUES (?, ?, ?, ?, ?, ?, ?)");
       
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $quantity);
        $stmt->bindParam(4, $description);
        $stmt->bindParam(5, $category);
        $stmt->bindParam(6, $provider_id);
        $stmt->bindParam(7, $imagePathsJson);

        if ($stmt->execute()) {
            // Redirect to shop.php after successful addition
            header("Location: shop.php");
            exit();
        } else {
            echo "Error: " . $stmt->errorInfo()[2] . "<br>";
        }
    } else {
        echo "Sorry, your files were not uploaded.<br>";
    }
} else {
    echo "Invalid request method.";
}
?>
