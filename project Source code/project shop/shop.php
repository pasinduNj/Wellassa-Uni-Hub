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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/-Filterable-Cards--Filterable-Cards.css">
    <link rel="stylesheet" href="assets/css/Account-setting-or-edit-profile.css">
    <link rel="stylesheet" href="assets/css/book-table.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Chat.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form-.css">
    <link rel="stylesheet" href="assets/css/Box-panels-box-panel.css">
    <link rel="stylesheet" href="assets/css/Box-panels.css">
    <link rel="stylesheet" href="assets/css/Chat.css">
    <link rel="stylesheet" href="assets/css/content_blocks_modernstyle.css">
    <link rel="stylesheet" href="assets/css/Customizable-Background--Overlay.css">
    <link rel="stylesheet" href="assets/css/Dropdown-Login-with-Social-Logins-bootstrap-social.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-styles.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/css/Form-Select---Full-Date---Month-Day-Year.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/css/jQuery-Panel-styles.css">
    <link rel="stylesheet" href="assets/css/jQuery-Panel.css">
    <link rel="stylesheet" href="assets/css/LinkedIn-like-Profile-Box.css">
    <link rel="stylesheet" href="assets/css/Lista-Productos-Canito.css">
    <link rel="stylesheet" href="assets/css/NZ---TextboxLabel.css">
    <link rel="stylesheet" href="assets/css/opening-times-time-picker.css">
    <link rel="stylesheet" href="assets/css/project-footer.css">
    <link rel="stylesheet" href="assets/css/Project-Nav-cart.css">
    <link rel="stylesheet" href="assets/css/project-Nav.css">
    <link rel="stylesheet" href="assets/css/Review-rating-Star-Review-Button-Review.css">
    <link rel="stylesheet" href="assets/css/Review-rating-Star-Review-Button.css">
    <link rel="stylesheet" href="assets/css/Sign-Up-Form---Gabriela-Carvalho.css">
    <link rel="stylesheet" href="assets/css/Signup-page-with-overlay.css">
    <link rel="stylesheet" href="assets/css/Single-Page-Contact-Us-Form.css">
    <link rel="stylesheet" href="assets/css/Steps-Progressbar.css">
    <link rel="stylesheet" href="assets/css/testnavnow.css">
    <link rel="stylesheet" href="assets/css/Text-Box-2-Columns---Scroll---Hover-Effect.css">
    <link rel="stylesheet" href="assets/css/User-rating.css">
    
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
       
        .navbar-custom {
            background-color: #f0f0f0;
        }
       
        
    </style>
</head>
<body>
<div class='row' style='padding-bottom: 10px;'>
            <nav class="navbar navbar-expand-md sticky-top text-nowrap visible navbar-shrink py-3 navbar-light navbar-custom" id="mainNav" data-bs-smooth-scroll="true">
                <div class="container">
                    <span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-gear-wide">
                            <path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c.719.695.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"></path>
                        </svg>
                    </span>
                    <a class="navbar-brand d-flex align-items-center" href="/">
                        <span>Wellassa UniHUB</span>
                    </a>
                    <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                        <span class="visually-hidden">Toggle navigation</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item"><a class="nav-link active" href="">Home</a></li>
                            <li class="nav-item dropdown" style="margin: 0px;padding: -1px;">
                                <a class="dropdown-toggle nav-link d-lg-flex align-items-lg-center" aria-expanded="false" data-bs-toggle="dropdown" href="Reservations.html" target="_blank" style="margin: -1px;padding: 9px;font-weight: bold;color: rgba(0,0,0,0.65);">Services</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="Reservations.html">Reservations</a>
                                    <a class="dropdown-item" href="http://localhost/Wellassa%20uni%20hub%20clone%20now/Untitled/project%20Source%20code/project shop/shop.php">Order Products</a>
                                    <a class="dropdown-item" href="Freelance.html">Freelance</a>
                                </div>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="index.html/#contact">Contact Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="Service%20Provider.html" style="margin: 0px;padding: 8px;height: 36.6px;">Profile</a></li>
                        </ul>
                        <a class="btn btn-primary shadow" role="button" href="signup.html" style="height: 35px;padding: 3px 10px;margin: 10px -10px 10px 10px;width: 78px;border-radius: 59px;">Sign Up</a>
                        <a class="font-monospace link-warning border-white d-inline-block float-end d-lg-flex align-items-lg-center pull-right" role="button" href="shopping-cart.html" style="padding: 1px;padding-left: 11px;margin: 0px;margin-left: 7px;margin-right: 5px;margin-bottom: 3px;padding-bottom: 7px;padding-top: 7px;padding-right: 12px;margin-top: 1px;transform: translate(24px) rotate(1deg) scale(1);box-shadow: 0px 0px;height: 31.6px;width: 63.2px;text-align: left;position: static;">
                            <i class="fa fa-shopping-cart" style="width: 27.2px;height: 33px;margin: -9px;padding: 2px;font-size: 25px;"></i>&nbsp;Cart
                        </a>
                    </div>
                </div>
            </nav>
        </div>

    

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
                                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5> <p class="card-text"><strong>Price:</strong> LKR <?= htmlspecialchars($product['price']) ?></p>
                                        <a href="viewproduct.php?id=<?= htmlspecialchars($product['product_id']) ?>" class="btn btn-primary">View Details</a>
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
