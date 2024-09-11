<?php
include './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);
$email = htmlspecialchars($_POST['email']);
$contactNumber = htmlspecialchars($_POST['contactNumber']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "SELECT * FROM user WHERE first_name = '$firstName' AND last_name = '$lastName' AND email = '$email' AND contact_number = '$contactNumber'"    ;

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (isset($row['user_id'])) {
        $query = "UPDATE user SET password = '$password' WHERE user_id = '" . $row['user_id'] . "'";
    }

    if ($conn->query($query) === TRUE) {
        header("Location: ../login.php?S=1");
        exit();
    } else {
        header("Location: ../forgot_password.php?S=1");
        exit();
    }
} else {
    echo "No matching user found.";
}

$db->close();
