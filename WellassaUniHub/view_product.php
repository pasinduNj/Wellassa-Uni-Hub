<?php
require_once './php/classes/db_connection.php';
session_start();

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
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
        outline: none; /* Remove button outline */
        border: none;  /* Remove border */
        box-shadow: none; /* Remove box-shadow */
    }

    .btn-custom:hover, .btn-custom:focus {
        outline: none; /* Ensure outline is removed on hover and focus */
        box-shadow: none; /* Remove box-shadow on focus */
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
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($productDetails['name']); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($productDetails['price']); ?>">
                    <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($productDetails['image_path']); ?>"> 
                    <button type="submit" class="btn btn-warning btn-custom">Add to Cart</button>
                </form>
                

                <div class="btn-style mt-4">
                <a href="?id=<?php echo htmlspecialchars($productDetails['product_id']); ?>" class="btn btn-success btn-custom">Buy Now</a>
                    
                    <a href="feedback.php" class="btn btn-primary btn-custom">Review</a>
                    <a href="shop.php" class="btn btn-secondary btn-custom">Back to Shop</a>
                    
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>Product not found.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (optional, for additional components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="assets/js/script.min.js"></script>

</body>

</html>
