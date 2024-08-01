<?php
// Include the database connection
include_once('./productsdbconnector.php');

// Initialize filter variables
$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
$filterMinPrice = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$filterMaxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : '';

// Fetch products from database based on filters
$sql = "SELECT * FROM product WHERE 1=1";
$params = [];

if (!empty($filterCategory)) {
    $sql .= " AND category = ?";
    $params[] = $filterCategory;
}

if (!empty($filterMinPrice)) {
    $sql .= " AND price >= ?";
    $params[] = $filterMinPrice;
}

if (!empty($filterMaxPrice)) {
    $sql .= " AND price <= ?";
    $params[] = $filterMaxPrice;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch distinct categories for the filter dropdown
$categorySql = "SELECT DISTINCT category FROM product";
$categoryStmt = $pdo->prepare($categorySql);
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
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
        .filter-form {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-card {
            max-width: 300px;
            margin: 0 auto 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .product-card .card-body {
            padding: 10px;
        }
        .product-card .card-title {
            font-weight: bold;
        }
        .product-card .card-text {
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Products in Shop</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <form method="GET" action="shop.php" class="filter-form">
                    <h4>Filter by:</h4>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" name="category" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?= htmlspecialchars($category['category']) ?>" <?= $filterCategory == $category['category'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['category']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="min_price" class="form-label">Min Price</label>
                        <input type="text" id="min_price" name="min_price" class="form-control" value="<?= htmlspecialchars($filterMinPrice) ?>" oninput="validateNumber(this)">
                    </div>
                    <div class="mb-3">
                        <label for="max_price" class="form-label">Max Price</label>
                        <input type="text" id="max_price" name="max_price" class="form-control" value="<?= htmlspecialchars($filterMaxPrice) ?>" oninput="validateNumber(this)">
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                    <a href="shop.php" class="btn btn-secondary">Back to Shop</a>
                </form>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <?php
                    if (count($products) > 0) {
                        // Loop through each product and display it in a card
                        foreach ($products as $product) {
                            ?>
                            <div class="col-md-4">
                                <div class="product-card">
                                    <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                        <p class="card-text"><strong>Price:</strong> <space> LKR   </space> <?= htmlspecialchars($product['price']) ?></p>
                                        <a href="viewproduct.php?id=<?= htmlspecialchars($product['productid']) ?>" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='col-12'><p>No products found.</p></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies (optional if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script>
    function validateNumber(input) {
        // Remove any non-digit characters
        input.value = input.value.replace(/\D/g, '');

        // Ensure the value is positive
        if (parseInt(input.value) < 0) {
            input.value = '';
        }
    }
</script>
</body>
</html>
