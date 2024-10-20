<?php
include './classes/db_connection.php';
include './classes/UserClass.php';
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to log errors
function logError($message)
{
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'error_log.txt');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $userType = $_POST['userType'];

    // Create database connection
    $db = new DbConnection();
    $conn = $db->getConnection();

    if (!$conn) {
        logError("Database connection failed");
        header("Location: ../user_profile.php?userId=" . $userId . "&status=5");
        exit();
    }

    // Create User object based on user type
    if ($userType == "customer") {
        $user = User::constructCUSWithUserId($conn, $userId);
    } else {
        $user = User::constructSPWithUserId($conn, $userId);
    }

    if (!$user) {
        logError("Failed to create User object");
        header("Location: ../user_profile.php?userId=" . $userId . "&status=6");
        exit();
    }

    // Update common fields for both user types
    $user->setFirstName($_POST['firstName']);
    $user->setLastName($_POST['lastName']);
    $user->setPhone($_POST['phone']);

    // Update fields specific to service providers
    if ($userType != "customer") {
        $user->setBusinessName($_POST['businessName']);
        $user->setWphone($_POST['wphone']);
        $user->setAddress($_POST['address']);
        $user->setDescription($_POST['description']);
        $user->setAmountPer($_POST['amountPer']);
    }

    // Handle profile image upload if provided
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5 MB

        if (!in_array($_FILES['profileImage']['type'], $allowed_types)) {
            logError("Invalid file type: " . $_FILES['profileImage']['type']);
            header("Location: ../user_profile.php?userId=" . $userId . "&error=invalid_file_type");
            exit();
        }

        if ($_FILES['profileImage']['size'] > $max_size) {
            logError("File too large: " . $_FILES['profileImage']['size']);
            header("Location: ../user_profile.php?userId=" . $userId . "&error=file_too_large");
            exit();
        }

        $image_name = $userId . "_" . time() . "_" . basename($_FILES['profileImage']['name']);
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/GitHub_Projects/Project1/WellassaUniHub//assets/img/profile_photo/";
        $target_file = $target_dir . $image_name;

        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0755, true)) {
                logError("Failed to create directory: " . $target_dir);
                header("Location: ../user_profile.php?userId=" . $userId . "&error=directory_creation_failed");
                exit();
            }
        }

        if (!is_writable($target_dir)) {
            logError("Directory not writable: " . $target_dir);
            header("Location: ../user_profile.php?userId=" . $userId . "&error=directory_not_writable");
            exit();
        }

        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
            $image_path = "/assets/img/profile_photo/" . $image_name;

            $stmt = $conn->prepare("UPDATE user SET profile_photo = ? WHERE user_id = ?");
            if (!$stmt) {
                logError("Prepare failed: " . $conn->error);
                header("Location: ../user_profile.php?userId=" . $userId . "&error=database_prepare_failed");
                exit();
            }

            $stmt->bind_param("ss", $image_path, $userId);
            if (!$stmt->execute()) {
                logError("Execute failed: " . $stmt->error);
                header("Location: ../user_profile.php?userId=" . $userId . "&error=database_update_failed");
                exit();
            }

            logError("Image uploaded successfully: " . $image_path);
            header("Location: ../user_profile.php?userId=" . $userId . "&status=success");
            exit();
        } else {
            logError("Failed to move uploaded file: " . $_FILES['profileImage']['error']);
            header("Location: ../user_profile.php?userId=" . $userId . "&error=file_move_failed");
            exit();
        }
    } else {
        if (isset($_FILES['profileImage'])) {
            logError("File upload error: " . $_FILES['profileImage']['error']);
        } else {
            logError("No file uploaded");
        }
        // No image uploaded, but other updates successful
        header("Location: ../user_profile.php?userId=" . $userId . "&status=success_no_image");
        exit();
    }

    $conn->close();
} else {
    logError("Invalid request method");
    header("Location: ../user_profile.php?userId=" . $userId . "&status=0");
    exit();
}
