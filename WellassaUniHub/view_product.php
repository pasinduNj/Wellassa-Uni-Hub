<?php
// Database connection (replace with your own connection logic)
require_once './php/classes/db_connection.php';
require_once './php/classes/Product.php';
require_once './php/classes/Review.php';
session_start();

// Initialize database connection and product class
$db = new DbConnection();
$conn = $db->getConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = new Product($conn);
$productDetails = $product->getProductById($id);

$review = new Review($conn);
$averageRating = $review->getAverageRating($id);
$reviews = $review->getReviewsByProductId($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .product-image {
            max-width: 300px;
            height: auto;
            object-fit: cover;
        }

        .btn-style {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .btn-custom {
            width: 50%;
            padding: 10px 0;
            text-align: center;
            outline: none;
            border: none;
        }

        .btn-custom:hover,
        .btn-custom:focus {
            outline: none;
        }

        .star-rating {
            color: #ffc107;
        }

        .review-item {
            border-bottom: 1px solid #dee2e6;
            padding: 10px 0;
        }

        #messagePopup {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: none;
        }

        /* Additional styles for navbar */
        .navbar-shrink {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .bs-icon {
            --bs-icon-size: .75rem;
            display: flex;
            flex-shrink: 0;
            justify-content: center;
            align-items: center;
            font-size: var(--bs-icon-size);
            width: calc(var(--bs-icon-size) * 2);
            height: calc(var(--bs-icon-size) * 2);
            color: var(--bs-primary);
        }

        .bs-icon-xs {
            --bs-icon-size: 1rem;
            width: calc(var(--bs-icon-size) * 1.5);
            height: calc(var(--bs-icon-size) * 1.5);
        }

        .bs-icon-sm {
            --bs-icon-size: 1rem;
        }

        .bs-icon-md {
            --bs-icon-size: 1.5rem;
        }

        .bs-icon-lg {
            --bs-icon-size: 2rem;
        }

        .bs-icon-xl {
            --bs-icon-size: 2.5rem;
        }

        .bs-icon.bs-icon-primary {
            color: var(--bs-white);
            background: var(--bs-primary);
        }

        .bs-icon.bs-icon-primary-light {
            color: var(--bs-primary);
            background: rgba(var(--bs-primary-rgb), .2);
        }

        .bs-icon.bs-icon-semi-white {
            color: var(--bs-primary);
            background: rgba(255, 255, 255, .5);
        }

        .bs-icon.bs-icon-rounded {
            border-radius: .5rem;
        }

        .bs-icon.bs-icon-circle {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include './navbar2.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Product Details</h2>

        <?php if ($productDetails) : ?>
            <div class="row">
                <div class="col-md-6">
                    <?php if (!empty($productDetails['image_path'])) : ?>
                        <img src="<?php echo htmlspecialchars('.' . $productDetails['image_path']); ?>" class="product-image img-fluid" alt="Product Image">
                    <?php else : ?>
                        <p>No image available.</p>
                    <?php endif; ?>
                    <!-- Display average rating -->
                    <div class="mt-3">
                        <h4>Average Rating</h4>
                        <div class="star-rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $averageRating) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif ($i - 0.5 <= $averageRating) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span class="ml-2"><?php echo number_format($averageRating, 1); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($productDetails['name']); ?></h2>
                    <p><?php echo htmlspecialchars($productDetails['description']); ?></p>
                    <p><strong>Price:</strong> LKR <?php echo htmlspecialchars($productDetails['price']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($productDetails['category']); ?></p>

                    <!-- Add to Cart Button -->
                    <form action="add_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productDetails['name']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($productDetails['price']); ?>">
                        <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($productDetails['image_path']); ?>">
                        <button type="submit" class="btn btn-warning btn-custom">Add to Cart</button>
                    </form>

                    <div class="btn-style mt-4">
                        <a href="checkout.php" class="btn btn-success btn-custom">Buy Now</a>
                        <button type="button" class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#reviewModal">Review</button>
                        <a href="shop.php" class="btn btn-secondary btn-custom">Back to Shop</a>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="mt-5">
                <h3>Customer Reviews</h3>
                <div id="reviewsContainer">
                    <?php foreach ($reviews as $review) : ?>
                        <div class="review-item">
                            <div class="star-rating">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $review['user_rating']) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <p><strong><?php echo htmlspecialchars($review['user_name']); ?></strong> - <?php echo date('F j, Y', strtotime($review['datetime'])); ?></p>
                            <p><?php echo htmlspecialchars($review['user_review']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <p>Product not found.</p>
        <?php endif; ?>
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
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <div class="star-rating">
                                <i class="far fa-star" data-rating="1"></i>
                                <i class="far fa-star" data-rating="2"></i>
                                <i class="far fa-star" data-rating="3"></i>
                                <i class="far fa-star" data-rating="4"></i>
                                <i class="far fa-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating" required>
                        </div>
                        <div class="mb-3">
                            <label for="review" class="form-label">Your Review</label>
                            <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Popup -->
    <div id="messagePopup" class="alert" role="alert"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Star rating functionality
        const stars = document.querySelectorAll('.star-rating i');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-rating');
                ratingInput.value = rating;
                updateStars(rating);
            });
        });

        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = star.getAttribute('data-rating');
                if (starRating <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }

        // AJAX form submission
        $(document).ready(function() {
            $('#reviewForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'feedback.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showMessage(response.message, 'success');
                            $('#reviewModal').modal('hide');
                            // Refresh reviews
                            location.reload();
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

        function showMessage(message, type) {
            const popup = $('#messagePopup');
            popup.text(message);
            popup.removeClass('alert-success alert-danger');
            popup.addClass(`alert-${type}`);
            popup.fadeIn();
            setTimeout(() => {
                popup.fadeOut();
            }, 2000);
        }
    </script>
</body>

</html>