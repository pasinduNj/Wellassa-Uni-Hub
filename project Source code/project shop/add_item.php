<?php
include_once('./productsdbconnector.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $providerid = $_POST['providerid'];

    $targetDir = "uploads/";
    $imageName = basename($_FILES["item_image"]["name"]);
    $targetFilePath = $targetDir . $imageName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFilePath)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["item_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFilePath)) {
            // Generate a unique product ID (you can use UUID or any other method based on your preference)
            $productid = uniqid();

            // Insert product into database
            $stmt = $pdo->prepare("INSERT INTO product (productid, name, price, description, category, providerid, image_path, image_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $productid);
            $stmt->bindParam(2, $name);
            $stmt->bindParam(3, $price);
            $stmt->bindParam(4, $description);
            $stmt->bindParam(5, $category);
            $stmt->bindParam(6, $providerid);
            $stmt->bindParam(7, $targetFilePath);
            $stmt->bindParam(8, $imageName);

            if ($stmt->execute()) {
                echo "The file " . htmlspecialchars($imageName) . " has been uploaded and the product has been added to the database.";
                // Redirect to shop.php after successful addition
                header("Location: shop.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
