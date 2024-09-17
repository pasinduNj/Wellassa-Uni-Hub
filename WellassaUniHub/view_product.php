<?php
// Database connection (replace with your own connection logic)
require_once './php/classes/db_connection.php';
session_start();

// Check if user is logged in and load appropriate navbar
if (isset($_SESSION['user_name'])) {
    include './navbar2.php';
} else {
    include './navbar.php';
}

// Create a class for handling individual product retrieval
class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

// Initialize database connection and product class
$db = new DbConnection();
$conn = $db->getConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = new Product($conn);
$productDetails = $product->getProductById($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>

<div class="container mt-5">
    <h2 class="text-center">Product Details</h2>

    <?php if ($productDetails) : ?>
        <div class="row">
            <div class="col-md-6">
                <?php if (!empty($productDetails['image_path'])) : ?>
                    <img src="<?php echo htmlspecialchars($productDetails['image_path']); ?>" class="product-image img-fluid" alt="Product Image">
                <?php else : ?>
                    <p>No image available.</p>
                <?php endif; ?>
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
                    <a href="feedback.php" class="btn btn-primary btn-custom">Review</a>
                    <a href="shop.php" class="btn btn-secondary btn-custom">Back to Shop</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>Product not found.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
