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
    $target_dir = "uploads/";
    // Make sure the target directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    // Specify the path of the file to be uploaded
    $target_file = $target_dir . basename($image["name"]);
    // Upload the file
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Insert advertisement into database
    $db = new DbConnection();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO advertisements (title, description, image_path, until_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $target_file, $until_date);

    if ($stmt->execute()) {
        echo "Advertisement added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
