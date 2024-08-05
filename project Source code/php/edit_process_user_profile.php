<?php
include './classes/db_connection.php';
include './classes/UserClass.php';
session_start();

$db = new DbConnection();
$dbconn = $db->getConnection();
$userId = $_GET['id'];//$_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if ($userType == "customer") {
    $dbconn = $db->getConnection();
    $user = User::constructCUSWithUserId($dbconn, $userId);
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    //$dbconn = $db->getConnection();
    //$user = User::constructSPWithProductId($dbconn, $userId, $productId);
    //$photos = $user->getProductPhotos();
} else {
    $dbconn = $db->getConnection();
    $user = User::constructSPWithUserId($dbconn, $userId);
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $businessName = htmlspecialchars($_POST['businessName']);
    $wphone = htmlspecialchars($_POST['wphone']);
    $address = htmlspecialchars($_POST['address']);
    $description = htmlspecialchars($_POST['description']);
    $amountPer = htmlspecialchars($_POST['amountPer']);
}




/*
    if (isset($firstName)) {
        $user->setFirstName($firstName);
    } else {
        $user->setFirstName("Empty");
    }
    if (isset($_POST['lastName'])) {
        $user->setLastName($_POST['lastName']);
    } else {
        $user->setLastName("Empty");
    }
    if (isset($_POST['businessName'])) {
        $user->setBusinessName($_POST['businessName']);
    } else {
        $user->setBusinessName("Empty");
    }
    if (isset($_POST['wphone'])) {
        $user->setWPhone($_POST['wphone']);
    } else {
        $user->setWPhone("Empty");
    }
    if (isset($_POST['address'])) {
        $user->setAddress($_POST['address']);
    } else {
    }
    if (isset($_POST['description'])) {
        $user->setDescription($_POST['description']);
    } else {
        $user->setDescription("Empty");
    }
*/

if ($userType == "customer") {
    $stmt = $dbconn->prepare("UPDATE user SET first_name=?, last_name=? WHERE user_id=?");
    $stmt->bind_param("sss", $firstName, $lastName, $userId);
    $stmt->execute();
} else {
    $stmt = $dbconn->prepare("UPDATE user SET first_name=?, last_name=?, business_name=?, whatsapp_number=?, service_address=?, description=?, amount_per=? WHERE user_id=?");
    $stmt->bind_param("ssssssds", $firstName, $lastName, $businessName, $wphone, $address, $description, $amountPer, $userId);
    $stmt->execute();
}

$dbconn->close();

header("Location: /user_profile.php");
