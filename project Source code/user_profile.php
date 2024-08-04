<?php
include_once('./php/classes/db_connection.php');
include_once('./php/classes/user.php');
session_start();
//remember this
//$_SESSION['user_id'] = "";
//$_SESSION['user_type'] = "";

$db = new DBConnection();
$userId = $_GET['userId'];
if (!empty($_GET['productId'])) {
    $productId = $_GET['productId'];
}

if ($_SESSION['user_type'] == "customer") {
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
            echo "Profile | " . $user->getFirstName() . " " . $user->getLastName();
        } else {
            echo "Profile | " . $user->getBusinessName();
        }
        ?>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body>
    <!--<div class="container mt-5" style="font-size: 1.1rem;">-->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="avatar1.jpg" alt="Profile Photo" class="img-fluid rounded-circle" style="width: 150px;height: 150px;border-radius: 50%;object-fit: cover;">
                <img src="<?= $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle" style="width: 150px;height: 150px;border-radius: 50%;object-fit: cover;">
            </div>
            <div class="col-md-9">
                <!-- dont forget to put other usertypes' differentdata here -->
                <?php
                //phone: should be in icon
                //whatsapp icon leads to the whatsapp chat
                //https://wa.me/94765907934  this link should be merge from the database
                //buttons needs to be added
                ?>
                <h1 class="col-md-3 mb-3"><?= $user->getFirstName() ?> <?= $user->getLastName() ?></h1>
                <h1 class><?= $user->getBusinessName() ?></h1>
                <p class="mb-2"><span class="mr-2">
                        <i class="bi bi-envelope mr-2"></i>
                    </span> <?= $user->getEmail() ?></p>
                <p class="mb-2"><span class="mr-2">
                        <i class="bi bi-telephone mr-2"></i>
                    </span> <a href="tel:+94" .$user->getPhone().'"><?= $user->getPhone() ?></a></p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-whatsapp mr-2"></i>
                    </span>
                    <!-- check digits if need trim -->
                    <a href="https://wa.me/" .$user->getWPhone() target="_blank"><?= $user->getWPhone() ?></a>
                </p>
                <p class="mb-2">
                    <i class="bi bi-geo-alt mr-2"></i>
                    <?= $user->getAddress() ?>
                </p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-info-circle mr-2"></i>
                    </span>
                    <?= $user->getDescription() ?>
                </p>
                <button class="btn btn-primary">Edit</button>

                <h2 class="mt-5">Reviews</h2>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-star mr-2"></i>
                    </span>
                    <span class="rating">
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9734;</span> <!-- empty star for illustration -->
                    </span>
                </p>
            </div>
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