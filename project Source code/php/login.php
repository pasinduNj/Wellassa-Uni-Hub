<?php
include './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

if (isset($_POST['email']) && isset($_POST['password'])) {


    session_start();

    function validate_and_sanitize_input($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = preg_replace('/\s+/', '', $input);
        return $input;
    }

    $email = validate_and_sanitize_input($_POST['email']);
    $password = trim($_POST['password']);
    $rememberMe = isset($_POST['rememberMe']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all the required fields.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit;
    }

    $checkAdminQuery = "SELECT * FROM admins WHERE email = '$email'";
    $checkCustomerQuery = "SELECT * FROM customers WHERE email = '$email'";
    $checkServiceProviderQuery = "SELECT * FROM service_providers WHERE email = '$email'";

    $adminResult = $conn->query($checkAdminQuery);
    $customerResult = $conn->query($checkCustomerQuery);
    $serviceProviderResult = $conn->query($checkServiceProviderQuery);

    $user = null;
    $userType = '';

    if ($adminResult->num_rows > 0) {
        $user = $adminResult->fetch_assoc();
        $userType = 'admin';
    } elseif ($customerResult->num_rows > 0) {
        $user = $customerResult->fetch_assoc();
        $userType = 'customer';
    } elseif ($serviceProviderResult->num_rows > 0) {
        $user = $serviceProviderResult->fetch_assoc();
        $userType = 'serviceProvider';
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user[$userType == 'admin' ? 'admin_id' : ($userType == 'customer' ? 'cus_id' : 'sp_id')];
        $_SESSION['user_type'] = $userType;

        if ($rememberMe) {
            setcookie("email", $email, time() + (86400 * 30), "/");
            setcookie("password", $password, time() + (86400 * 30), "/");
        }

        echo "<script>alert('Login successful.'); window.location.href = '../index.html';</script>";
    } else {
        echo "<script>alert('Invalid email or password.'); window.history.back();</script>";
    }


    $db->close();
}
