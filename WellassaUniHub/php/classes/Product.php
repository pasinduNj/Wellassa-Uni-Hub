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
}
