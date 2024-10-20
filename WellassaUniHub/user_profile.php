<?php
require './php/classes/db_connection.php';
require './php/classes/UserClass.php';
require_once './php/classes/Review.php';
session_start();

$db = new DBConnection();
$userId = $_SESSION['user_id'];
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
$review = new Review($dbconn);
$averageRating = $review->getAverageRatingByProvider($userId);
$reviews = $review->getReviewsByProviderId($userId);

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

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
                if ($_SESSION['user_type'] == "customer") {
                    echo '<h1 class="col-md-3 mb-3">' . $user->getFirstName() . ' ' . $user->getLastName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</span></a></p>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                } elseif ($_SESSION['user_type'] == "sp_reservation") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>  <a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>  ' . $user->getAddress() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>  ' . $user->getDescription() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>  Reserve advance <b>Rs.' . $user->getAmountPer() . '</b></span></p>';

                    //Display reviews
                    echo '<div class="mb-4">';
                    echo '<h3>Reviews</h3>';
                    echo '<div class="star-rating mb-2">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $averageRating) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($i - 0.5 <= $averageRating) {
                            echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star text-warning"></i>';
                        }
                    }
                    echo '<span class="ml-2">' . number_format($averageRating, 1) . '</span>';
                    echo '</div>';

                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                    echo '<a href="./add_timeslot.php"><button class="btn btn-primary mt-auto mb-3">Add Time Slot</button></a>';
                    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Image</button>';
                } elseif ($_SESSION['user_type'] == "sp_freelance") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>  <a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>  ' . $user->getAddress() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>  ' . $user->getDescription() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>  Reserve advance <b>Rs.' . $user->getAmountPer() . '</b></span></p>';
                    //Display reviews
                    echo '<div class="mb-4">';
                    echo '<h3>Reviews</h3>';
                    echo '<div class="star-rating mb-2">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $averageRating) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($i - 0.5 <= $averageRating) {
                            echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star text-warning"></i>';
                        }
                    }
                    echo '<span class="ml-2">' . number_format($averageRating, 1) . '</span>';
                    echo '</div>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Image</button>';
                } elseif ($_SESSION['user_type'] == "sp_products") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">'  . $user->getPhone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>  <a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>  ' . $user->getAddress() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>  ' . $user->getDescription() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>  Reserve advance <b>Rs.' . $user->getAmountPer() . '</b></p>';
                    //Display reviews
                    echo '<div class="mb-4">';
                    echo '<h3>Reviews</h3>';
                    echo '<div class="star-rating mb-2">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $averageRating) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($i - 0.5 <= $averageRating) {
                            echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star text-warning"></i>';
                        }
                    }
                    echo '<span class="ml-2">' . number_format($averageRating, 1) . '</span>';
                    echo '</div>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                    echo '<a href="./add_product.php"><button class="btn btn-primary mt-auto mb-3">Add Product</button></a>';
                    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Image</button>';
                }

                ?>

            </div>
        </div>
    </div>
    <hr>

    <?php
    if ($_SESSION['user_type'] !== "customer") {
        echo '<div class="row">';
        echo '<div class="col-12" >';
        echo '<h2>Photos</h2>';
        echo '<div class="d-flex flex-wrap" style="align-items:center;justify-content:center;">';
        // SQL query to select data
        $dbconnector = new DbConnection();
        $conn = $dbconnector->getConnection();

        //sql query for getting data
        $sql = "SELECT image_path,image_name FROM image where user_id= '" . $userId . "' ";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card m-2" style="align-items:center;border: none;">';
                echo '<img src="' . $row['image_path'] . '" class="card-img-top" alt="Image of ' . $row['image_name'] . '" style="width: 250px;height: 250px;">';
                echo '<button type="button" class="btn btn-danger" style="margin-top: 10px;" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Image</button>';
                echo '</div>';
                echo '
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this image?
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: center; gap: 10px; border-top: none;">
                                        <form method="POST" action="delete_upload_image.php" style="border: none; margin: 0; display: flex; gap: 10px;">
                                            <input type="hidden" name="imagePath" value="' . $row['image_path'] . '">
                                            <button type="submit" class="btn btn-danger" style="border: none;">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }

    }
    echo '<br>';
    include './footer.php'; 
    ?>
    
<?php 
    //The popup prompt for upload image
    echo '<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="uploadModelLabel">Upload Image</h5>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<form action="./user_profile_upload_image.php" method="post" enctype="multipart/form-data" style="border:none;">';
    echo '<div class="mb-3">';
    echo '<label for="image" class="form-label">Select image to upload:</label>';
    echo '<input type="file" name="image" id="image" class="form-control" required>';
    echo '</div>';
    echo '<div class="modal-footer" style="border:none;">';
    echo '<button type="submit" class="btn btn-primary" name="submit">Upload</button>';
    echo '<div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>'; 
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
                    case 'uploaded':
                        messageElement.textContent = 'New image inserted successfully.';
                        messageElement.classList.add('success');
                        break;
                    case 'deleted':
                        messageElement.textContent = 'The image deleted successfully.';
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
                    case 'exec_error':
                        messageElement.textContent = 'Database update failed. Please try again or contact support.';
                        break;
                    case 'file_move_failed':
                        messageElement.textContent = 'Failed to move uploaded file. Please try again or contact support.';
                        break;
                    case 'image_not_found':
                        messageElement.textContent = 'The image not found in the directory. Please try again or contact support.';
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


    function deleteImage(imagePath) {
        // Confirmation dialog
        if (confirm("Are you sure you want to delete this image?")) {
            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_upload_image.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Handle response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Check if the response indicates success
                    if (xhr.responseText.includes("Image deleted successfully")) {
                        location.reload(); // Reloads the page
                    }
                }
            };

            // Send the image path to the server
            xhr.send("imagePath=" + encodeURIComponent(imagePath));
        }
    }
</script>

</html> 