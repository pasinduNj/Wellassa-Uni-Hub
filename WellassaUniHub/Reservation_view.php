<?php
include_once('./php/classes/db_connection.php');
include_once('./php/classes/UserClass.php');
session_start();

$db = new DBConnection();
$userId = $_GET['userId'];
if (!empty($_GET['productId'])) {
    $productId = $_GET['productId'];
}

if (isset($productId)) {
    $dbconn = $db->getConnection();
    $user = User::constructSPWithProductId($dbconn, $userId, $productId);
    $photos = $user->getProductPhotos();
} else {
    $dbconn = $db->getConnection();
    $user = User::constructSPWithUserId($dbconn, $userId);
    $photos = $user->getPhotos();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo "Reservation | " . $user->getBusinessName(); ?>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/-Filterable-Cards--Filterable-Cards.css">
    <link rel="stylesheet" href="assets/css/Account-setting-or-edit-profile.css">
    <link rel="stylesheet" href="assets/css/book-table.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Chat.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form-.css">
    <link rel="stylesheet" href="assets/css/Box-panels-box-panel.css">
    <link rel="stylesheet" href="assets/css/Box-panels.css">
    <link rel="stylesheet" href="assets/css/Chat.css">
    <link rel="stylesheet" href="assets/css/content_blocks_modernstyle.css">
    <link rel="stylesheet" href="assets/css/Customizable-Background--Overlay.css">
    <link rel="stylesheet" href="assets/css/Dropdown-Login-with-Social-Logins-bootstrap-social.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-styles.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/css/Form-Select---Full-Date---Month-Day-Year.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/css/jQuery-Panel-styles.css">
    <link rel="stylesheet" href="assets/css/jQuery-Panel.css">
    <link rel="stylesheet" href="assets/css/LinkedIn-like-Profile-Box.css">
    <link rel="stylesheet" href="assets/css/Lista-Productos-Canito.css">
    <link rel="stylesheet" href="assets/css/NZ---TextboxLabel.css">
    <link rel="stylesheet" href="assets/css/opening-times-time-picker.css">
    <link rel="stylesheet" href="assets/css/project-footer.css">
    <link rel="stylesheet" href="assets/css/Project-Nav-cart.css">
    <link rel="stylesheet" href="assets/css/project-Nav.css">
    <link rel="stylesheet" href="assets/css/Review-rating-Star-Review-Button-Review.css">
    <link rel="stylesheet" href="assets/css/Review-rating-Star-Review-Button.css">
    <link rel="stylesheet" href="assets/css/Sign-Up-Form---Gabriela-Carvalho.css">
    <link rel="stylesheet" href="assets/css/Signup-page-with-overlay.css">
    <link rel="stylesheet" href="assets/css/Single-Page-Contact-Us-Form.css">
    <link rel="stylesheet" href="assets/css/Steps-Progressbar.css">
    <link rel="stylesheet" href="assets/css/testnavnow.css">
    <link rel="stylesheet" href="assets/css/Text-Box-2-Columns---Scroll---Hover-Effect.css">
    <link rel="stylesheet" href="assets/css/User-rating.css">
</head>

<body>
    <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }

    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <img src="<?= $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle">
                <i class="bi bi-pencil-square position-absolute top-0 start-0 translate-middle bg-white rounded-circle p-2"></i>
            </div>
            <div class="col-md-9">
                <!-- dont forget to put other usertypes' differentdata here -->
                <?php
                //phone: should be in icon
                //whatsapp icon leads to the whatsapp chat
                //https://wa.me/94765907934  this link should be merge from the database
                ?>

                <h1 class="col-md-3 mb-3"><?= $user->getFirstName() ?> <?= $user->getLastName() ?></h1>
                <h1 class="col-md-6 mb-3"><?= $user->getBusinessName() ?></h1>
                <p class="mb-2"><span class="mr-2">
                        <i class="bi bi-envelope mr-2"></i>
                    </span> <?= $user->getEmail() ?></p>
                <p class="mb-2"><span class="mr-2">
                        <i class="bi bi-telephone mr-2"></i>
                    </span> <a href="tel:+94'.$user->getPhone().'" target="_blank"><?= $user->getPhone() ?></a></p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-whatsapp mr-2"></i>
                    </span>
                    <!-- check digits if need trim -->
                    <a href="https://wa.me/'.$user->getWPhone().'" target="_blank"><?= $user->getWPhone() ?></a>
                </p>
                <p class="mb-2">
                    <i class="bi bi-geo-alt mr-2"></i>
                    <?= $user->getAddress() ?>
                </p>
                <p class="mb-2">
                    <span class="mr-2">
                        <i class="bi bi-info-circle mr-2"></i>
                    </span>
                    <?= $user->getDescription() ?>
                </p>
                <p class="mb-2">
                    <span class="mr-2">
                        Reviews :
                    </span>
                    <span class="rating">
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9734;</span> <!-- empty star for illustration -->
                    </span>
                </p>
                <button class="btn btn-primary" onclick="bookService()">Book</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h2>Photos</h2>
                <div class="d-flex flex-wrap">
                    <?php foreach ($photos as $photoPath) {
                        echo '<div class="card m-2" style="width: 18rem;">';
                        echo '<img src="' . $photoPath . '" class="card-img-top" alt="Image of ' . $userId . '">';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include './footer.php';
    ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/-Filterable-Cards--Filterable-Cards.js"></script>
    <script src="assets/js/bold-and-bright.js"></script>
    <script src="assets/js/Bootstrap-DateTime-Picker-amoment.js"></script>
    <script src="assets/js/Bootstrap-DateTime-Picker-bootstrap-datetimepicker.js"></script>
    <script src="assets/js/Bootstrap-DateTime-Picker-datetimepicker-helper.js"></script>
    <script src="assets/js/Date-Range-Picker-style.js"></script>
    <script src="assets/js/DateRangePicker-My-Date-Picker.js"></script>
    <script src="assets/js/ebs-bootstrap-datepicker-bootstrap-datepicker.min.js"></script>
    <script src="assets/js/ebs-bootstrap-datepicker-calendar.js"></script>
    <script src="assets/js/HoverText-Plugin-V1-hovertext.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/jQuery-Panel-panel.js"></script>
    <script src="assets/js/Review-rating-Star-Review-Button-Reviewbtn.js"></script>
    <script src="assets/js/advertisement.js"></script>
    <script>
        function bookService() {
            var userId = '<?php echo $userId; ?>';
            window.location.href = 'php/Bindex.php?userId=' + encodeURIComponent(userId);
        }
    </script>

</body>

</html>