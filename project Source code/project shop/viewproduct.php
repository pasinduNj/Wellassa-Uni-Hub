<?php
// Include the database connection
include_once('./productsdbconnector.php');

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $productid = $_GET['id'];

    // Fetch product details from database based on product ID
    $sql = "SELECT * FROM product WHERE productid = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productid]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if product exists
    if ($product) {
        $productName = htmlspecialchars($product['name']);
        $productPrice = htmlspecialchars($product['price']);
        $productDescription = htmlspecialchars($product['description']);
        $productImage = htmlspecialchars($product['image_path']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?= $productName ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
            .product-details {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding: 200px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-size: 25px; /* Adjust the size as needed */
        font-family: 'Avenir', sans-serif;
    }

        .product-details img {
            max-width: 600px;
            height: auto;
            border-radius: 8px;
            margin-right: 200px;
        }
        .product-info {
            max-width: 600px;
        }
        .product-info h2 {
            margin-bottom: 10px;
        }
        .product-info p {
            line-height: 1.6;
        }
        .btn-buy-now {
    background-color: red;
    border-color: red;
    padding: 30px 60px; /* Increase the button size */
    font-size: 20px; /* Increase the font size */
    border-radius: 20px; /* Optional: round the corners */
    margin-right: 10px;
}

.btn-add-to-cart {
    background-color: pink;
    border-color: pink;
    padding: 30px 60px; /* Increase the button size */
    font-size: 20px; /* Increase the font size */
    border-radius: 20px; /* Optional: round the corners */
    margin-right: 10px;
}



    </style>
</head>
<body>
    <h1>Product Details - <?= $productName ?></h1>

    <div class="product-details">
        <img src="<?= $productImage ?>" class="img-fluid" alt="<?= $productName ?>">
        <div class="product-info">
            <h2> <b style="color: blue; font-size: 60px;"><?= $productName ?></h2> </b>
            <p><strong>Price:</strong> <space> LKR </space><?= $productPrice ?></p>
            <p><strong>Description:</strong><br> <?= $productDescription ?></p>
            <a href="#" class="btn btn-buy-now">Buy Now</a>
            <a href="#" class="btn btn-add-to-cart">Add to Cart</a>
            <a href="shop.php" class="btn btn-primary">Back to Shop</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies (optional if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Product ID not specified.</p>";
}
?>
