<?php
include './php/classes/db_connection.php';
session_start();
if (isset($_SESSION['user_type'])) {
    $utype = $_SESSION['user_type'];
} else {
    $utype = "";
}

// Get search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>wellassaUniHub - Reservations</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo|Cinzel|Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        #searchInput {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
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
    <div class="container">
        <section class="py-5">
            <div class="container" style="color: var(--bs-highlight-color);">
                <h1 class="text-center mb-4"><strong>Reservations</strong></h1>

                <!-- Search Bar Section -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8">
                        <form class="d-flex" method="GET" style="border: none;">
                            <input id="searchInput" class="form-control me-2" type="search" name="search" placeholder="Search for Reservations" aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>" style="flex: 7;">
                            <button class="btn btn-outline-primary" type="submit" style="flex: 3;">Search</button>
                        </form>
                    </div>
                </div>

                <div class="container mt-5">
                    <div id="reservationContainer" class="row justify-content-center">
                        <?php
                        // SQL query to select data
                        $dbconnector = new DbConnection();
                        $conn = $dbconnector->getConnection();

                        //sql query for getting data
                        $sql = "SELECT * FROM user WHERE user_type = 'sp_reservation' AND status = 'active'";
                        if (!empty($search_query)) {
                            $sql .= " AND business_name LIKE ?";
                        }

                        $stmt = $conn->prepare($sql);
                        if (!empty($search_query)) {
                            $search_param = "%" . $search_query . "%";
                            $stmt->bind_param("s", $search_param);
                        }
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-4 reservation-item">';
                                echo '<div class="card mb-4 glass-card">';
                                echo '<img src=".' . htmlspecialchars($row['profile_photo']) . '" class="card-img-top img-fluid" alt="Profile Picture of ' . htmlspecialchars($row['business_name']) . '" style="height: 300px; object-fit: cover;">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($row['business_name']) . '</h5>';
                                echo '<p class="card-text text-truncate" >' . htmlspecialchars($row['description']) . '</p>';
                                echo '</div>';

                                if ($utype == "") {
                                    echo '<div class="d-flex justify-content-center">';
                                    echo '<a href="./signup.php" class="btn btn-primary rounded-pill mt-auto mb-3">Login to view</a>';
                                    echo '</div>';
                                } else {
                                    echo '<div class="d-flex justify-content-center">';
                                    echo '<a href="Reservation_view.php?userId=' . $row['user_id'] . '" class="btn btn-primary rounded-pill mt-auto mb-3">More Info</a>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-center">No reservations found matching your search criteria.</p>';
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const reservationContainer = document.getElementById('reservationContainer');
            const reservations = document.querySelectorAll('.reservation-item');

            searchInput.addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();

                reservations.forEach(reservation => {
                    const businessName = reservation.querySelector('.card-title').textContent.toLowerCase();
                    const description = reservation.querySelector('.card-text').textContent.toLowerCase();

                    if (businessName.includes(searchQuery) || description.includes(searchQuery)) {
                        reservation.style.display = 'block';
                    } else {
                        reservation.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>