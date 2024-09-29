<?php
session_start();
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Check if ads are in the database
require './php/classes/db_connection.php';
$db = new DbConnection();
$conn = $db->getConnection();

// Updated SQL query to select only active ads (until_date should be in the future)
$sql = "SELECT * FROM advertisements WHERE until_date >= CURDATE() ORDER BY upload_date DESC";
$result = $conn->query($sql);

$ads = [];  // Initialize the $ads array

if ($result && $result->num_rows > 0) {
    // 2. Fetch each ad and store it in the $ads array
    while ($row = $result->fetch_assoc()) {
        $ads[] = $row;  // Add each row to the $ads array

        // 3. Check if the image file exists
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $row['image_path'])) {
            // Handle missing image files, e.g., log the error or take other actions
        }
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>wellassaUniHub</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="assets/css/advertisements.css">
</head>

<body>
    <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    ?>
    <script src="./assets/js/advertisement.js"></script>
    <div
        style="background-image:url(&quot;assets/img/pexels-photo-160107.jpeg&quot;);height:500px;background-position:center;background-size:cover;background-repeat:no-repeat;">
        <div class="d-flex justify-content-center align-items-center"
            style="height:inherit;min-height:initial;width:100%;position:absolute;left:0;background-color:rgba(30,41,99,0.53);">
            <div class="d-flex align-items-center order-5" style="height:200px;">
                <div class="container">
                    <h1 class="text-center"
                        style="color:rgb(242,245,248);font-size:56px;font-weight:bold;font-family:Roboto, sans-serif;">
                        Wellassa Uni Hub</h1>
                    <h3 class="text-center"
                        style="color:rgb(242,245,248);padding-top:0.25em;padding-bottom:0.25em;font-weight:normal;">
                        <span style="color: rgb(232, 232, 232); background-color: rgb(31, 31, 31);">Elevate Your
                            Everyday</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <header class="bg-primary-gradient"></header>
    <section class="py-5"></section>
    <section></section>

    <section>
        <div class="container py-5">
            <div class="mx-auto" style="max-width: 900px;">
                <div class="row row-cols-1 row-cols-md-2 d-flex justify-content-center">
                    <div class="col mb-4">
                        <div class="card bg-primary-subtle">
                            <div class="card-body text-center px-4 py-5 px-md-5">
                                <p class="fw-bold text-primary card-text mb-2">Reservations</p>
                                <h5 class="fw-bold card-title mb-3"><span style="font-weight: normal !important;">You
                                        will be able to Reserve time slots and save your valuable time</span></h5>
                                <button class="btn btn-primary btn-sm" type="button">Learn more</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-secondary-subtle">
                            <div class="card-body text-center px-4 py-5 px-md-5" style="height: 274.4px;">
                                <p class="fw-bold text-secondary card-text mb-2">Order Products &amp; Services</p>
                                <h5 class="fw-bold card-title mb-3"><span style="font-weight: normal !important;">Order
                                        products without walking miles</span></h5><button
                                    class="btn btn-secondary btn-sm" type="button">Learn more</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-info-subtle">
                            <div class="card-body text-center px-4 py-5 px-md-5">
                                <p class="fw-bold text-info card-text mb-2">Freelance&nbsp;</p>
                                <h5 class="fw-bold card-title mb-3"><span style="font-weight: normal !important;">Find
                                        the most suitable people to handover your work</span></h5><button
                                    class="btn btn-info btn-sm" type="button">Learn more</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Slideshow Container for Advertisements -->
    <section>
        <div class="slideshow-container">
            <?php if (!empty($ads)) : ?>
                <?php foreach ($ads as $index => $ad) : ?>
                    <div class="mySlides fade">
                        <div class="numbertext"><?= $index + 1 ?> / <?= count($ads) ?></div>
                        <img src=".<?= htmlspecialchars($ad['image_path']) ?>" alt="<?= htmlspecialchars($ad['title']) ?>" style="width:100%">
                        <div class="text">
                            <h3><?= htmlspecialchars($ad['title']) ?></h3>
                            <p><?= htmlspecialchars($ad['description']) ?></p>
                            <p>Expires on: <?= htmlspecialchars($ad['until_date']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            <?php else : ?>
                <p>No active advertisements to display.</p>
            <?php endif; ?>
        </div>

        <br>

        <!-- Dots to indicate the slide number -->
        <div style="text-align:center">
            <?php for ($i = 1; $i <= count($ads); $i++) : ?>
                <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
            <?php endfor; ?>
        </div>
    </section>


    <section class="py-5 mt-5">
        <div class="container py-5" id="Testimonials">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Testimonials</p>
                    <h2 class="fw-bold"><strong>What People Say About us</strong></h2>
                    <p class="text-muted">No matter the work, our team can handle it.&nbsp;</p>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 d-sm-flex justify-content-sm-center">
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4">Nisi sit justo faucibus nec
                            ornare amet, tortor torquent. Blandit class dapibus, aliquet morbi.</p>
                        <div class="d-flex"><img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50"
                                height="50" src="assets/img/team/avatar2.jpg">
                            <div>
                                <p class="fw-bold text-primary mb-0">John Smith</p>
                                <p class="text-muted mb-0">Erat netus</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4">Nisi sit justo faucibus nec
                            ornare amet, tortor torquent. Blandit class dapibus, aliquet morbi.</p>
                        <div class="d-flex"><img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50"
                                height="50" src="assets/img/team/avatar4.jpg">
                            <div>
                                <p class="fw-bold text-primary mb-0">John Smith</p>
                                <p class="text-muted mb-0">Erat netus</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4">Nisi sit justo faucibus nec
                            ornare amet, tortor torquent. Blandit class dapibus, aliquet morbi.</p>
                        <div class="d-flex"><img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50"
                                height="50" src="assets/img/team/avatar5.jpg">
                            <div>
                                <p class="fw-bold text-primary mb-0">John Smith</p>
                                <p class="text-muted mb-0">Erat netus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Contacts</p>
                    <h2 class="fw-bold">How you can reach us</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div>
                        <form class="p-3 p-xl-4" method="post" data-bs-theme="light" action="send_email.php">
                            <div class="mb-3"><input class="form-control" type="text" id="name-1" name="name"
                                    placeholder="Name"></div>
                            <div class="mb-3"><input class="form-control" type="email" id="email-1" name="email"
                                    placeholder="Email"></div>
                            <div class="mb-3"><textarea class="form-control" id="message-1" name="message" rows="6"
                                    placeholder="Message"></textarea></div>
                            <div><button class="btn btn-primary shadow d-block w-100" type="submit">Send </button></div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-xl-4 d-flex justify-content-center justify-content-xl-start">
                    <div class="d-flex flex-wrap flex-md-column justify-content-md-start align-items-md-start h-100">
                        <div class="d-flex align-items-center p-3">
                            <div
                                class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                    viewBox="0 0 16 16" class="bi bi-telephone">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                                    </path>
                                </svg>
                            </div>
                            <div class="px-2">
                                <h6 class="fw-bold mb-0">Phone</h6>
                                <p class="text-muted mb-0">+123456789</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3">
                            <div
                                class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                    viewBox="0 0 16 16" class="bi bi-envelope">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z">
                                    </path>
                                </svg>
                            </div>
                            <div class="px-2">
                                <h6 class="fw-bold mb-0">Email</h6>
                                <p class="text-muted mb-0">info@example.com</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3">
                            <div
                                class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                    viewBox="0 0 16 16" class="bi bi-pin">
                                    <path
                                        d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354zm1.58 1.408-.002-.001.002.001m-.002-.001.002.001A.5.5 0 0 1 6 2v5a.5.5 0 0 1-.276.447h-.002l-.012.007-.054.03a4.922 4.922 0 0 0-.827.58c-.318.278-.585.596-.725.936h7.792c-.14-.34-.407-.658-.725-.936a4.915 4.915 0 0 0-.881-.61l-.012-.006h-.002A.5.5 0 0 1 10 7V2a.5.5 0 0 1 .295-.458 1.775 1.775 0 0 0 .351-.271c.08-.08.155-.17.214-.271H5.14c.06.1.133.191.214.271a1.78 1.78 0 0 0 .37.282">
                                    </path>
                                </svg>
                            </div>
                            <div class="px-2">
                                <h6 class="fw-bold mb-0">Location</h6>
                                <p class="text-muted mb-0">12 Example Street</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    include './footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>


</body>

</html>