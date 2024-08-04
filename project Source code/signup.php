<?php
session_start();
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>Sign up</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css" />
  <link rel="stylesheet" href="assets/css/-Filterable-Cards--Filterable-Cards.css" />
  <link rel="stylesheet" href="assets/css/Account-setting-or-edit-profile.css" />
  <link rel="stylesheet" href="assets/css/book-table.css" />
  <link rel="stylesheet" href="assets/css/Bootstrap-Chat.css" />
  <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form.css" />
  <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form-.css" />
  <link rel="stylesheet" href="assets/css/Box-panels-box-panel.css" />
  <link rel="stylesheet" href="assets/css/Box-panels.css" />
  <link rel="stylesheet" href="assets/css/Chat.css" />
  <link rel="stylesheet" href="assets/css/content_blocks_modernstyle.css" />
  <link rel="stylesheet" href="assets/css/Customizable-Background--Overlay.css" />
  <link rel="stylesheet" href="assets/css/Dropdown-Login-with-Social-Logins-bootstrap-social.css" />
  <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.min.css" />
  <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.standalone.min.css" />
  <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker3.standalone.min.css" />
  <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-styles.css" />
  <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker.css" />
  <link rel="stylesheet" href="assets/css/Form-Select---Full-Date---Month-Day-Year.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="assets/css/jQuery-Panel-styles.css" />
  <link rel="stylesheet" href="assets/css/jQuery-Panel.css" />
  <link rel="stylesheet" href="assets/css/LinkedIn-like-Profile-Box.css" />
  <link rel="stylesheet" href="assets/css/Lista-Productos-Canito.css" />
  <link rel="stylesheet" href="assets/css/NZ---TextboxLabel.css" />
  <link rel="stylesheet" href="assets/css/opening-times-time-picker.css" />
  <link rel="stylesheet" href="assets/css/project-footer.css" />
  <link rel="stylesheet" href="assets/css/Project-Nav-cart.css" />
  <link rel="stylesheet" href="assets/css/project-Nav.css" />
  <link rel="stylesheet" href="assets/css/Review-rating-Star-Review-Button-Review.css" />
  <link rel="stylesheet" href="assets/css/Review-rating-Star-Review-Button.css" />
  <link rel="stylesheet" href="assets/css/Sign-Up-Form---Gabriela-Carvalho.css" />
  <link rel="stylesheet" href="assets/css/Signup-page-with-overlay.css" />
  <link rel="stylesheet" href="assets/css/Single-Page-Contact-Us-Form.css" />
  <link rel="stylesheet" href="assets/css/Steps-Progressbar.css" />
  <link rel="stylesheet" href="assets/css/testnavnow.css" />
  <link rel="stylesheet" href="assets/css/Text-Box-2-Columns---Scroll---Hover-Effect.css" />
  <link rel="stylesheet" href="assets/css/User-rating.css" />
  <script src="assets/js/scripts.js" defer></script>
</head>

<body>
<?php  
        include './navbar.php';  
?>
  <section class="py-5">
    <div class="container py-5">
      <div class="row mb-4 mb-lg-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <p class="fw-bold text-success mb-2">Sign up</p>
          <h2 class="fw-bold">Welcome</h2>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-xl-4">
          <div class="card">
            <div class="card-body text-center d-flex flex-column align-items-center">
              <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                  class="bi bi-person">
                  <path
                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z">
                  </path>
                </svg>
              </div>
              <form id="signupForm" action="php/signup.php" method="post" data-bs-theme="light"
                style="border-style: none">
                <input class="form-control" id="firstName" type="text" placeholder="First Name" name="firstName"
                  required /><input class="form-control" id="lastName" type="text" placeholder="Last Name"
                  name="lastName" required /><input class="form-control" id="email" type="email" name="email"
                  placeholder="Email" required />
                <div class="mb-3"></div>
                <input class="form-control" id="contactNumber" type="tel" name="contactNumber"
                  placeholder="Contact Number" required />
                <div class="mb-3"></div>

                <table>
                  <tr>
                    <td>
                      <input type="radio" name="userType" value="customer" checked />
                    </td>
                    <td><label>&nbsp;&nbsp;Customer</label></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                    <td>
                      <input type="radio" name="userType" value="serviceProvider" />
                    </td>
                    <td><label>&nbsp;&nbsp;Service Provider</label></td>
                  </tr>
                </table>


                <!-- <select
                    id="userType"
                    name="userType"
                    required
                    class="form-select"
                    style="border-radius: 5px; margin: 0px 0px 15px"
                  >
                    <option>Select User Type</option>
                    <option value="customer ">Customer</option>
                    <option value="serviceProvider">Service Provider</option>
                  </select> -->
                <div id="serviceProviderFields" style="display: none">
                  <input id="businessName" class="form-control" type="text" name="businessName"
                    placeholder="Business Name" /><input id="nicNumber" class="form-control" type="text"
                    name="nicNumber" placeholder="NIC Number" /><input id="whatsappNumber" class="form-control"
                    type="tel" name="whatsappNumber" placeholder="WhatsApp Number" />
                  <div class="mb-3"></div>
                  <input id="serviceAddress" class="form-control" type="text" name="serviceAddress"
                    placeholder="Service Address" />
                  <select id="serviceType" name="serviceType" class="form-select"
                    style="border-radius: 5px; margin: 0px 0px 15px">
                    <option>Select Service Type</option>
                    <option value="sp_reservation">
                      Reservation Provider
                    </option>
                    <option value="sp_products">Product Seller</option>
                    <option value="sp_freelance">Freelancer</option>
                  </select>
                </div>

                <input id="password" class="form-control" type="password" name="password"
                  placeholder="Password (Standard)" required /><input id="confirmPassword" class="form-control"
                  type="password" name="confirmPassword" placeholder="Confirm Password" required />

                <button class="btn btn-primary shadow d-block w-100" type="submit">
                  Sign up
                </button>
              </form>
              <p class="text-muted">
                Already have an account?&nbsp;<a href="login.php">Log in</a>
              </p>
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
</body>

</html>