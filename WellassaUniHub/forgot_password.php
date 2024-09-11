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
    <title>Reset Password</title>
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
        include './navbar.php';  
    ?>
      
    <section class="py-5">
      <div class="container py-5">
        <div class="row mb-4 mb-lg-5">
          <div class="col-md-8 col-xl-6 text-center mx-auto">
            <p class="fw-bold text-success mb-2">Reset Password</p>
            <?php
            if (isset($_GET['S']) && $_GET['S'] == '1') {
                echo '<div class="alert alert-danger" role="alert">Error updating password</div>';
            }
            ?>
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
                  method="post"
                  action="php/reset_password.php"
                  data-bs-theme="light"
                  style="border-style: none"
                >
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
                  /><input
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
                    placeholder="New Password (Standard)"
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
                    Reset Password
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>
  </body>
</html>
