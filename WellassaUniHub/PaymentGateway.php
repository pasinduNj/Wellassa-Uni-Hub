<?php
session_start();
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
                            <div class="col-12"><button class="btn btn-success btn-lg d-block w-100" type="submit" style="font-size: 14px;width: 70%;padding: 8px;margin-bottom: 5px; margin-left: 0px; height: 38px;">Start Subscription</button></div>
                        </div>
                    </form>
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
</body>

</html>