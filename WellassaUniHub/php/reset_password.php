<?php
include './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);
$email = htmlspecialchars($_POST['email']);
$contactNumber = htmlspecialchars($_POST['contactNumber']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "SELECT * FROM customers WHERE first_name = '$firstName' AND last_name = '$lastName' AND email = '$email' AND contact_number = '$contactNumber'
          UNION
          SELECT * FROM service_providers WHERE first_name = '$firstName' AND last_name = '$lastName' AND email = '$email' AND contact_number = '$contactNumber'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (isset($row['cus_id'])) {
        $query = "UPDATE customers SET password = '$password' WHERE cus_id = '" . $row['cus_id'] . "'";
    } else {
        $query = "UPDATE service_providers SET password = '$password' WHERE sp_id = '" . $row['sp_id'] . "'";
    }

    if ($conn->query($query) === TRUE) {
        echo "Password updated successfully. Please log in.";
    } else {
        echo "Error updating password: " . $conn->error;
    }
} else {
    echo "No matching user found.";
}

$db->close();
