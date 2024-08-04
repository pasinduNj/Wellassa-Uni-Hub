<?php
session_start();
include './classes/db_connection.php';
include './classes/UserClass.php';
$db = new DbConnection();
$dbconn = $db->getConnection();
$user = new User($dbconn);
$userId = $_SESSION['user_id'];

if (isset($_POST['firstName'])){
    $user->setFirstName($_POST['firstName']);
}else{
    $user->setFirstName("Empty");
}
if (isset($_POST['lastName'])){
    $user->setLastName($_POST['lastName']);
}else{
    $user->setLastName("Empty");
}
if (isset($_POST['businessName'])){
    $user->setBusinessName($_POST['businessName']);}
else{
    $user->setBusinessName("Empty");
}
if (isset($_POST['phone'])){
    $user->setPhone($_POST['phone']);
}else{
    $user->setPhone("Empty");
}
if (isset($_POST['wphone'])){
    $user->setWPhone($_POST['wphone']);
}else{
    $user->setWPhone("Empty");
}
if (isset($_POST['address'])){
    $user->setAddress($_POST['address']);
}else{
    $user->setAddress("Empty");
}
if (isset($_POST['description'])){
    $user->setDescription($_POST['description']);
}else{
    $user->setDescription("Empty");
}


$stmt = $this->dbconn->prepare("UPDATE users SET first_name=?, last_name=?, business_name=?, whatsapp_number=?, address=?, description=?, profileImage=?, amount_per=? WHERE userId=?");
$stmt->bind_param("sssssssds", $this->firstName, $this->lastName, $this->businessName, $this->wphone, $this->address, $this->description, $this->profileImage,$this->amountPer, $this->userId);
$stmt->execute();

$conn->close();

header("Location: /user_profile.php");

