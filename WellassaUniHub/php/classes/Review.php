<?php
class Review
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Existing product review functions
    public function addReview($customer_id, $product_id, $user_name, $user_rating, $user_review)
    {
        $query = "INSERT INTO review_table (customer_id, product_id, user_name, user_rating, user_review, datetime) 
                  VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssis", $customer_id, $product_id, $user_name, $user_rating, $user_review);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAverageRating($product_id)
    {
        $query = "SELECT AVG(user_rating) as avg_rating FROM review_table WHERE product_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['avg_rating'] ? round($row['avg_rating'], 1) : 0;
    }

    public function getReviewsByProductId($product_id)
    {
        $query = "SELECT * FROM review_table WHERE product_id = ? ORDER BY datetime DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        return $reviews;
    }

    // New provider review functions
    public function addReviewForProvider($customer_id, $provider_id, $user_name, $user_rating, $user_review)
    {
        $query = "INSERT INTO review_table (customer_id, provider_id, user_name, user_rating, user_review, datetime) 
                  VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssis", $customer_id, $provider_id, $user_name, $user_rating, $user_review);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAverageRatingByProvider($provider_id)
    {
        $query = "SELECT AVG(user_rating) as avg_rating FROM review_table WHERE provider_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $provider_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['avg_rating'] ? round($row['avg_rating'], 1) : 0;
    }

    public function getReviewsByProviderId($provider_id)
    {
        $query = "SELECT * FROM review_table WHERE provider_id = ? ORDER BY datetime DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $provider_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        return $reviews;
    }
}
