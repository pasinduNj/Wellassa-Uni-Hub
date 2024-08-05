<?php
session_start();


require './php/classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

// Delete expired advertisements
$today = date('Y-m-d');
$delete_sql = "DELETE FROM advertisements WHERE until_date < ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("s", $today);
$delete_stmt->execute();
$delete_stmt->close();

$sql = "SELECT * FROM advertisements ORDER BY upload_date DESC";
$result = $conn->query($sql);

$ads = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ads[] = $row;
    }
}

$db->close();

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
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
    <style>
    .slideshow-container {
        max-width: 800px;
        position: relative;
        margin: auto;
    }

    .mySlides {
        display: none;
    }

    .mySlides img {
        width: 100%;
    }

    /* Add the rest of the CSS from the first document here */
</style>
</head>

<body>
    <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    
    ?>
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
    <div class="slideshow-container">
        <?php foreach ($ads as $index => $ad) : ?>
            <div class="mySlides fade">
                <div class="numbertext"><?= $index + 1 ?> / <?= count($ads) ?></div>
                <img src="<?= htmlspecialchars($ad['image_path']) ?>" alt="<?= htmlspecialchars($ad['title']) ?>">
                <div class="text"><?= htmlspecialchars($ad['title']) ?><br><?= htmlspecialchars($ad['description']) ?><br>Expires on: <?= $ad['until_date'] ?></div>
            </div>
        <?php endforeach; ?>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <br>

    <div style="text-align:center">
        <?php for ($i = 1; $i <= count($ads); $i++) : ?>
            <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
        <?php endfor; ?>
    </div>
</section>
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
    <p class="text-muted mb-0">
        <a href="https://maps.app.goo.gl/xNEvir6GKQr9KYKC6" target="_blank" rel="noopener noreferrer">
         Uwa wellassa University
        </a>
    </p>
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
    <script>
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    
    if (slides.length === 0) {
        console.log("No slides found");
        return;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
    setTimeout(showSlides, 5000);
}

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}
</script>
</body>

</html>