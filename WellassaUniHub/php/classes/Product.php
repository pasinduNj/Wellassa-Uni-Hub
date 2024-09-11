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
}