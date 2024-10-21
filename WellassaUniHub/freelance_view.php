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

// PayHere integration
$merchant_id = '1228450'; // Replace with your PayHere Merchant ID
$merchant_secret = "NjY3MjAxNzYzNDE0NjczMDA5OTQwNDk4MTA0NTEzNTU2MDI4NDA2";
$currency = "LKR";
$order_id = uniqid(); // Generate a unique order ID
$amount = $user->getAmountPer(); // Get the amount from the user object

// Generate hash for PayHere
$hash = strtoupper(md5($merchant_id . $order_id . number_format($amount, 2, '.', '') . $currency . strtoupper(md5($merchant_secret))));



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
                    <img src=".<?= $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getBusinessName() ?>" style="width: 250px;height: 250px;border-radius: 50%;object-fit: cover;">
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

                            <button class="btn btn-success btn-custom" onclick="paymentGateWay()">Pay Now</button>

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
    <script src="https://www.payhere.lk/lib/payhere.js"></script>

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

        // PayHere payment integration
        function paymentGateWay() {
            // First, process the payment on the server side
            $.ajax({
                url: 'php/process_payment_freelance.php',
                method: 'POST',
                data: {
                    customer_id: '<?php echo $customerId; ?>',
                    provider_id: '<?php echo $providerId; ?>',
                    price: <?php echo $amount; ?>
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // If server-side processing is successful, proceed with PayHere
                        payhere.startPayment({
                            sandbox: true,
                            merchant_id: "<?php echo $merchant_id; ?>",
                            return_url: "http://localhost/notify.php",
                            cancel_url: "http://localhost/notify.php",
                            notify_url: "http://localhost/notify.php",
                            order_id: "<?php echo $order_id; ?>",
                            items: "Service Booking",
                            amount: <?php echo $amount; ?>,
                            currency: "<?php echo $currency; ?>",
                            hash: "<?php echo $hash; ?>",
                            first_name: "<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Customer'; ?>",
                            last_name: "",
                            email: "<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'customer@example.com'; ?>",
                            phone: "<?php echo isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : '0000000000'; ?>",
                            address: "<?php echo isset($_SESSION['user_address']) ? $_SESSION['user_address'] : 'Customer Address'; ?>",
                            city: "<?php echo isset($_SESSION['user_city']) ? $_SESSION['user_city'] : 'City'; ?>",
                            country: "Sri Lanka"
                        });
                    } else {
                        showMessage('alert-danger', 'Failed to process payment: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    // Enhanced error logging
                    console.error('AJAX Error Details:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText
                    });

                    let errorMessage = 'An error occurred during payment processing. ';
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        errorMessage += responseJson.message || '';
                    } catch (e) {
                        errorMessage += 'Server response was not in the expected format.';
                    }

                    showMessage('alert-danger', errorMessage);
                }
            });
        }

        // Updated showMessage function with better visibility
        function showMessage(type, message) {
            const popup = $('#messagePopup');
            popup
                .removeClass('alert-success alert-danger')
                .addClass(type)
                .text(message)
                .fadeIn();

            // Position the message at the top of the viewport
            const scrollTop = $(window).scrollTop();
            const navHeight = $('nav').outerHeight() || 0;
            popup.css('top', '$ {scrollTop + navHeight + 20}px');

            // Auto-hide after 5 seconds
            setTimeout(() => popup.fadeOut(), 5000);
        }
    </script>



</body>

</html>