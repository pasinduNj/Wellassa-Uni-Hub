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
    <title><?php echo "Reservation | " . $user->getBusinessName(); ?></title>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <img src="<?= '.' . $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle">
                <i class="bi bi-pencil-square position-absolute top-0 start-0 translate-middle bg-white rounded-circle p-2"></i>
            </div>
            <div class="col-md-9">
                <!-- dont forget to put other usertypes' differentdata here -->
                <?php
                //phone: should be in icon
                //whatsapp icon leads to the whatsapp chat
                //https://wa.me/94765907934  this link should be merge from the database
                ?>
                <h1 class="col-md-6 mb-2"><?= $user->getBusinessName() ?></h1>
                <h4 class="col-md-6 mb-3">by <?= $user->getFirstName() ?> <?= $user->getLastName() ?></h4>

                <p class="mb-2"><span class="mr-2">
                        <i class="bi bi-envelope mr-2"></i>
                    </span> <?= $user->getEmail() ?></p>
                <p class="mb-2"><span class="mr-2">
                        <i class="bi bi-telephone mr-2"></i>
                    </span> <a href="tel:+94'.$user->getPhone().'" target="_blank"><?= $user->getPhone() ?></a></p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-whatsapp mr-2"></i>
                    </span>
                    <!-- check digits if need trim -->
                    <a href="https://wa.me/'.$user->getWPhone().'" target="_blank"><?= $user->getWPhone() ?></a>
                </p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-geo-alt mr-2"></i>
                    </span>
                    <?= $user->getAddress() ?>
                </p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-info-circle mr-2"></i>
                    </span>
                    <?= $user->getDescription() ?>
                </p>


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
                        <button class="btn btn-primary" onclick="bookService()">Book</button>
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
        <div class="row">
            <div class="col-12">
                <h2>Photos</h2>
                <div class="d-flex flex-wrap">
                    <?php foreach ($photos as $photoPath) {
                        echo '<div class="card m-2" style="width: 18rem;">';
                        echo '<img src="' . $photoPath . '" class="card-img-top" alt="Image of ' . $providerId . '">';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
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
        function bookService() {
            var userId = '<?php echo $providerId; ?>';
            window.location.href = 'php/Bindex.php?userId=' + encodeURIComponent(userId);
        }

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