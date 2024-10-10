<?php
require_once './php/classes/db_connection.php';
require_once './php/classes/Review.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if user is logged in
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to submit a review.']);
        exit;
    }

    $db = new DbConnection();
    $conn = $db->getConnection();
    $review = new Review($conn);

    $user_name = $_SESSION['user_name'];
    $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : $_SESSION['user_id'];
    $user_rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $user_review = isset($_POST['review']) ? trim($_POST['review']) : '';

    // Determine if this is a product or provider review
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $provider_id = isset($_POST['provider_id']) ? $_POST['provider_id'] : '';

    // Validate input
    if ($user_rating === 0 || empty($user_review)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input. Please fill all fields.']);
        exit;
    }

    if ($product_id > 0) {
        // Handle product review
        $result = $review->addReview($customer_id, $product_id, $user_name, $user_rating, $user_review);
    } elseif (!empty($provider_id)) {
        // Check if user is trying to review themselves
        if ($customer_id === $provider_id) {
            echo json_encode(['success' => false, 'message' => 'You cannot review yourself.']);
            exit;
        }
        // Handle provider review
        $result = $review->addReviewForProvider($customer_id, $provider_id, $user_name, $user_rating, $user_review);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request. Missing product or provider ID.']);
        exit;
    }

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit review. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
