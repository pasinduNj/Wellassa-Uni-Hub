<?php
session_start();

// Assuming session contains user ID
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reviews_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT first_name FROM customers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name);
$stmt->fetch();
$stmt->close();

$rating = $_POST['rating'];
$feedback = $_POST['feedback'];

$sql = "INSERT INTO feedback (user_id, rating, feedback) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $rating, $feedback);
$stmt->execute();
$stmt->close();

$conn->close();

echo "Thank you, $first_name, for your feedback!";
?>
