<?php
include_once('./php/classes/db_connection.php');
include_once('./php/classes/UserClass.php');
session_start();
//remember this
$_SESSION['user_id'] = "SP-002";
$_SESSION['user_type'] = "sp_freelance";

$db = new DBConnection();
$userId = "SP-001"; //"$_GET['userId'];
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
                <img src="<?= $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle" style="width: 150px;height: 150px;border-radius: 50%;object-fit: cover;">
                <i class="bi bi-pencil-square position-absolute top-0 start-0 translate-middle bg-white rounded-circle p-2"></i>
            </div>
            <div class="col-md-9">
                <?php
                //phone: should be in icon
                //whatsapp icon leads to the whatsapp chat
                //https://wa.me/94765907934  this link should be merge from the database
                //buttons needs to be added
                if ($_SESSION['user_type'] == "customer") {
                    echo '<h1 class="col-md-3 mb-3">' . $user->getFirstName() . ' ' . $user->getLastName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>' . $user->getEmail() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span> <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</a></p>';
                    echo '<button class="btn btn-primary">Edit</button>';
                } else {
                    echo '<h1 class="col-md-3 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>' . $user->getEmail() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span><a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2"></i></span><a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>' . $user->getAddress() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>' . $user->getDescription() . '"</p>';
                    echo '<button class="btn btn-primary">Edit</button>';
                    echo '<p class="mb-2"><span class="mr-2">Reviews :</span><span class="rating"><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9734;</span></span></p>'; //empty star for illustration
                }
                ?>
            </div>
        </div>
    </div>
    <hr>

    <?php
    if ($_SESSION['user_type'] !== "customer") {
        echo '<div class="row">';
        echo '<div class="col-12">';
        echo '<h2>Photos</h2>';
        echo '<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#uploadPopup">Add Photo</button>';

        //The popup prompt for upload image
        echo '<div class="modal fade" id="uploadPopup" tabindex="-1" aria-labelledby="uploadWindow" aria-hidden="true">';
        echo '<div class="modal-dialog">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="uploadWindow">Upload Image</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '<div class="form-group">';
        echo '<label for="image">Select to upload</label>';
        echo '<input type="file" class="form-control-file" name="image" required>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary" name="submit">Upload</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';


        echo '<div class="d-flex flex-wrap">';
        echo '<div class="card m-2" style="width: 18rem;">';
        foreach ($photos as $photoPath) {

            echo '<img src=' . $photoPath . '" class="card-img-top" alt="...">';
            echo '<div class="card-body">';
            // we should  make proper delete option
            echo '<button class="btn btn-danger">Delete</button>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>