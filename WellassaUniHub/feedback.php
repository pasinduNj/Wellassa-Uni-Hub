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

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $user_rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $user_review = isset($_POST['review']) ? trim($_POST['review']) : '';

    // Validate input
    if ($product_id === 0 || $user_rating === 0 || empty($user_review)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input. Please fill all fields.']);
        exit;
    }

    // Insert review
    $result = $review->addReview($user_id, $product_id, $user_name, $user_rating, $user_review);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit review. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
