<?php
// Database connection (replace with your own connection logic)
require_once './php/classes/db_connection.php';
require_once './php/classes/Product.php';
session_start();

if (isset($_SESSION['user_name'])) {
    $utype = $_SESSION['user_type'];
} else {
    $utype = "";
}
// Initialize database connection and product class
$db = new DbConnection();
$conn = $db->getConnection();

$category = isset($_GET['category']) ? $_GET['category'] : null;
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;

$product = new Product($conn);
$products = $product->getProducts($category, $min_price, $max_price);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo|Cinzel|Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }

        .filter-container {
            margin-top: 30px;
        }

        .filter-form {
            margin-bottom: 30px;
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Wellassa UniHUB Shop</h1>
            </div>
        </div>
        <div class="row filter-container">
            <div class="col-md-3" style="position: sticky; top: 15%; z-index: 1000; align-self: flex-start;">
                <h4>Filters</h4>
                <form action="" method="GET" class="filter-form" style="padding: 5px;">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All</option>
                            <option value="electronics" <?php echo $category == 'electronics' ? 'selected' : ''; ?>>Electronics & Gadgets</option>
                            <option value="stationery" <?php echo $category == 'stationery' ? 'selected' : ''; ?>>Stationery & Office Supplies</option>
                            <option value="textbooks" <?php echo $category == 'textbooks' ? 'selected' : ''; ?>>Textbooks & Study Materials</option>
                            <option value="laptops-accessories" <?php echo $category == 'laptops-accessories' ? 'selected' : ''; ?>>Laptops & Accessories</option>
                            <option value="clothing" <?php echo $category == 'clothing' ? 'selected' : ''; ?>>Clothing & Apparel</option>
                            <option value="footwear" <?php echo $category == 'footwear' ? 'selected' : ''; ?>>Footwear</option>
                            <option value="backpacks" <?php echo $category == 'backpacks' ? 'selected' : ''; ?>>Bags & Backpacks</option>
                            <option value="fitness" <?php echo $category == 'fitness' ? 'selected' : ''; ?>>Fitness & Sports Gear</option>
                            <option value="food" <?php echo $category == 'food' ? 'selected' : ''; ?>>Food & Snacks</option>
                            <option value="drinks" <?php echo $category == 'drinks' ? 'selected' : ''; ?>>Beverages & Drinks</option>
                            <option value="gifts" <?php echo $category == 'gifts' ? 'selected' : ''; ?>>Gifts & Personalized Items</option>
                            <option value="health-beauty" <?php echo $category == 'health-beauty' ? 'selected' : ''; ?>>Health & Beauty Products</option>
                            <option value="home-appliances" <?php echo $category == 'home-appliances' ? 'selected' : ''; ?>>Home & Kitchen Appliances</option>
                            <option value="furniture" <?php echo $category == 'furniture' ? 'selected' : ''; ?>>Furniture & Dorm Essentials</option>
                            <option value="gaming" <?php echo $category == 'gaming' ? 'selected' : ''; ?>>Gaming & Entertainment</option>
                            <option value="events-tickets" <?php echo $category == 'events-tickets' ? 'selected' : ''; ?>>Event Tickets & Activities</option>
                            <option value="camping" <?php echo $category == 'camping' ? 'selected' : ''; ?>>Camping & Outdoor Gear</option>
                            <option value="art-crafts" <?php echo $category == 'art-crafts' ? 'selected' : ''; ?>>Art & Crafts</option>
                            <option value="mobile-accessories" <?php echo $category == 'mobile-accessories' ? 'selected' : ''; ?>>Mobile & Accessories</option>
                            <option value="subscription-services" <?php echo $category == 'subscription-services' ? 'selected' : ''; ?>>Subscription Services</option>
                            <option value="travel" <?php echo $category == 'travel' ? 'selected' : ''; ?>>Travel Accessories</option>
                            <option value="bike-accessories" <?php echo $category == 'bike-accessories' ? 'selected' : ''; ?>>Bikes & Accessories</option>
                            <option value="others" <?php echo $category == 'others' ? 'selected' : ''; ?>>Others</option>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="min_price" class="form-label">Min Price</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" placeholder="0" min="0" value="<?php echo $min_price; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="max_price" class="form-label">Max Price</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" placeholder="1000" min="0" value="<?php echo $max_price; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:90%;">Apply Filters</button>
                </form>
            </div>
            <div class="col-md-8 offset-md-1">
                <h2 class="mb-4">Shop</h2>
                <div class="row">
                    <?php if (empty($products)) : ?>
                        <p>No products found.</p>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src=".<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <p class="card-text"><strong>Price:</strong> LKR <?php echo htmlspecialchars($product['price']); ?></p>
                                        <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>


                                        <?php
                                        if ($utype == "") {
                                            echo '<a href="./signup.php" class="btn btn-primary">Login to View</a>';
                                        } else {
                                            echo '<a href="view_product.php?id=' . $product['product_id'] . '" class="btn btn-primary">View Details</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    <?php
    include './footer.php';
    ?>

    <!-- Bootstrap JS (optional, for additional components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>