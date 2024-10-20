<?php
include './php/classes/db_connection.php';
session_start();

if (isset($_SESSION['user_name'])) {
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
    <title>Freelance | Get your works done here</title>
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
    <!--Header & navbar-->
    <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    ?>

    <!-- Search Bar Section -->
    <section class="search-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Freelancers</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form class="d-flex" method="GET" style="border: none;">
                        <input id="searchInput" class="form-control" type="search" name="search" placeholder="Search for Freelancers" aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>" style="flex: 7;">
                        <button class="btn btn-outline-success ms-2" type="submit" style="flex: 3;">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Display freelancers as cards-->
    <section class="store-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Freelancers</h2>

            <div class="container mt-5">
                <div id="freelancerContainer" class="row justify-content-center">
                    <?php
                    // SQL query to select data
                    $dbconnector = new DbConnection();
                    $conn = $dbconnector->getConnection();

                    //sql query for getting data
                    $sql = "SELECT * FROM user WHERE user_type = 'sp_freelance' AND status = 'active'";
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
                            echo '<div class="col-md-4 freelancer-item">';
                            echo '<div class="card mb-4 glass-card">';
                            echo '<img src=".' . $row['profile_photo'] . '" class="card-img-top img-fluid" alt="Profile Picture of ' . $row['business_name'] . '" style="height: 300px; object-fit: cover;">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row['business_name'] . '</h5>';
                            echo '<p class="card-text text-truncate" >' . $row['description'] . '</p>';
                            echo '</div>';

                            if ($utype == "") {
                                echo '<div class="d-flex justify-content-center">';
                                echo '<a href="./signup.php" class="btn btn-primary rounded-pill mt-auto mb-3">Login to View</a>';
                                echo '</div>';
                            } else {
                                echo '<div class="d-flex justify-content-center">';
                                echo '<a href="freelance_view.php?userId=' . $row['user_id'] . '" class="btn btn-primary rounded-pill mt-auto mb-3">More Info</a>';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-center">No freelancers found matching your search criteria.</p>';
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!--Footer-->
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
            const freelancerContainer = document.getElementById('freelancerContainer');
            const freelancers = document.querySelectorAll('.freelancer-item');

            searchInput.addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();

                freelancers.forEach(freelancer => {
                    const businessName = freelancer.querySelector('.card-title').textContent.toLowerCase();
                    const description = freelancer.querySelector('.card-text').textContent.toLowerCase();

                    if (businessName.includes(searchQuery) || description.includes(searchQuery)) {
                        freelancer.style.display = 'block';
                    } else {
                        freelancer.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>