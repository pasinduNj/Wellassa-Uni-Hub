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
    <div class="row payment-dialog-row" style="width: 899.4px;margin: auto;height: 529.375px;">
        <div class="col-12 col-md-4 offset-md-4" style="width: 342.8px;height: 501.375px;margin: auto;">
            <div class="card credit-card-box">
                <div class="card-header">
                    <h3><span class="panel-title-text">Payment Details </span><img class="img-fluid panel-title-image" src="assets/img/accepted_cards.png"></h3>
                </div>
                <div class="card-body">
                    <form id="payment-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3"><label class="form-label" for="cardNumber">Card number </label>
                                    <div class="input-group"><input class="form-control" type="tel" id="cardNumber" required="" placeholder="Valid Card Number"><span class="input-group-text"><i class="fa fa-credit-card"></i></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="form-group mb-3"><label class="form-label" for="cardExpiry"><span>expiration </span><span>EXP </span> date</label><input class="form-control" type="tel" id="cardExpiry" required="" placeholder="MM / YY"></div>
                            </div>
                            <div class="col-5 pull-right">
                                <div class="form-group mb-3"><label class="form-label" for="cardCVC">cv code</label><input class="form-control" type="tel" id="cardCVC" required="" placeholder="CVC"></div>
                            </div>
                        </div>
                        <div class="row" style="height: 107.713px;">
                            <div class="col-12">
                                <div class="form-group mb-3" style="height: 89.713px;"><label class="form-label" for="couponCode">coupon code</label><input class="form-control" type="text" id="couponCode" style="height: 39.1125px;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"><button class="btn btn-success btn-lg d-block w-100" type="submit" style="font-size: 14px;width: 100px;padding: 8px;margin: -1px;height: 38px;">Start Subscription</button></div>
                        </div>
                    </form>
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