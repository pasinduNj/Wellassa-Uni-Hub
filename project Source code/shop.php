<?php
require_once './php/classes/db_connection.php';

// Create a class for handling product retrieval
class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts($category = null, $min_price = null, $max_price = null)
    {
        $query = "SELECT * FROM product WHERE 1=1";

        if ($category) {
            $query .= " AND category = ?";
        }
        if ($min_price) {
            $query .= " AND price >= ?";
        }
        if ($max_price) {
            $query .= " AND price <= ?";
        }

        $stmt = $this->conn->prepare($query);

        $params = [];
        $types = '';

        if ($category) {
            $params[] = $category;
            $types .= 's';
        }
        if ($min_price) {
            $params[] = $min_price;
            $types .= 'd';
        }
        if ($max_price) {
            $params[] = $max_price;
            $types .= 'd';
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Wellassa UniHUB Shop</h1>
            </div>
        </div>
        <div class="row filter-container">
            <div class="col-md-2">
                <h4>Filters</h4>
                <form action="" method="GET" class="filter-form">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All</option>
                            <!-- Add more categories as options here -->
                            <option value="Electronics">Electronics</option>
                            <option value="Camping">Camping</option>
                            <option value="gifts">Gifts</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="min_price" class="form-label">Min Price</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" placeholder="0" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="max_price" class="form-label">Max Price</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" placeholder="1000" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </div>
            <div class="col-md-9 offset-md-1">
                <h2 class="mb-4">Shop</h2>
                <div class="row">
                    <?php if (empty($products)) : ?>
                        <p>No products found.</p>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <p class="card-text"><strong>Price:</strong> LKR <?php echo htmlspecialchars($product['price']); ?></p>
                                        <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                                        <a href="view_product.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for additional components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>