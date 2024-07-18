<?php
include './classes/db_connection.php';
include './classes/GenerateId.php';
include './classes/Validation.php';
$run = true;
function validate_and_sanitize_input($data)
{
    $data = trim($data);
    $data = preg_replace('/\s+/', '', $data);
    $data = htmlspecialchars($data);
    return $data;
}
function display_errors($errors)
{   
    if (!empty($errors)) {
        $GLOBALS['run'] = false;
        foreach ($errors as $error) {
            echo "<script>alert('$error'); window.history.back();</script>";
        }
    }
    
}


if (isset($_POST['userType'])) {

    $db = new DbConnection();
    $conn = $db->getConnection();
    $id = new GenerateId();
    $validate = new Validation();
    $errors = [];

    $email = validate_and_sanitize_input($_POST['email']);
    $contactNumber = validate_and_sanitize_input($_POST['contactNumber']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $firstName = validate_and_sanitize_input($_POST['firstName']);
    $lastName = validate_and_sanitize_input($_POST['lastName']);
    $businessName = validate_and_sanitize_input($_POST['businessName']);
    $nicNumber = validate_and_sanitize_input($_POST['nicNumber']);
    $whatsappNumber = validate_and_sanitize_input($_POST['whatsappNumber']);
    $serviceAddress = trim($_POST['serviceAddress']);
    $serviceType = $_POST['serviceType'];
    $joined_date = date('Y-m-d');

    $errors = $validate->validateAdminInput($email, $contactNumber, $password, $confirmPassword);
    display_errors($errors);
    sleep(1);
    if ($_POST['userType'] == 'serviceProvider') {

        $errors = $validate->validateServiceProviderInput($firstName, $lastName, $businessName, $nicNumber, $whatsappNumber, $serviceAddress, $serviceType);
        display_errors($errors);
        sleep(1);
        // Check if email,contact number,NIC and WhatsappNumber already exist for service provider
        $checkQuery = "SELECT * FROM service_providers WHERE email = '$email' OR contact_number = '$contactNumber' OR nic_number='$nicNumber'OR whatsapp_number = '$whatsappNumber'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Email, contact number, NIC number, or WhatsApp number already exists.'); window.history.back();</script>";
            exit;
        }
        if ($run) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $spId = $id->generateServiceProviderId($conn);
            $query = "INSERT INTO service_providers (sp_id, first_name, last_name, email, contact_number, business_name, nic_number, whatsapp_number, service_address, service_type, password, joined_date) VALUES ('$spId', '$firstName', '$lastName', '$email', '$contactNumber', '$businessName', '$nicNumber', '$whatsappNumber', '$serviceAddress', '$serviceType', '$password', '$joined_date')";
            if ($conn->query($query) === TRUE) {
                echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
            } else {
                echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
            }
        }else{
            echo "<script>alert('Your inputs are not valid. Sign up again.'); window.location.href = '../signup.html';</script>";
        }
    } elseif ($_POST['userType'] == 'customer') {

        $errors = $validate->validateCustomerInput($firstName, $lastName);
        display_errors($errors);
        sleep(1);
        // Check if email or contact number already exist for customer
        $checkQuery = "SELECT * FROM customers WHERE email = '$email' OR contact_number = '$contactNumber'";
        $checkResult = $conn->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Email or contact number already exists.'); window.history.back();</script>";
            exit;
        }
        if ($run) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $cusId = $id->generateCustomerId($conn);
            $query = "INSERT INTO customers (cus_id, first_name, last_name, email, contact_number, password, joined_date) VALUES ('$cusId', '$firstName', '$lastName', '$email', '$contactNumber', '$password', '$joined_date')";

            if ($conn->query($query) === TRUE) {
                echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
            } else {
                echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
            }
        }else{
            echo "<script>alert('Your inputs are not valid. Sign up again.'); window.location.href = '../signup.html';</script>";
        }
    } elseif ($_POST['userType'] == 'admin') {



        // Check if email or contact number already exist for admin
        $checkQuery = "SELECT * FROM admins WHERE email = '$email' OR contact_number = '$contactNumber'";
        $checkResult = $conn->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Email or contact number already exists for admin.'); window.history.back();</script>";
            exit;
        }
        if ($run) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $adminId = $id->generateAdminId($conn);
            $query = "INSERT INTO admins (admin_id, email, password, contact_number, joined_date) VALUES ('$adminId', '$email', '$password', '$contactNumber', '$joined_date')";

            if ($conn->query($query) === TRUE) {
                echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
            } else {
                echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
            }
        }else{
            echo "<script>alert('Your inputs are not valid. Sign up again.'); window.location.href = '../signup.html';</script>";
        }
    }
    $db->close();
}
