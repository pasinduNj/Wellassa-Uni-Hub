<?php
$servername = "localhost";
$username = "unihub";
$password = "Unihub@1234";
$dbname = "wellassaunihub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
