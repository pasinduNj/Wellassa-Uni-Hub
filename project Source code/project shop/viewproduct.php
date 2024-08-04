<?php
include_once('./productsdbconnector.php'); // Include the database connection

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $productName = htmlspecialchars($product['name']);
        $productPrice = htmlspecialchars($product['price']);
        $productDescription = htmlspecialchars($product['description']);
        $imagePaths = json_decode($product['image_paths'], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?= $productName ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .product-details {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-family: 'Avenir', sans-serif;
        }
        .product-details img {
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            margin-right: 20px;
        }
        .product-info {
            max-width: 400px;
        }
        .product-info h2 {
            margin-bottom: 10px;
            color: blue;
            font-size: 24px;
        }
        .product-info p {
            line-height: 1.6;
        }
        .btn-buy-now,
        .btn-add-to-cart {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 20px;
            margin-right: 10px;
        }
        .btn-buy-now {
            background-color: red;
            border-color: red;
        }
        .btn-add-to-cart {
            background-color: pink;
            border-color: pink;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Product Details</h1>

    <div class="product-details">
        <?php foreach ($imagePaths as $imagePath) { ?>
            <img src="<?= htmlspecialchars($imagePath) ?>" class="img-fluid" alt="<?= $productName ?>">
        <?php } ?>
        <div class="product-info">
            <h2><b><?= $productName ?></b></h2>
            <p><strong>Price:</strong> LKR <?= $productPrice ?></p>
            <p><strong>Description:</strong><br> <?= $productDescription ?></p>
            <a href="#" class="btn btn-buy-now">Buy Now</a>
            <a href="#" class="btn btn-add-to-cart">Add to Cart</a>
            <a href="shop.php" class="btn btn-primary">Back to Shop</a>
        </div>
    </div>
</div>
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
