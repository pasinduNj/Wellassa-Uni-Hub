<?php
class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct($name, $price, $quantity, $description, $category, $provider_id, $image_path)
    {
        $stmt = $this->conn->prepare("INSERT INTO product (name, price, quantity, description, category, provider_id, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdissss", $name, $price, $quantity, $description, $category, $provider_id, $image_path);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
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
