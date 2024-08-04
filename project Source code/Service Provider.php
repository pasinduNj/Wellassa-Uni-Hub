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
<?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    
    ?>
    <h1 class="display-1 text-uppercase text-center text-primary border rounded-0" style="padding: 10px 0px;padding-top: 10px;font-size: 27.52px;font-weight: bold;">Service provider dashboard</h1>
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
                    <div class="box"><i class="la la-calendar icon"></i>
                        <h3 class="name" style="height: 37.6px;">Appointments</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-cart-arrow-down icon"></i>
                        <h3 class="name" style="height: 37.6px;">Orders</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-tripadvisor icon"></i>
                        <h3 class="name" style="height: 37.6px;">Advertisement&nbsp;</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="fa fa-shopping-bag icon"></i>
                        <h3 class="name" style="height: 37.6px;">Shop</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4 item">
                    <div class="box"><i class="la la-wechat icon"></i>
                        <h3 class="name" style="height: 37.6px;">Chat</h3><a class="learn-more" href="#">Manage »</a>
                    </div>
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
</body>

</html>