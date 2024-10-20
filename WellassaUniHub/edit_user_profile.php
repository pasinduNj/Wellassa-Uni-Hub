<?php
require './php/classes/db_connection.php';
require './php/classes/UserClass.php';
session_start();
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

$db = new DbConnection();
$dbconn = $db->getConnection();

if ($userType == "customer") {
    $user = User::constructCUSWithUserId($dbconn, $userId);
} else {
    $user = User::constructSPWithUserId($dbconn, $userId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update user info</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Update User Information</h2>
        <form action="./php/edit_process_user_profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="userId" value="<?= $userId ?>">
            <input type="hidden" name="userType" value="<?= $userType ?>">

            <?php
            if ($userType == "customer") {

                echo '<div class="form-group">
              <label for="firstName">First Name</label>
                <input type="text" class="form-control"  name="firstName" value="' . $user->getFirstName() . '">
            </div>';
                echo '<div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control"  name="lastName" value="' . $user->getLastName() . '">
            </div>';
                echo '<div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control"  name="email" value="' . $user->getEmail() . '" readonly>
            </div>';
                echo '<div class="form-group"></div>
                <label for="phone">Phone</label>
                <input type="text" class="form-control"  name="phone" value="' . $user->getPhone() . '">
            </div>';
                echo '<div class="form-group">
                <label for="address">User type</label>
                <input type="text" class="form-control" name="address" value="' . $user->getUserType() . '" readonly>
            </div>';
            } else {

                echo '<div class="form-group">
            <label for="firstName">First Name</label>
              <input type="text" class="form-control"  name="firstName" value="' . $user->getFirstName() . '" >
            </div>';
                echo '<div class="form-group">
              <label for="lastName">Last Name</label>
              <input type="text" class="form-control"  name="lastName" value="' . $user->getLastName() . '">
            </div>';
                echo '<div class="form-group">
                <label for="businessName">Business Name</label>
                <input type="text" class="form-control" name="businessName" value="' . $user->getBusinessName() . '">          
            </div>';
                echo '<div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control"  name="email" value="' . $user->getEmail() . '" readonly>
            </div>';
                echo '<div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control"  name="phone" value="' . $user->getPhone() . '">
            </div>';
                echo '<div class="form-group">
                <label for="wphone">Whatsapp number</label>
                <input type="text" class="form-control" name="wphone" value="' . $user->getWphone() . '">
            </div>';
                echo '<div class="form-group">
                <label for="address">User type</label>
                <input type="text" class="form-control" name="address" value="' . $user->getUserType() . '" readonly>
            </div>';
                echo '<div class="form-group">             
                <label for="nic">NIC</label>
                <input type="text" class="form-control" name="nic" value="' . $user->getNic() . '" readonly>
            </div>';
                echo '<div class="form-group">             
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" value="' . $user->getAddress() . '">
            </div>';
                echo '<div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3">' . $user->getDescription() . '</textarea>
            </div>';
                echo '<div class="form-group">             
                <label for="amountPer">Amount Per Service</label>
                <input type="number" class="form-control" name="amountPer" value="' . $user->getAmountPer() . '">
            </div>';
            }
            ?>
            <div class="form-group">
                <label for="profileImage">Profile Image</label>
                <input type="file" class="form-control-file" name="profileImage">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button> &nbsp;
            <a href="./user_profile.php" class="btn btn-success">Return to Profile</a>

        </form>
    </div>
</body>

</html>