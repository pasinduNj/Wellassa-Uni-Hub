<?php
require './php/classes/db_connection.php';
require './php/classes/UserClass.php';
session_start();

$db = new DBConnection();
$userId = $_SESSION['user_id']; //$_GET['userId'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        <?php
        if ($_SESSION['user_type'] == "customer") {
            echo "Profile | " . $user->getFirstName() . " " . $user->getLastName();
        } else {
            echo "Profile | " . $user->getBusinessName();
        }
        ?>
    </title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        #statusMessage {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

</head>

<body>
    <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    ?>

    <!--<div class="container mt-5" style="font-size: 1.1rem;">-->
    <div class="container mt-5">
        <div id="statusMessage"></div>
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="<?= '.' . $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle" style="width: 200px;height: 200px;border-radius: 50%;object-fit: cover;">
                <i class="bi bi-pencil-square position-absolute top-0 start-0 translate-middle bg-white rounded-circle p-2"></i>
            </div>
            <div class="col-md-9">
                <?php
                //phone: should be in icon
                //whatsapp icon leads to the whatsapp chat
                //https://wa.me/944  this link should be merge from the database
                //buttons needs to be added
                if ($_SESSION['user_type'] == "customer") {
                    echo '<h1 class="col-md-3 mb-3">' . $user->getFirstName() . ' ' . $user->getLastName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>' . $user->getEmail() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span> <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</a></p>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary rounded-pill mt-auto mb-3">Edit Profile</button></a>';
                } elseif ($_SESSION['user_type'] == "sp_reservation") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>' . $user->getEmail() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span><a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2"></i></span><a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>' . $user->getAddress() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>' . $user->getDescription() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>Reserve advance Rs.' . $user->getAmountPer() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2">Reviews :</span><span class="rating"><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9734;</span></span></p>'; //empty star for illustration
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary rounded-pill mt-auto mb-3">Edit Profile</button></a>';
                    echo '<a href="./add_timeslot.php"><button class="btn btn-primary rounded-pill mt-auto mb-3">Add Time Slot</button></a>';
                } elseif ($_SESSION['user_type'] == "sp_freelance") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>' . $user->getEmail() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span><a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2"></i></span><a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>' . $user->getAddress() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>' . $user->getDescription() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>Reserve advance Rs.' . $user->getAmountPer() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2">Reviews :</span><span class="rating"><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9734;</span></span></p>'; //empty star for illustration
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary rounded-pill mt-auto mb-3">Edit Profile</button></a>';
                } else {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>' . $user->getEmail() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span><a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2"></i></span><a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>' . $user->getAddress() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>' . $user->getDescription() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2">Reviews :</span><span class="rating"><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9733;</span><span class="text-warning">&#9734;</span></span></p>'; //empty star for illustration
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary rounded-pill mt-auto mb-3">Edit Profile</button></a>';
                    echo '<a href="./add_product.php"><button class="btn btn-primary rounded-pill mt-auto mb-3">Add Product</button></a>';
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
        /*echo '<div class="modal fade" id="uploadPopup" tabindex="-1" aria-labelledby="uploadWindow" aria-hidden="true">';
        echo '<div class="modal-dialog">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="uploadWindow">Upload Image</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="modal-body">';
            echo '<form action="./edit_user.php" method="post" enctype="multipart/form-data">';
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
*/

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
    <br>
    <?php
    include './footer.php';
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="assets/js/script.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const error = urlParams.get('error');
        const messageElement = document.getElementById('statusMessage');

        if (status || error) {
            if (status) {
                switch (status) {
                    case 'success':
                        messageElement.textContent = 'Profile updated successfully with new image!';
                        messageElement.classList.add('success');
                        break;
                    case 'success_no_image':
                        messageElement.textContent = 'Profile updated successfully without changing the image.';
                        messageElement.classList.add('success');
                        break;
                    default:
                        messageElement.textContent = 'An unknown status occurred. Please try again.';
                        messageElement.classList.add('error');
                }
            } else if (error) {
                switch (error) {
                    case 'invalid_file_type':
                        messageElement.textContent = 'Invalid file type. Please choose a valid image file (JPEG, PNG, or GIF).';
                        break;
                    case 'file_too_large':
                        messageElement.textContent = 'File is too large. Maximum size allowed is 5 MB.';
                        break;
                    case 'directory_creation_failed':
                        messageElement.textContent = 'Failed to create upload directory. Please contact support.';
                        break;
                    case 'directory_not_writable':
                        messageElement.textContent = 'Upload directory is not writable. Please contact support.';
                        break;
                    case 'database_prepare_failed':
                        messageElement.textContent = 'Database prepare statement failed. Please try again or contact support.';
                        break;
                    case 'database_update_failed':
                        messageElement.textContent = 'Database update failed. Please try again or contact support.';
                        break;
                    case 'file_move_failed':
                        messageElement.textContent = 'Failed to move uploaded file. Please try again or contact support.';
                        break;
                    default:
                        messageElement.textContent = 'An unknown error occurred. Please try again or contact support.';
                }
                messageElement.classList.add('error');
            }
            showMessage();
        }

        function showMessage() {
            messageElement.style.display = 'block';
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 5000);
        }
    });
</script>

</html>