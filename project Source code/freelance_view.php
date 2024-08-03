<?php
include_once('./php/classes/db_connection.php');
include_once('./php/classes/user.php');
session_start();

$db = new DBConnection();
$userId = $_GET['userId'];
if (!empty($_GET['productId'])) {
    $productId = $_GET['productId'];
}

if ($_SESSION['user_type'] == "customer" || $_SESSION['user_type'] == "admin") {
    $dbconn = $db->getConnection();
    $user = User::constructCUSWithUserId($dbconn, $userId);
} else {
    if (isset($productId)) {
        $dbconn = $db->getConnection();
        $user = User::constructSPWithProductId($dbconn, $userId, $productId);
        $photos = $user->getProductPhotos();
    } else {
        $dbconn = $db->getConnection();
        $user = User::constructSPWithUserId($dbconn, $userId);
        $photos = $user->getPhotos();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php
        if ($_SESSION['user_type'] == "customer") {
            echo "Prfile|" . $user->getFirstName() . " " . $user->getLastName();
        } else {
            echo "Profile|" . $user->getBusinessName();
        }
        ?>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <img src="<?= $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid">
                <button class="btn btn-primary mt-2">Edit</button>
            </div>
            <div class="col-md-9">
                <!-- dont forget to put other usertypes' differentdata here -->
                <?php
                //phone: should be in icon
                //whatsapp icon leads to the whatsapp chat
                //https://wa.me/94765907934  this link should be merge from the database
                ?>
                <h1><?= $user->getBusinessName() ?></h1>
                <p><strong>Phone:</strong> <?= $user->getPhone() ?>, <?= $user->getWPhone() ?></p>
                <p><strong>Email:</strong> <?= $user->getEmail() ?></p>
                <p><strong>Address:</strong> <?= $user->getAddress() ?></p>
                <p><strong>Description:</strong> <?= $user->getDescription() ?></p>
                <button class="btn btn-primary">Edit</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h2>Photos</h2>
                <button class="btn btn-success mb-2">Add Photo</button>
                <div class="d-flex flex-wrap">
                    <?php foreach ($photos as $photo) : ?>
                        <div class="card m-2" style="width: 18rem;">
                            <img src="<?= $photo ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>