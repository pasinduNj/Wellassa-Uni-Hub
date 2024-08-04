<?php
session_start();
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>wellassaUniHub</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
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
    <nav class="navbar navbar-expand-md sticky-top text-nowrap shadow visible navbar-shrink py-3 navbar-light" id="mainNav-1" style="background: url(&quot;https://cdn.bootstrapstudio.io/placeholders/1400x800.png&quot;), var(--bs-secondary-bg);height: 73.2px;" data-bs-smooth-scroll="true">
        <div class="container"><span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-gear-wide">
                    <path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"></path>
                </svg></span><a class="navbar-brand d-flex align-items-center" href="/"><span>Wellassa UniHUB</span></a>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link d-lg-flex align-items-lg-center" aria-expanded="false" data-bs-toggle="dropdown" href="Reservations.html" target="_blank">Services</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="Reservations.html">Reservations</a><a class="dropdown-item" href="Shop.html">Order Products</a><a class="dropdown-item" href="Freelance.html">Freelance</a></div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="index.html/#contact">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="Service%20Provider.html">Profile</a></li>
                </ul><a class="btn btn-primary shadow" role="button" href="#" style="width: 88.7px;margin: -9px -16px -9px;padding: 3px 0px;">Log out</a><a class="font-monospace link-warning border-white d-inline-block float-end d-lg-flex align-items-lg-center pull-right" role="button" href="shopping-cart.html" style="padding: 24px;padding-left: 11px;margin: 46px;margin-left: 7px;margin-right: 5px;margin-bottom: 3px;padding-bottom: 7px;padding-top: 7px;padding-right: 12px;margin-top: 1px;transform: translate(24px) rotate(1deg) scale(1);box-shadow: 0px 0px;height: 0px;width: 20.2px;text-align: left;position: static;display: block;"><i class="fa fa-shopping-cart" style="width: 25.2px;height: 34px;margin: -22px;padding: 6px;font-size: 25px;display: block;"></i>&nbsp;Cart</a>
            </div><button data-bs-target="#navcol-1" data-bs-toggle="collapse" class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        </div>
    </nav>
    <h1 class="display-1 text-uppercase text-center text-primary border rounded-0" style="padding: 10px 0px;padding-top: 10px;font-size: 27.52px;font-weight: bold;">System admin dashboard</h1>
    <div style="margin: 33px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="background-color: rgb(241,247,252);">
                    <div class="form-group mb-3">
                        <div class="text-center border rounded-0 shadow-sm profile-box" style="width: 288px;height: 310px;background-color: #ffffff;margin: 5px;padding-right: 0px;margin-right: 4px;">
                            <div style="height: 50px;background-image: url(&quot;assets/img/bg-pattern.png&quot;);background-color: rgba(54,162,177,0);"></div>
                            <div><img class="rounded-circle" src="assets/img/bg-cta.jpg" width="119" height="119" style="background-color: rgb(255,255,255);padding: 2px;"></div>
                            <div style="height: 80px;">
                                <h4 style="height: 24.275px;font-size: 19.568px;margin: 22px;">Profile Name</h4><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal1" style="width: 191.4px;margin: 21px;">Edit Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding-left: 20px;padding-right: 20px;background-color: rgb(241,247,252);">
                    <fieldset></fieldset>
                    <legend><strong>Notifications</strong></legend>
                    <p></p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="height: 46.2px;margin: 1px;"><i class="fa fa-star" style="height: 24px;width: 24px;"></i></td>
                                    <td></td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td><i class="fa fa-star" style="width: 24px;height: 24px;"></i></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-star" style="width: 24px;height: 24px;"></i></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features-boxed">
        <div class="container">
            <div class="row justify-content-center features">
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-users icon"></i>
                        <h3 class="name" style="height: 37.6px;">Registered Users</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-share-alt-square icon"></i>
                        <h3 class="name" style="height: 37.6px;">Service Providers</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-tripadvisor icon"></i>
                        <h3 class="name" style="height: 37.6px;">Advertisement&nbsp;</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="fa fa-hand-paper-o icon"></i>
                        <h3 class="name" style="height: 37.6px;">Appointment</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-wechat icon"></i>
                        <h3 class="name" style="height: 37.6px;">Chat</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-registered icon"></i>
                        <h3 class="name" style="height: 37.6px;">Report</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-odnoklassniki icon"></i>
                        <h3 class="name" style="height: 37.6px;">System Assistant</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-primary-gradient" style="height: 160.2px;margin: 0px;padding: 2px;">
        <div class="container py-4 py-lg-5" style="height: 160px;padding: 0px;width: 720px;">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column" style="height: 106px;">
                    <h3 class="fs-6 fw-bold">&nbsp;Services</h3>
                    <ul class="list-unstyled">
                        <li><a href="Reservations.html">Reservation&nbsp;</a></li>
                        <li><a href="Shop.html">Order Products</a></li>
                        <li><a href="Freelance.html">Free Lancing</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column" style="height: 106px;">
                    <h3 class="fs-6 fw-bold">About</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Company&nbsp;</a></li>
                        <li><a href="index.html/#Testimonials"></a></li>
                        <li><a href="#">Legacy&nbsp; &nbsp;</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column" style="height: 106px;">
                    <h3 class="fs-6 fw-bold">Shortcut Links</h3>
                    <ul class="list-unstyled">
                        <li><a href="Chat.html">Chat</a></li>
                        <li><a href="Service%20Provider.html">View Your Profile</a></li>
                        <li><a href="#">Benefits</a></li>
                    </ul>
                </div>
            </div>
            <hr style="margin: 0px;">
            <div class="text-muted d-flex justify-content-between align-items-center pt-3" style="padding: 0px;height: 0px;">
                <p class="mb-0">Copyright © 2024 Wellassa UniHub</p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15"></path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"></path>
                        </svg></li>
                </ul>
            </div>
        </div>
    </footer>
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
</body>

</html>