<?php
include '.\classes\db_connection.php';

function validate_and_sanitize_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

$firstName = validate_and_sanitize_input($_POST['firstName']);
$lastName = validate_and_sanitize_input($_POST['lastName']);
$email = preg_replace('/\s+/', '', validate_and_sanitize_input($_POST['email']));
$contactNumber = preg_replace('/\s+/', '', validate_and_sanitize_input($_POST['contactNumber']));
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$userType = validate_and_sanitize_input($_POST['userType']);

if (empty($firstName) || empty($lastName) || empty($email) || empty($contactNumber) || empty($password) || empty($confirmPassword)) {
    echo "<script>alert('Please fill in all the required fields.'); window.history.back();</script>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format.'); window.history.back();</script>";
    exit;
}

if (!preg_match('/^0\d{9}$/', $contactNumber)) {
    echo "<script>alert('Contact number must be a 10-digit number starting with 0.'); window.history.back();</script>";
    exit;
}

if (!preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*\W)(?!.*\s).{6,}$/", $password)) {
    echo "<script>alert('Password must
    1.Contains at least one digit  
    2.Contains at least one uppercase letter. 
    3.Contains at least one special character.
    4.Does not contain white spaces.
    5.Contains at least 6 characters.'); window.history.back();</script>";
    exit;
}

if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    exit;
}

$password = password_hash($password, PASSWORD_DEFAULT);

if ($userType == 'serviceProvider') {
    $businessName = validate_and_sanitize_input($_POST['businessName']);
    $nicNumber = preg_replace('/\s+/', '', validate_and_sanitize_input($_POST['nicNumber']));
    $whatsappNumber = preg_replace('/\s+/', '', validate_and_sanitize_input($_POST['whatsappNumber']));
    $serviceAddress = validate_and_sanitize_input($_POST['serviceAddress']);
    $serviceType = validate_and_sanitize_input($_POST['serviceType']);

    if (!empty($nicNumber) && !preg_match('/^\d{9}$|^\d{12}$/', $nicNumber)) {
        echo "<script>alert('NIC number must be either 9 or 12 digits long.'); window.history.back();</script>";
        exit;
    }

    if (!empty($whatsappNumber) && !preg_match('/^0\d{9}$/', $whatsappNumber)) {
        echo "<script>alert('WhatsApp number must be a 10-digit number starting with 0.'); window.history.back();</script>";
        exit;
    }

    if (empty($businessName) || empty($nicNumber) || empty($whatsappNumber) || empty($serviceAddress) || empty($serviceType)) {
        echo "<script>alert('Please fill in all the service provider fields.'); window.history.back();</script>";
        exit;
    }

    // Check if email or contact number already exist for service provider
    $checkQuery = "SELECT * FROM service_providers WHERE email = '$email' OR contact_number = '$contactNumber' OR nic_number = '$nicNumber' OR whatsapp_number = '$whatsappNumber'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Email, contact number, NIC number, or WhatsApp number already exists.'); window.history.back();</script>";
        exit;
    }

    $spId = generateServiceProviderId($conn);
    $query = "INSERT INTO service_providers (sp_id, first_name, last_name, email, contact_number, password, business_name, nic_number, whatsapp_number, service_address, service_type) VALUES ('$spId', '$firstName', '$lastName', '$email', '$contactNumber', '$password', '$businessName', '$nicNumber', '$whatsappNumber', '$serviceAddress', '$serviceType')";
} else {
    // Check if email or contact number already exist for customer
    $checkQuery = "SELECT * FROM customers WHERE email = '$email' OR contact_number = '$contactNumber'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Email or contact number already exists.'); window.history.back();</script>";
        exit;
    }

    $cusId = generateCustomerId($conn);
    $query = "INSERT INTO customers (cus_id, first_name, last_name, email, contact_number, password) VALUES ('$cusId', '$firstName', '$lastName', '$email', '$contactNumber', '$password')";
}

if ($conn->query($query) === TRUE) {
    echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
} else {
    echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
}

$conn->close();

function generateCustomerId($conn) {
    $result = $conn->query("SELECT COUNT(*) AS count FROM customers");
    $row = $result->fetch_assoc();
    return 'CUS-' . str_pad($row['count'] + 1, 4, '0', STR_PAD_LEFT);
}

function generateServiceProviderId($conn) {
    $result = $conn->query("SELECT COUNT(*) AS count FROM service_providers");
    $row = $result->fetch_assoc();
    return 'SP-' . str_pad($row['count'] + 1, 3, '0', STR_PAD_LEFT);
}
?>
