<?php

include_once 'db_connection.php';
include_once 'UserClass.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $productId = $_SESSION['product_id'];
    $imagePath = htmlspecialchars($_POST['image_path']);

    $db = new DBConnection();
    $conn = $db->getConnection();
    if(!empty($productId)){
        $user = User::constructSPWithProductId($conn, $userId, $productId);
    }else{
        $user = User::constructSPWithUserId($conn, $userId);
        $user->addPhoto($userId, $imagePath);
    }
}

?>