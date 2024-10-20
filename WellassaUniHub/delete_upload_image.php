<?php
require './php/classes/db_connection.php';
session_start();

$dbconnector = new DBConnection();
$conn = $dbconnector->getConnection();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the image path from the POST request
    $imagePath = isset($_POST['imagePath']) ? $_POST['imagePath'] : null;

    if ($imagePath) {
        // Performing database deletion logic
        $query = "DELETE FROM image WHERE user_id= ? AND image_path = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $userId, $imagePath);

        if ($stmt->execute()) {
            // Delete the image file from the server
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Deletes the file
                header("Location: ./user_profile.php?status=deleted");
            } else {
                header("Location: ./user_profile.php?error=image_not_found");
            }
        } else {
            header("Location: ./user_profile.php?error=exec_error");
        }
    } else {
        echo "Invalid image data.";
        header("Location: ./user_profile.php?error=0");
    }
}
?>
