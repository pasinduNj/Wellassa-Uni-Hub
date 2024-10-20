<?php
include_once('./php/classes/db_connection.php');
include_once('./php/classes/UserClass.php');
require_once './php/classes/Review.php';
session_start();

$db = new DBConnection();
$customerId = $_SESSION['user_id'];
$providerId = $_GET['userId'];
if (!empty($_GET['productId'])) {
    $productId = $_GET['productId'];
}

if (isset($productId)) {
    $dbconn = $db->getConnection();
    $user = User::constructSPWithProductId($dbconn, $providerId, $productId);
    $photos = $user->getProductPhotos();
} else {
    $dbconn = $db->getConnection();
    $user = User::constructSPWithUserId($dbconn, $providerId);
    $photos = $user->getPhotos();
}


$review = new Review($dbconn);
$averageRating = $review->getAverageRatingByProvider($providerId);
$reviews = $review->getReviewsByProviderId($providerId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo "Freelancer | " . $user->getBusinessName(); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo|Cinzel|Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        .star-rating {
            color: #ffc107;
            /* Bootstrap warning color for stars */
        }

        .rate-star {
            cursor: pointer;
            font-size: 1.5em;
            transition: color 0.2s;
        }

        .rate-star:hover {
            color: #ffaa00;
        }

        /* Optional: Add some spacing between stars */
        .rate-star+.rate-star {
            margin-left: 5px;
        }


        #messagePopup {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: none;
            min-width: 250px;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
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

    <main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <img src=".<?= $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getBusinessName() ?>"  style="width: 250px;height: 250px;border-radius: 50%;object-fit: cover;"	>
                </div>
                <div class="col-md-9">
                    <!-- dont forget to put other usertypes' differentdata here -->
                    <?php
                    //phone: should be in icon
                    //whatsapp icon leads to the whatsapp chat
                    //https://wa.me/94765907934  this link should be merge from the database
                    ?>
                    <h1 class="col-md-3 mb-3"><?= $user->getBusinessName() ?></h1>
                    <p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span> <?= $user->getEmail() ?></p>
                    <p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span> <a href="tel:+94'.$user->getPhone().'" target="_blank"><?= $user->getPhone() ?></a></p>
                    <p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>
                        <!-- check digits if need trim -->
                        <a href="https://wa.me/<?= $user->getWPhone() ?>" target="_blank"><?= $user->getWPhone() ?></a>
                    </p>
                    <p class="mb-2"><i class="bi bi-geo-alt mr-2"></i><?= $user->getAddress() ?></p>
                    <p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span><?= $user->getDescription() ?></p>
                    <p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>Reserve an advance with <b>Rs. <?= $user->getAmountPer() ?></b></p>
                    <br>

                    <!--Display photos-->
                    <div class="row">
                        <div class="col-12">
                            <h2>Photos</h2>
                            <div class="d-flex flex-wrap">
                                <?php
                                // SQL query to select data
                                $dbconnector = new DbConnection();
                                $conn = $dbconnector->getConnection();

                                //sql query for getting data
                                $sql = "SELECT image_path,image_name FROM image where user_id= '" . $providerId . "' ";

                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="card m-2" style="">';
                                        echo '<img src="' . $row['image_path'] . '" class="card-img-top" alt="Image of ' . $row['image_name'] . '" style="width: 250px;height: 250px;">';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!--display the reviews -->
                    <div class="mb-4">
                        <h3>Reviews</h3>
                        <div class="star-rating mb-2">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $averageRating) {
                                    echo '<i class="bi bi-star-fill text-warning"></i>';
                                } elseif ($i - 0.5 <= $averageRating) {
                                    echo '<i class="bi bi-star-half text-warning"></i>';
                                } else {
                                    echo '<i class="bi bi-star text-warning"></i>';
                                }
                            }
                            ?>
                            <span class="ml-2"><?php echo number_format($averageRating, 1); ?></span>
                        </div>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $providerId): ?>

                            <a href="./cart.php"><button class="btn btn-primary" onclick="">Pay now</button></a>

                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                Write a Review
                            </button>
                        <?php endif; ?>

                        <div id="reviewsContainer">
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item mb-3 p-3 border rounded">
                                    <div class="star-rating">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $review['user_rating']) {
                                                echo '<i class="bi bi-star-fill text-warning"></i>';
                                            } else {
                                                echo '<i class="bi bi-star text-warning"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <p class="mb-1"><strong><?php echo htmlspecialchars($review['user_name']); ?></strong> - <?php echo date('F j, Y', strtotime($review['datetime'])); ?></p>
                                    <p class="mb-0"><?php echo htmlspecialchars($review['user_review']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Review Modal -->
                    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="reviewForm">
                                        <input type="hidden" name="provider_id" value="<?php echo htmlspecialchars($providerId); ?>">
                                        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customerId); ?>">
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Rating</label>
                                            <div class="star-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="bi bi-star rate-star" data-rating="<?php echo $i; ?>" style="cursor: pointer; font-size: 1.5em;"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <input type="hidden" name="rating" id="rating" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="review" class="form-label">Your Review</label>
                                            <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="width: 95%;">Submit Review</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

        </div>
    </main>
    <!--Footer-->

    <div class="container py-4 py-lg-5">
        <hr>
        <div class="text-muted d-flex justify-content-between align-items-center pt-3">
            <p class="mb-0">Copyright © 2024 Brand</p>
            <ul class="list-inline mb-0">
                <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
                    </svg></li>
                <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15"></path>
                    </svg></li>
                <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"></path>
                    </svg></li>
            </ul>
        </div>
    </div>

    <?php
    include './footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <!-- Message Popup -->
    <div id="messagePopup" class="alert" role="alert"></div>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function showMessage(message, type) {
            const popup = $('#messagePopup');

            // Update popup content and styling
            popup.text(message)
                .removeClass('alert-success alert-danger')
                .addClass(`alert-${type}`)
                .css('display', 'block'); // Make sure it's visible

            // Ensure the popup is in the viewport
            const navbarHeight = $('nav').outerHeight();
            popup.css('top', `${navbarHeight + 20}px`);

            // Fade out after delay
            setTimeout(() => {
                popup.fadeOut();
            }, 3000); // Increased to 3 seconds for better visibility
        }

        $(document).ready(function() {
            // Ensure the message popup div exists in the DOM
            if (!$('#messagePopup').length) {
                $('body').append('<div id="messagePopup" class="alert" role="alert" style="display: none;"></div>');
            }
            // Star rating functionality
            $(document).on('click', '.rate-star', function() {
                const rating = $(this).data('rating');
                $('#rating').val(rating);

                // Reset all stars
                $('.rate-star').each(function() {
                    $(this).removeClass('bi-star-fill').addClass('bi-star');
                });

                // Fill stars up to the selected rating
                $('.rate-star').each(function() {
                    if ($(this).data('rating') <= rating) {
                        $(this).removeClass('bi-star').addClass('bi-star-fill');
                    }
                });
            });

            // Hover effects for better user experience
            $(document).on('mouseenter', '.rate-star', function() {
                const rating = $(this).data('rating');

                $('.rate-star').each(function() {
                    if ($(this).data('rating') <= rating) {
                        $(this).removeClass('bi-star').addClass('bi-star-fill');
                    }
                });
            });

            $(document).on('mouseleave', '.star-rating', function() {
                const currentRating = $('#rating').val();

                $('.rate-star').each(function() {
                    if ($(this).data('rating') <= currentRating) {
                        $(this).removeClass('bi-star').addClass('bi-star-fill');
                    } else {
                        $(this).removeClass('bi-star-fill').addClass('bi-star');
                    }
                });
            });

            $('#reviewForm').on('submit', function(e) {
                e.preventDefault();

                // Validate rating
                const rating = $('#rating').val();
                if (!rating) {
                    showMessage('Please select a rating', 'danger');
                    return;
                }

                $.ajax({
                    url: 'feedback.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Hide the modal
                            $('#reviewModal').modal('hide');

                            // Show success message
                            showMessage(response.message, 'success');

                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            showMessage(response.message, 'danger');
                        }
                    },
                    error: function() {
                        showMessage('An error occurred. Please try again.', 'danger');
                    }
                });
            });
        });
    </script>



</body>

</html>