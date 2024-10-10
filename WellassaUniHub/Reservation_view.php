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
    <title><?php echo "Reservation | " . $user->getBusinessName(); ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
                <img src="<?= '.' . $user->getProfileImage() ?>" alt="Profile Image_<?= $user->getFirstName() ?>" class="img-fluid rounded-circle">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>

    <script>
        function bookService() {
            var userId = '<?php echo $userId; ?>';
            window.location.href = 'php/Bindex.php?userId=' + encodeURIComponent(userId);
        }
    </script>

</body>

</html>