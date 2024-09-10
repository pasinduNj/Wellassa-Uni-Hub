<?php
include './php/classes/db_connection.php';
session_start();
if (!isset($_SESSION['user_type'])) {
    $utype = "sp_reservation"; //$_SESSION['user_type'];
} else {
    $utype = "sp_reservation";
}

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
    <div class="container">
        <section class="py-5">
            <div class="container" style="color: var(--bs-highlight-color);">
                <h1 class="text-center mb-4"><strong>Reservations</strong></h1>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <?php

                        // SQL query to select data
                        $dbconnector = new DbConnection();
                        $conn = $dbconnector->getConnection();

                        //sql query for getting data
                        $sql = "SELECT * FROM user where user_type = 'sp_reservation' AND status = 'active'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-4">';
                                echo '<div class="card mb-4 glass-card">';
                                //formatted image link here
                                echo '<img src="' . $row['profile_photo'] . '" class="card-img-top img-fluid" alt="Profile Picture of ' . $row['business_name'] . '" style="height: 300px; object-fit: cover;">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . $row['business_name'] . '</h5>';
                                //Here goes the description of the card
                                //*****put the rating also */
                                echo '<p class="card-text text-truncate" >' . $row['description'] . '</p>';
                                echo '</div>';

                                //Guiding the button to affiliate page
                                //Check the type of user before showing the button in database
                                if ($utype == "") {
                                    echo '<div class="d-flex justify-content-center">';
                                    echo '<a href="./signup.php" class="btn btn-primary rounded-pill mt-auto mb-3">login for More</a>';
                                    echo '</div>';
                                } else {
                                    echo '<div class="d-flex justify-content-center">';
                                    //Put the correct link here, here i load the userId inthe link as hard coded . it should be dynamic
                                    echo '<a href="Reservation_view.php?userId=' . $row['user_id'] . '" class="btn btn-primary rounded-pill mt-auto mb-3">More Info</a>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            die("No records of service providers in the database");
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>


        </section>
    </div>
    </section>
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