<?php
require './php/classes/db_connection.php';
require './php/classes/UserClass.php';
require_once './php/classes/Review.php';
session_start();

$db = new DBConnection();
$dbconn = $db->getConnection();
$userId = $_SESSION['user_id'];

if (!empty($_GET['productId'])) {
    $productId = $_GET['productId'];
}

if ($_SESSION['user_type'] == "customer") {
    $dbconn = $db->getConnection();
    $user = User::constructCUSWithUserId($dbconn, $userId);
} else {
    if (isset($productId)) {
        $dbconn = $db->getConnection();
        $user = User::constructSPWithProductId($dbconn, $userId, $productId);
        $photos = $user->getProductPhotos();
    } else {
        $dbconn = $db->getConnection();
        $user = User::constructSPWithUserId($dbconn, $userId);
        $photos = $user->getPhotos();
    }
}
$review = new Review($dbconn);
$averageRating = $review->getAverageRatingByProvider($userId);
$reviews = $review->getReviewsByProviderId($userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        <?php
        if ($_SESSION['user_type'] == "customer") {
            echo "Profile | " . $user->getFirstName() . " " . $user->getLastName();
        } else {
            echo "Profile | " . $user->getBusinessName();
        }
        ?>
    </title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        #statusMessage {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

</head>

<body>
    <?php
    //nav bar according login & not login
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    ?>

    <!--<div class="container mt-5" style="font-size: 1.1rem;">-->
    <div class="container mt-5">
        <div id="statusMessage"></div>
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="<?= '.' . $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle" style="width: 200px;height: 200px;border-radius: 50%;object-fit: cover;">
                <i class="bi bi-pencil-square position-absolute top-0 start-0 translate-middle bg-white rounded-circle p-2"></i>
            </div>
            <div class="col-md-9">
                <?php
                if ($_SESSION['user_type'] == "customer") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getFirstName() . ' ' . $user->getLastName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</span></a></p>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                } elseif ($_SESSION['user_type'] == "sp_reservation") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>  <a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>  ' . $user->getAddress() . '</p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>  ' . $user->getDescription() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>  Reserve advance <b>Rs.' . $user->getAmountPer() . '</b></span></p>';

                    //Display reviews sp_reservation type user
                    echo '<div class="mb-4">';
                    echo '<h3>Reviews</h3>';
                    echo '<div class="star-rating mb-2">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $averageRating) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($i - 0.5 <= $averageRating) {
                            echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star text-warning"></i>';
                        }
                    }
                    echo '<span class="ml-2">' . number_format($averageRating, 1) . '</span>';
                    echo '</div>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                    echo '<a href="./add_timeslot.php"><button class="btn btn-primary mt-auto mb-3">Add Time Slot</button></a>';
                    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Image</button>';

                    $query = "SELECT p.payment_id, u.first_name, u.last_name, u.email, u.contact_number, 
                     t.start_time, t.end_time, p.date_time, p.process_status
              FROM payment p
              JOIN user u ON p.customer_id = u.user_id
              JOIN timeslots t ON p.timeslot_id = t.timeslot_id
              WHERE p.provider_id = ?
              ORDER BY p.date_time DESC";
                } elseif ($_SESSION['user_type'] == "sp_freelance") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">' . $user->getPhone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>  <a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>  ' . $user->getAddress() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>  ' . $user->getDescription() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>  Reserve advance <b>Rs.' . $user->getAmountPer() . '</b></span></p>';

                    //Display reviews sp_freelance type user
                    echo '<div class="mb-4">';
                    echo '<h3>Reviews</h3>';
                    echo '<div class="star-rating mb-2">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $averageRating) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($i - 0.5 <= $averageRating) {
                            echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star text-warning"></i>';
                        }
                    }
                    echo '<span class="ml-2">' . number_format($averageRating, 1) . '</span>';
                    echo '</div>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Image</button>';
                } elseif ($_SESSION['user_type'] == "sp_products") {
                    echo '<h1 class="col-md-6 mb-3">' . $user->getBusinessName() . '</h1>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-envelope mr-2"></i></span>  ' . $user->getEmail() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-telephone mr-2"></i></span>  <a href="tel:+94' . $user->getPhone() . '">'  . $user->getPhone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-whatsapp mr-2" style="color: #25D366;"></i></span>  <a href="https://wa.me/94' . $user->getWphone() . '">' . $user->getWphone() . '</span></a></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-geo-alt mr-2"></i></span>  ' . $user->getAddress() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-info-circle mr-2"></i></span>  ' . $user->getDescription() . '</span></p>';
                    echo '<p class="mb-2"><span class="mr-2"><i class="bi bi-currency-dollar mr-2"></i></span>  Reserve advance <b>Rs.' . $user->getAmountPer() . '</b></p>';

                    //Display reviews sp_products type user
                    echo '<div class="mb-4">';
                    echo '<h3>Reviews</h3>';
                    echo '<div class="star-rating mb-2">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $averageRating) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($i - 0.5 <= $averageRating) {
                            echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star text-warning"></i>';
                        }
                    }
                    echo '<span class="ml-2">' . number_format($averageRating, 1) . '</span>';
                    echo '</div>';
                    echo '<a href="./edit_user_profile.php"><button class="btn btn-primary mt-auto mb-3">Edit Profile</button></a>';
                    echo '<a href="./add_product.php"><button class="btn btn-primary mt-auto mb-3">Add Product</button></a>';
                    //echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Image</button>';
                }

                ?>

            </div>
        </div>
    </div>
    <hr>

    <?php // This for enable image delete option
    if ($_SESSION['user_type'] == "sp_freelance" || $_SESSION['user_type'] == "sp_reservation") {
        echo '<div class="row">';
        echo '<div class="col-12" >';
        echo '<h2>Photos</h2>';
        echo '<div class="d-flex flex-wrap" style="align-items:center;justify-content:center;">';
        // SQL query to select data
        $dbconnector = new DbConnection();
        $conn = $dbconnector->getConnection();

        //sql query for getting data
        $sql = "SELECT image_path,image_name FROM image where user_id= '" . $userId . "' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card m-2" style="align-items:center;border: none;">';
                echo '<img src="' . $row['image_path'] . '" class="card-img-top" alt="Image of ' . $row['image_name'] . '" style="width: 250px;height: 250px;">';
                echo '<button type="button" class="btn btn-danger" style="margin-top: 10px;" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Image</button>';
                echo '</div>';
                echo '
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this image?
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: center; gap: 10px; border-top: none;">
                                        <form method="POST" action="delete_upload_image.php" style="border: none; margin: 0; display: flex; gap: 10px;">
                                            <input type="hidden" name="imagePath" value="' . $row['image_path'] . '">
                                            <button type="submit" class="btn btn-danger" style="border: none;">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border: none;">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
    }
    echo '<br>';

    // Order table for sp_freelance type user by 108
    if ($_SESSION['user_type'] == "sp_freelance") {

        $dbconnector = new DbConnection();
        $conn = $dbconnector->getConnection();
        $sql = "SELECT CONCAT(user.first_name, ' ', user.last_name) AS customer_name,user.email AS customer_email,user.contact_number AS contact_number,payment.payment_id AS payment_id,payment.provider_id AS provider_id,payment.price AS amount,payment.date_time AS payment_date,payment.process_status AS status FROM payment JOIN user ON payment.customer_id = user.user_id WHERE payment.provider_id = '" . $userId . "' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {


            echo '<div class="table-responsive col-11">';
            echo '<h2>Orders</h2>';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Customer Name</th>';
            echo '<th>Customer Email</th>';
            echo '<th>Customer Phone</th>';
            echo '<th>Amount</th>';
            echo '<th>Payment Date</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($order = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($order['customer_name']) . '</td>';
                echo '<td>' . htmlspecialchars($order['customer_email']) . '</td>';
                echo '<td>' . htmlspecialchars($order['contact_number']) . '</td>';
                echo '<td>' . htmlspecialchars($order['amount']) . '</td>';
                echo '<td>' . htmlspecialchars($order['payment_date']) . '</td>';
                echo '<td>';
                echo '<form action="update_order_status.php" method="POST" style="border:none;">';
                echo '<input type="hidden" name="payment_id" value="' . htmlspecialchars($order['payment_id']) . '">';
                echo '<div style="display: flex-column; gap: 10px; align-items: center;">';
                echo '<select name="status" class="form-control" style="width: 100%;">';
                echo '<option value="pending"' . ($order['status'] == 'pending' ? ' selected' : '') . '>Pending</option>';
                echo '<option value="shipped"' . ($order['status'] == 'shipped' ? ' selected' : '') . '>Shipped</option>';
                echo '</select>';
                echo '<button type="submit" class="btn btn-primary" style="margin: 5px 0px 0px 0px;">Update</button>';
                echo '</div>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }

        //display timeslots booked by 109    
    } elseif ($_SESSION['user_type'] == "sp_reservation") {

        // Fetch booked timeslots
        $query = "SELECT p.payment_id, u.first_name, u.last_name, u.email, u.contact_number, t.start_time, t.end_time, p.date_time, p.process_status FROM payment p JOIN user u ON p.customer_id = u.user_id JOIN timeslots t ON p.timeslot_id = t.timeslot_id WHERE p.provider_id = ? ORDER BY p.date_time DESC";
        $stmt = $dbconn->prepare($query);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="table-responsive col-11">';
            echo '<h2>Booked Timeslots</h2>';
            echo '<div class="table-responsive col-12">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Customer Name</th>';
            echo '<th>Customer Email</th>';
            echo '<th>Phone Number</th>';
            echo '<th>Timeslot</th>';
            echo '<th>Paid Date</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['contact_number']) . '</td>';
                echo '<td>' . htmlspecialchars($row['start_time'] . ' - ' . $row['end_time']) . '</td>';
                echo '<td>' . htmlspecialchars($row['date_time']) . '</td>';
                echo '<td>';
                echo '<select class="form-select status-select" data-payment-id="' . $row['payment_id'] . '">';
                echo '<option value="pending"' . ($row['process_status'] == 'pending' ? ' selected' : '') . '>Pending</option>';
                echo '<option value="reserved"' . ($row['process_status'] == 'reserved' ? ' selected' : '') . '>Reserved</option>';
                echo '</select>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>No booked timeslots found.</p>';
        }

        $stmt->close();

        // Order table for sp_products type user by 108
    } else if ($_SESSION['user_type'] == "sp_products") {

        $dbconnector = new DbConnection();
        $conn = $dbconnector->getConnection();
        $sql = "SELECT CONCAT(user.first_name, ' ', user.last_name) AS customer_name,user.email AS customer_email,user.contact_number AS contact_number,product.name AS product_name,payment.payment_id AS payment_id,payment.provider_id AS provider_id,payment.price AS amount,payment.quantity AS quantity,payment.date_time AS payment_date,payment.process_status AS status FROM payment JOIN user ON payment.customer_id = user.user_id JOIN product  ON payment.product_id = product.product_id WHERE payment.provider_id = '" . $userId . "' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo '<h2>Orders</h2>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Customer Name</th>';
            echo '<th>Customer Email</th>';
            echo '<th>Customer Phone</th>';
            echo '<th>Product Name</th>';
            echo '<th>Amount</th>';
            echo '<th>Quantity</th>';
            echo '<th>Payment Date</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($order = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($order['customer_name']) . '</td>';
                echo '<td>' . htmlspecialchars($order['customer_email']) . '</td>';
                echo '<td>' . htmlspecialchars($order['contact_number']) . '</td>';
                echo '<td>' . htmlspecialchars($order['product_name']) . '</td>';
                echo '<td>' . htmlspecialchars($order['amount']) . '</td>';
                echo '<td>' . htmlspecialchars($order['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars($order['payment_date']) . '</td>';
                echo '<td>';
                echo '<form action="update_order_status.php" method="POST" style="border:none;">';
                echo '<input type="hidden" name="payment_id" value="' . htmlspecialchars($order['payment_id']) . '">';
                echo '<div style="display: flex-column; gap: 10px; align-items: center;">';
                echo '<select name="status" class="form-control" style="width: 100%;">';
                echo '<option value="pending"' . ($order['status'] == 'pending' ? ' selected' : '') . '>Pending</option>';
                echo '<option value="shipped"' . ($order['status'] == 'shipped' ? ' selected' : '') . '>Shipped</option>';
                echo '</select>';
                echo '<button type="submit" class="btn btn-primary" style="margin: 5px 0px 0px 0px;">Update</button>';
                echo '</div>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
    } else if ($_SESSION['user_type'] == "customer") {
        $dbconnector = new DbConnection();
        $conn = $dbconnector->getConnection();
        $sql = "SELECT CONCAT(user.first_name, ' ', user.last_name) AS provider_name,user.email AS provider_email,user.contact_number AS provider_phone,product.name AS product_name,payment.payment_id AS payment_id,payment.price AS amount,payment.quantity AS quantity,payment.date_time AS payment_date,payment.process_status AS status FROM payment JOIN user ON payment.provider_id = user.user_id JOIN product  ON payment.product_id = product.product_id WHERE payment.customer_id = '" . $userId . "' ";
        $result = $conn->query($sql);

        //My orders table for products type user by 108

        echo '<div class="table-responsive col-11" style="margin-left: 4%;">';
        echo '<h2>My orders for products</h2>';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Provider Name</th>';
        echo '<th>Provider Email</th>';
        echo '<th>Provider Phone</th>';
        echo '<th>Product Name</th>';
        echo '<th>Amount</th>';
        echo '<th>Quantity</th>';
        echo '<th>Payment Date</th>';
        echo '<th>Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($order = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($order['provider_name']) . '</td>';
            echo '<td>' . htmlspecialchars($order['provider_email']) . '</td>';
            echo '<td>' . htmlspecialchars($order['provider_phone']) . '</td>';
            echo '<td>' . htmlspecialchars($order['product_name']) . '</td>';
            echo '<td>' . htmlspecialchars($order['amount']) . '</td>';
            echo '<td>' . htmlspecialchars($order['quantity']) . '</td>';
            echo '<td>' . htmlspecialchars($order['payment_date']) . '</td>';
            echo '<td>';
            echo '<form action="update_order_status.php" method="POST" style="border:none;">';
            echo '<input type="hidden" name="payment_id" value="' . htmlspecialchars($order['payment_id']) . '">';
            echo '<div style="display: flex-column; gap: 10px; align-items: center;">';
            echo '<select name="status" class="form-control" style="width: 100%;">';
            echo '<option value="pending"' . ($order['status'] == 'pending' ? ' selected' : '') . 'hidden >Pending</option>';
            echo '<option value="shipped"' . ($order['status'] == 'shipped' ? ' selected' : '') . 'hidden >Shipped</option>';
            echo '<option value="delivered"' . ($order['status'] == 'delivered' ? ' selected' : '') . '>Delivered</option>';
            echo '</select>';
            echo '<button type="submit" class="btn btn-primary" style="margin: 5px 0px 0px 0px;">Update</button>';
            echo '</div>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        //My booking table for timeslot type user by 108
        $query = "SELECT p.payment_id, u.first_name, u.last_name, u.email, u.contact_number, t.start_time, t.end_time, p.date_time, p.process_status FROM payment p JOIN user u ON p.provider_id = u.user_id JOIN timeslots t ON p.timeslot_id = t.timeslot_id WHERE p.customer_id = ? ORDER BY p.date_time DESC";
        $stmt = $dbconn->prepare($query);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result2 = $stmt->get_result();


        echo '<h2>My booking for Timeslots</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Provider Name</th>';
        echo '<th>Provider Email</th>';
        echo '<th>Provider Phone</th>';
        echo '<th>Timeslot</th>';
        echo '<th>Paid Date</th>';
        echo '<th>Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result2->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['contact_number']) . '</td>';
            echo '<td>' . htmlspecialchars($row['start_time'] . ' - ' . $row['end_time']) . '</td>';
            echo '<td>' . htmlspecialchars($row['date_time']) . '</td>';
            echo '<td>';
            echo '<select class="form-select status-select" data-payment-id="' . $row['payment_id'] . '">';
            echo '<option value="pending"' . ($row['process_status'] == 'pending' ? ' selected' : '') . 'hidden >Pending</option>';
            echo '<option value="reserved"' . ($row['process_status'] == 'reserved' ? ' selected' : '') . 'hidden >Reserved</option>';
            echo '</select>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        echo '</div>';

        //My orders in freelance
        $sql3 = "SELECT CONCAT(user.first_name, ' ', user.last_name) AS provider_name,user.email AS provider_email,user.contact_number AS provider_phone,payment.payment_id AS payment_id,payment.provider_id AS provider_id,payment.price AS amount,payment.date_time AS payment_date,payment.process_status AS status FROM payment JOIN user ON payment.provider_id = user.user_id WHERE user.user_type = 'sp_freelance' AND payment.customer_id = '" . $userId . "' ";
        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {

            echo '<h2>My placements for freelancers</h2>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Provider Name</th>';
            echo '<th>Provider Email</th>';
            echo '<th>Provider Phone</th>';
            echo '<th>Amount</th>';
            echo '<th>Payment Date</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($order = $result3->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($order['provider_name']) . '</td>';
                echo '<td>' . htmlspecialchars($order['provider_email']) . '</td>';
                echo '<td>' . htmlspecialchars($order['provider_phone']) . '</td>';
                echo '<td>' . htmlspecialchars($order['amount']) . '</td>';
                echo '<td>' . htmlspecialchars($order['payment_date']) . '</td>';
                echo '<td>';
                echo '<form action="update_order_status.php" method="POST" style="border:none;">';
                echo '<input type="hidden" name="payment_id" value="' . htmlspecialchars($order['payment_id']) . '">';
                echo '<div style="display: flex-column; gap: 10px; align-items: center;">';
                echo '<select name="status" class="form-control" style="width: 100%;">';
                echo '<option value="pending"' . ($order['status'] == 'pending' ? ' selected' : '') . 'hidden>Pending</option>';
                echo '<option value="shipped"' . ($order['status'] == 'shipped' ? ' selected' : '') . 'hidden>Shipped</option>';
                echo '<option value="delivered"' . ($order['status'] == 'delivered' ? ' selected' : '') . '>Delivered</option>';
                echo '</select>';
                echo '<button type="submit" class="btn btn-primary" style="margin: 5px 0px 0px 0px;">Update</button>';
                echo '</div>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
    }

    include './footer.php';
    ?>

    <?php // image upload modal

    //The popup prompt for upload image
    echo '<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="uploadModelLabel">Upload Image</h5>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<form action="./user_profile_upload_image.php" method="post" enctype="multipart/form-data" style="border:none;">';
    echo '<label for="image" class="form-label">Select an image to upload:</label>';
    echo '<input type="file" name="image" id="image" class="form-control" required>';
    echo '</div>';
    echo '<div class="modal-footer" style="border:none;">';
    echo '<button type="submit" class="btn btn-primary" name="submit">Upload</button>';
    echo '<div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="assets/js/script.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const error = urlParams.get('error');

        const messageElement = document.getElementById('statusMessage');

        if (status || error) {
            if (status) {
                switch (status) {
                    case 'success':
                        messageElement.textContent = 'Profile updated successfully with new image!';
                        messageElement.classList.add('success');
                        break;
                    case 'success_no_image':
                        messageElement.textContent = 'Profile updated successfully without changing the image.';
                        messageElement.classList.add('success');
                        break;
                    case 'uploaded':
                        messageElement.textContent = 'New image inserted successfully.';
                        messageElement.classList.add('success');
                        break;
                    case 'deleted':
                        messageElement.textContent = 'The image deleted successfully.';
                        messageElement.classList.add('success');
                        break;
                    case 'status_updated':
                        messageElement.textContent = 'Order status updated successfully.';
                        messageElement.classList.add('success');
                        break;
                    case 'success_product_added':
                        messageElement.textContent = 'Product Added successfully.';
                        messageElement.classList.add('success');
                        break;
                    default:
                        messageElement.textContent = 'An unknown status occurred. Please try again.';
                        messageElement.classList.add('error');
                }
            } else if (error) {
                switch (error) {
                    case 'invalid_file_type':
                        messageElement.textContent = 'Invalid file type. Please choose a valid image file (JPEG, PNG, or GIF).';
                        break;
                    case 'file_too_large':
                        messageElement.textContent = 'File is too large. Maximum size allowed is 5 MB.';
                        break;
                    case 'directory_creation_failed':
                        messageElement.textContent = 'Failed to create upload directory. Please contact support.';
                        break;
                    case 'directory_not_writable':
                        messageElement.textContent = 'Upload directory is not writable. Please contact support.';
                        break;
                    case 'database_prepare_failed':
                        messageElement.textContent = 'Database prepare statement failed. Please try again or contact support.';
                        break;
                    case 'database_update_failed':
                    case 'exec_error':
                        messageElement.textContent = 'Database update failed. Please try again or contact support.';
                        break;
                    case 'file_move_failed':
                        messageElement.textContent = 'Failed to move uploaded file. Please try again or contact support.';
                        break;
                    case 'image_not_found':
                        messageElement.textContent = 'The image not found in the directory. Please try again or contact support.';
                        break;
                    case 'missing_data':
                        messageElement.textContent = 'The specified data not found in the directory. Please try again or contact support.';
                        break;
                    default:
                        messageElement.textContent = 'An unknown error occurred. Please try again or contact support.';
                }
                messageElement.classList.add('error');
            }
            showMessage();
        }

        function showMessage() {
            messageElement.style.display = 'block';
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 5000);
        }
    });


    function deleteImage(imagePath) {
        // Confirmation dialog by sajith 
        if (confirm("Are you sure you want to delete this image?")) {
            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_upload_image.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Handle response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Check if the response indicates success
                    if (xhr.responseText.includes("Image deleted successfully")) {
                        location.reload(); // Reloads the page
                    }
                }
            };

            // Send the image path to the server
            xhr.send("imagePath=" + encodeURIComponent(imagePath));
        }
    }
</script>
<script>
    //Geeth added
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.status-select');
        statusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const paymentId = this.getAttribute('data-payment-id');
                const newStatus = this.value;

                // Send AJAX request to update status
                fetch('update_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `payment_id=${paymentId}&status=${newStatus}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully');
                        } else {
                            alert('Failed to update status');
                            // Reset the select to its previous value
                            this.value = this.getAttribute('data-original-value');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the status');
                        // Reset the select to its previous value
                        this.value = this.getAttribute('data-original-value');
                    });
            });

            // Store the original value
            select.setAttribute('data-original-value', select.value);
        });
    });
</script>


</html>