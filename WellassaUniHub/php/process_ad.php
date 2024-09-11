<?php
require './classes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];
    $until_date = $_POST['until_date'];

    // Check if image file is an actual image or fake image
    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        die("File is not an image.");
    }

    // Specify the directory where the file is going to be placed
    $target_dir = __DIR__ . "/../assets/img/advertisements/";
    // Make sure the target directory exists
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die("Failed to create directory.");
        }
    }
    
    // Generate a unique filename
    $file_extension = pathinfo($image["name"], PATHINFO_EXTENSION);
    $unique_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $unique_filename;
    
    // Upload the file
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file. Error: " . error_get_last()['message']);
    }

    // Insert advertisement into database
    $db = new DbConnection();
    $conn = $db->getConnection();

    $relative_path = "/assets/img/advertisements/" . $unique_filename;
    $stmt = $conn->prepare("INSERT INTO advertisements (title, description, image_path, until_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $relative_path, $until_date);

    if ($stmt->execute()) {
        header("Location: ../add_ad.php?S=1");
        exit();
    } else {
        unlink($target_file); // Remove the uploaded file if database insertion fails
        header("Location: ../add_ad.php?S=0");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>