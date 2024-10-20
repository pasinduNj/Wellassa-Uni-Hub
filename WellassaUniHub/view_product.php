<?php
// Database connection
require_once './php/classes/db_connection.php';
require_once './php/classes/Product.php';
require_once './php/classes/Review.php';
session_start();
$customer_id = $_SESSION['user_id']; // Ensure that customer ID is in the session

// Initialize database connection and product class
$db = new DbConnection();
$conn = $db->getConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get product details
$product = new Product($conn);
$productDetails = $product->getProductById($id);

// Get reviews and ratings
$review = new Review($conn);
$averageRating = $review->getAverageRating($id);
$reviews = $review->getReviewsByProductId($id);

// PayHere integration
$merchant_id = '1228450'; // Replace with your PayHere Merchant ID
$merchant_secret = "NjY3MjAxNzYzNDE0NjczMDA5OTQwNDk4MTA0NTEzNTU2MDI4NDA2";
$currency = "LKR";
$order_id = 1228450;
$amount = $productDetails['price']; // Ensure amount is defined
$provider_id = $productDetails['provider_id']; // Ensure provider ID is defined

// Generate hash for PayHere
$hash = strtoupper(md5($merchant_id . $order_id . number_format($amount, 2, '.', '') . $currency . strtoupper(md5($merchant_secret))));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo|Cinzel|Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    <div class="mt-3">
                        <h4>Average Rating</h4>
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $averageRating) echo '<i class="fas fa-star"></i>';
                                elseif ($i - 0.5 <= $averageRating) echo '<i class="fas fa-star-half-alt"></i>';
                                else echo '<i class="far fa-star"></i>';
                            } ?>
                            <span class="ml-2"><?php echo number_format($averageRating, 1); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($productDetails['name']); ?></h2>
                    <p><?php echo htmlspecialchars($productDetails['description']); ?></p>
                    <p><strong>Price:</strong> LKR <?php echo htmlspecialchars($productDetails['price']); ?></p>
                    <p><strong>Stock:</strong> <?php echo htmlspecialchars($productDetails['quantity']); ?></p>
                    <form action="add_cart.php" method="POST" style="border: none;">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productDetails['name']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($productDetails['price']); ?>">
                        <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($productDetails['image_path']); ?>">
                        <button type="submit" class="btn btn-warning btn-custom">Add to Cart</button>
                    </form>
                    <div class="btn-style mt-2">
                        <button class="btn btn-success btn-custom" onclick="paymentGateWay()">Buy Now</button>
                        <script src="https://www.payhere.lk/lib/payhere.js"></script>
                        <button type="button" class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#reviewModal">Review</button>
                        <a href="shop.php" class="btn btn-secondary btn-custom">Back to Shop</a>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h3>Customer Reviews</h3>
                <div id="reviewsContainer">
                    <?php foreach ($reviews as $review) : ?>
                        <div class="review-item">
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $review['user_rating']) echo '<i class="fas fa-star"></i>';
                                    else echo '<i class="far fa-star"></i>';
                                } ?>
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
                        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Star rating click handler
            $('.star-rating i').click(function() {
                var rating = $(this).data('rating');
                $('#rating').val(rating);
                $('.star-rating i').removeClass('fas').addClass('far');
                for (var i = 1; i <= rating; i++) {
                    $('.star-rating i[data-rating="' + i + '"]').removeClass('far').addClass('fas');
                }
            });

            // Review form submit handler
            $('#reviewForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.post('submit_review.php', formData, function(response) {
                    showMessage(response.success ? 'alert-success' : 'alert-danger', response.message);
                    if (response.success) {
                        $('#reviewModal').modal('hide');
                        // Reload the page or dynamically append the new review
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }, 'json');
            });
        });

       // PayHere payment integration
function paymentGateWay() {
    const totalAmount = $('#cart-total').text().replace(/,/g, ''); // Dynamic total from cart, remove commas if any

    payhere.startPayment({
        sandbox: true,
        merchant_id: "<?php echo $merchant_id; ?>", // Replace with your actual Merchant ID
        return_url: "http://localhost/Wellassa-Uni-Hub/WellassaUniHub/shop.phpp",
        cancel_url: "http://localhost/Wellassa-Uni-Hub/WellassaUniHub/shop.php",
        notify_url: "http://localhost/notify.php",
        order_id: <?php echo $order_id; ?>,
        items: "<?php echo htmlspecialchars($productDetails['name']); ?>",
        amount: totalAmount, // Dynamic total from cart
        currency: "<?php echo $currency; ?>",
        hash: "<?php echo $hash; ?>",
        first_name: "Saman",
        last_name: "Perera",
        email: "samanp@gmail.com",
        phone: "0771234567",
        address: "No.1, Galle Road",
        city: "Colombo",
        country: "Sri Lanka"
    });
}


        // Show message popup
        function showMessage(type, message) {
            $('#messagePopup').removeClass('alert-success alert-danger').addClass(type).text(message).fadeIn();
            setTimeout(function() {
                $('#messagePopup').fadeOut();
            }, 3000);
        }
    </script>
</body>

</html>