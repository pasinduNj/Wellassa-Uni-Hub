<?php

//it should comfirm to be used
include_once 'classes/db_connection.php';
include_once 'classes/UserClass.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $productId = "";//$_SESSION['product_id'];
    $imagePath = $_POST['image'];

    $db = new DBConnection();
    $conn = $db->getConnection();
    if (!empty($productId)) {
        $user = User::constructSPWithProductId($conn, $userId, $productId);
    } else {
        $user = User::constructSPWithUserId($conn, $userId);
        $user->addPhoto($userId, $imagePath);

        $target_dir = "assets/img/works_image/";
        // Get file extension
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        // Generate a new name for the file
        $newFileName = $userId . '.' . $imageFileType;
        // Full path to save the file
        $target_file = $target_dir . $newFileName;

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $user->addPhoto($userId, $target_file);
                //header("Location: index.php");

            } else {
                echo "Error occured in uploading image.";
            }
        } else {
            echo "Unsupported format.";
        }
    }
}
