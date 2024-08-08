<?php
session_start();
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    />
    <title>Register Assistant</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=ABeeZee"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Cardo"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Cinzel"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Lato"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Muli"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700"
    />
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css" />
    <link
      rel="stylesheet"
      href="assets/css/-Filterable-Cards--Filterable-Cards.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/Account-setting-or-edit-profile.css"
    />
    <link rel="stylesheet" href="assets/css/book-table.css" />
    <link rel="stylesheet" href="assets/css/Bootstrap-Chat.css" />
    <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form.css" />
    <link rel="stylesheet" href="assets/css/Bootstrap-Payment-Form-.css" />
    <link rel="stylesheet" href="assets/css/Box-panels-box-panel.css" />
    <link rel="stylesheet" href="assets/css/Box-panels.css" />
    <link rel="stylesheet" href="assets/css/Chat.css" />
    <link rel="stylesheet" href="assets/css/content_blocks_modernstyle.css" />
    <link
      rel="stylesheet"
      href="assets/css/Customizable-Background--Overlay.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/Dropdown-Login-with-Social-Logins-bootstrap-social.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.min.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker.standalone.min.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/ebs-bootstrap-datepicker-bootstrap-datepicker3.standalone.min.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/ebs-bootstrap-datepicker-styles.css"
    />
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker.css" />
    <link
      rel="stylesheet"
      href="assets/css/Form-Select---Full-Date---Month-Day-Year.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
    />
    <link rel="stylesheet" href="assets/css/jQuery-Panel-styles.css" />
    <link rel="stylesheet" href="assets/css/jQuery-Panel.css" />
    <link rel="stylesheet" href="assets/css/LinkedIn-like-Profile-Box.css" />
    <link rel="stylesheet" href="assets/css/Lista-Productos-Canito.css" />
    <link rel="stylesheet" href="assets/css/NZ---TextboxLabel.css" />
    <link rel="stylesheet" href="assets/css/opening-times-time-picker.css" />
    <link rel="stylesheet" href="assets/css/project-footer.css" />
    <link rel="stylesheet" href="assets/css/Project-Nav-cart.css" />
    <link rel="stylesheet" href="assets/css/project-Nav.css" />
    <link
      rel="stylesheet"
      href="assets/css/Review-rating-Star-Review-Button-Review.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/Review-rating-Star-Review-Button.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/Sign-Up-Form---Gabriela-Carvalho.css"
    />
    <link rel="stylesheet" href="assets/css/Signup-page-with-overlay.css" />
    <link rel="stylesheet" href="assets/css/Single-Page-Contact-Us-Form.css" />
    <link rel="stylesheet" href="assets/css/Steps-Progressbar.css" />
    <link rel="stylesheet" href="assets/css/testnavnow.css" />
    <link
      rel="stylesheet"
      href="assets/css/Text-Box-2-Columns---Scroll---Hover-Effect.css"
    />
    <link rel="stylesheet" href="assets/css/User-rating.css" />
    <script src="/assets/js/scripts.js" defer></script>
  </head>

  <body>
  <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    
    ?>
      <div class="container">
        <span
          class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"
          ><svg
            xmlns="http://www.w3.org/2000/svg"
            width="1em"
            height="1em"
            fill="currentColor"
            viewBox="0 0 16 16"
            class="bi bi-gear-wide"
          >
            <path
              d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"
            ></path></svg></span
        ><a class="navbar-brand d-flex align-items-center" href="/"
          ><span>Wellassa UniHUB</span></a
        ><button
          data-bs-toggle="collapse"
          class="navbar-toggler"
          data-bs-target="#navcol-1"
        >
          <span class="visually-hidden">Toggle navigation</span
          ><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item dropdown" style="margin: 0px; padding: -1px">
              <a
                class="dropdown-toggle nav-link d-lg-flex align-items-lg-center"
                aria-expanded="false"
                data-bs-toggle="dropdown"
                href="Reservations.html"
                target="_blank"
                style="
                  margin: -1px;
                  padding: 9px;
                  font-weight: bold;
                  color: rgba(0, 0, 0, 0.65);
                "
                >Services</a
              >
              <div class="dropdown-menu">
                <a class="dropdown-item" href="Reservations.html"
                  >Reservations</a
                ><a class="dropdown-item" href="product.html">Order Products</a
                ><a class="dropdown-item" href="Freelance.html">Freelance</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.html/#contact">Contact Us</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                href="Service%20Provider.html"
                style="margin: 0px; padding: 8px; height: 36.6px"
                >Profile</a
              >
            </li>
          </ul>
          <a
            class="btn btn-primary shadow"
            role="button"
            href="php/logout.php"
            style="
              height: 35px;
              padding: 3px 10px;
              margin: 10px -10px 10px 10px;
              width: 78px;
              border-radius: 59px;
            "
            >Logout</a
          ><a
            class="font-monospace link-warning border-white d-inline-block float-end d-lg-flex align-items-lg-center pull-right"
            role="button"
            href="shopping-cart.html"
            style="
              padding: 1px;
              padding-left: 11px;
              margin: 0px;
              margin-left: 7px;
              margin-right: 5px;
              margin-bottom: 3px;
              padding-bottom: 7px;
              padding-top: 7px;
              padding-right: 12px;
              margin-top: 1px;
              transform: translate(24px) rotate(1deg) scale(1);
              box-shadow: 0px 0px;
              height: 31.6px;
              width: 63.2px;
              text-align: left;
              position: static;
            "
            ><i
              class="fa fa-shopping-cart"
              style="
                width: 27.2px;
                height: 33px;
                margin: -9px;
                padding: 2px;
                font-size: 25px;
              "
            ></i
            >&nbsp;Cart</a
          >
        </div>
      </div>
    </nav>
    <section class="py-5">
      <div class="container py-5">
        <div class="row mb-4 mb-lg-5">
          <div class="col-md-8 col-xl-6 text-center mx-auto">
            <p class="fw-bold text-success mb-2">Register Systam Assistant</p>
          </div>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-6 col-xl-4">
            <div class="card">
              <div
                class="card-body text-center d-flex flex-column align-items-center"
              >
                <div
                  class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="1em"
                    height="1em"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                    class="bi bi-person"
                  >
                    <path
                      d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z"
                    ></path>
                  </svg>
                </div>
                <form
                  id="signupForm"
                  action="php/signup.php"
                  method="post"
                  data-bs-theme="light"
                  style="border-style: none"
                >
                  <input type="hidden" name="userType" value="admin" />
                  <input
                    class="form-control"
                    id="firstName"
                    type="text"
                    placeholder="First Name"
                    name="firstName"
                    required
                  /><input
                    class="form-control"
                    id="lastName"
                    type="text"
                    placeholder="Last Name"
                    name="lastName"
                    required
                  />
                  <input
                    class="form-control"
                    id="email"
                    type="email"
                    name="email"
                    placeholder="Email"
                    required
                  />
                  <div class="mb-3"></div>
                  <input
                    class="form-control"
                    id="contactNumber"
                    type="tel"
                    name="contactNumber"
                    placeholder="Contact Number"
                    required
                  />
                  <div class="mb-3"></div>

                  <input
                    id="password"
                    class="form-control"
                    type="password"
                    name="password"
                    placeholder="Password (Standard)"
                    required
                  /><input
                    id="confirmPassword"
                    class="form-control"
                    type="password"
                    name="confirmPassword"
                    placeholder="Confirm Password"
                    required
                  />

                  <button
                    class="btn btn-primary shadow d-block w-100"
                    type="submit"
                  >
                    Register
                  </button>
                </form>
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
