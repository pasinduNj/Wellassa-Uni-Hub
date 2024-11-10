<?php
require './php/classes/db_connection.php';
session_start();

$dbconnector = new DBConnection();
$conn = $dbconnector->getConnection();
$userId = $_SESSION['user_id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Directory to save the uploaded image
    //Path will change according to our local machine
    $targetDir = "C:/xampp/htdocs/GitHub/Wellassa-Uni-Hub/WellassaUniHub/assets/img/works_image/";

    // Create the directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Get file information
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];
    $fileSize = $_FILES['image']['size'];
    $fileType = $_FILES['image']['type'];
    $fileError = $_FILES['image']['error'];

    // Allowed file types (you can add more types here)
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];

    // Check if file type is valid
    if (in_array($fileType, $allowedFileTypes)) {
        // Generate a unique file name (to prevent overwriting)
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqnum = time();
        $newFileName = $userId . '_' . $uniqnum . '.' . $fileExtension;

        // Full path to save the image
        $targetFilePath = $targetDir . $newFileName;

        // Check for upload errors
        if ($fileError === UPLOAD_ERR_OK) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                // Save the path to the image
                $savedFilePath = './assets/img/works_image/' . $newFileName;

                //echo "image uploaded successfully!<br>";
                //echo "Image Path: " . $savedFilePath;


                // Saving the file to database
                $stmt = $conn->prepare("INSERT INTO image (user_id, image_path, image_name,modified_date) VALUES (?, ?, ?,NOW())");
                $imageName = $newFileName;

                $stmt->bind_param("sss", $userId, $savedFilePath, $userId);

                if ($stmt->execute()) {

                    header("Location: ./user_profile.php?status=uploaded");
                    exit();
                } else {

                    header("Location: ./user_profile.php?error=exec_error");
                    exit();
                }

                $stmt->close();
            } else {

                header("Location: ./user_profile.php?&error=file_move_failed");
                exit();
            }
        } else {

            header("Location: ./user_profile.php?error=0");
            exit();
        }
    } else {

        header("Location: ./user_profile.php?error=invalid_file_type");
        exit();
    }
} else {

    header("Location: ./user_profile.php?error=0");
    exit();
}
