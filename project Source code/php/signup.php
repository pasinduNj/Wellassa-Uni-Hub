<?php
include './classes/db_connection.php';
include './classes/GenerateId.php';
include './classes/Validation.php';
$run = true;
function sanitize_input($data)
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

    $email = sanitize_input($_POST['email']);
    $contactNumber = sanitize_input($_POST['contactNumber']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $businessName = sanitize_input($_POST['businessName']);
    $nicNumber = sanitize_input($_POST['nicNumber']);
    $whatsappNumber = sanitize_input($_POST['whatsappNumber']);
    $serviceAddress = trim($_POST['serviceAddress']);
    $userType = $_POST['userType'];
    $serviceType = $_POST['serviceType'];
    $joined_date = date('Y-m-d');
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email or contact number already exist for users
    $checkQuery = "SELECT * FROM user WHERE email = '$email' OR contact_number = '$contactNumber'";
    $checkResult = $conn->query($checkQuery);
    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Email or contact number already exists.'); window.history.back();</script>";
        exit;
    }

    if ($userType == 'serviceProvider') {

        $errors = $validate->validateServiceProviderInput(
            $email,
            $contactNumber,
            $password,
            $confirmPassword,
            $businessName,
            $nicNumber,
            $whatsappNumber,
            $serviceAddress,
            $serviceType
        );
        display_errors($errors);
        sleep(1);
        // Check if NIC and WhatsappNumber already exist for service provider
        $checkQuery = "SELECT * FROM user WHERE nic_number='$nicNumber'OR whatsapp_number = '$whatsappNumber'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('NIC number, or WhatsApp number already exists.'); window.history.back();</script>";
            exit;
        }
        if ($run) {
            $userId = $id->generateServiceProviderId($conn);
            $query = "INSERT INTO user (user_id, first_name, last_name, email, contact_number, user_type, password, joined_date, 
            business_name, nic_number, whatsapp_number, service_address, status) 
            VALUES ('$userId', '$firstName', '$lastName', '$email', '$contactNumber', '$serviceType', '$hashPassword', '$joined_date' ,
             '$businessName', '$nicNumber', '$whatsappNumber', '$serviceAddress', 'active')";

            if ($conn->query($query) === TRUE) {
                echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
            } else {
                echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Your inputs are not valid. Sign up again.'); window.location.href = '../signup.html';</script>";
        }
    } else {
        // Validate user inputs
        $errors = $validate->validateUserInput($email, $contactNumber, $password, $confirmPassword);
        display_errors($errors);
        sleep(1);

        if ($userType == 'customer') {

            if ($run) {
                $userId = $id->generateCustomerId($conn);
                $query = "INSERT INTO user (user_id, first_name, last_name, email, contact_number, user_type, password, joined_date, status) 
            VALUES ('$userId', '$firstName', '$lastName', '$email', '$contactNumber', '$userType', '$hashPassword', '$joined_date', 'active')";

                if ($conn->query($query) === TRUE) {
                    echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
                } else {
                    echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Your inputs are not valid. Sign up again.'); window.location.href = '../signup.html';</script>";
            }
        } elseif ($userType == 'admin') {

            if ($run) {
                $userId = $id->generateAdminId($conn);
                $query = "INSERT INTO user (user_id, first_name, last_name, email, contact_number, user_type, password, joined_date, status) 
            VALUES ('$userId', '$firstName', '$lastName', '$email', '$contactNumber', '$userType', '$hashPassword', '$joined_date', 'active')";

                if ($conn->query($query) === TRUE) {
                    echo "<script>alert('Registration successful. Please log in.'); window.location.href = '../login.html';</script>";
                } else {
                    echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Your inputs are not valid. Sign up again.'); window.location.href = '../signup.html';</script>";
            }
        }
    }

    $db->close();
}
