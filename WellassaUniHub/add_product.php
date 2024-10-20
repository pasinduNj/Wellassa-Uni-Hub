<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo|Cinzel|Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">
    <?php
    if (isset($_SESSION['user_name'])) {
        include './navbar2.php';
    } else {
        include './navbar.php';
    }
    ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Add Product</h2>
                        <form action="./php/add_product_process.php" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input type="number" class="form-control" id="price" name="price" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Stock Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="electronics">Electronics & Gadgets</option>
                                    <option value="stationery">Stationery & Office Supplies</option>
                                    <option value="textbooks">Textbooks & Study Materials</option>
                                    <option value="laptops-accessories">Laptops & Accessories</option>
                                    <option value="clothing">Clothing & Apparel</option>
                                    <option value="footwear">Footwear</option>
                                    <option value="backpacks">Bags & Backpacks</option>
                                    <option value="fitness">Fitness & Sports Gear</option>
                                    <option value="food">Food & Snacks</option>
                                    <option value="drinks">Beverages & Drinks</option>
                                    <option value="gifts">Gifts & Personalized Items</option>
                                    <option value="health-beauty">Health & Beauty Products</option>
                                    <option value="home-appliances">Home & Kitchen Appliances</option>
                                    <option value="furniture">Furniture & Dorm Essentials</option>
                                    <option value="gaming">Gaming & Entertainment</option>
                                    <option value="events-tickets">Event Tickets & Activities</option>
                                    <option value="camping">Camping & Outdoor Gear</option>
                                    <option value="art-crafts">Art & Crafts</option>
                                    <option value="mobile-accessories">Mobile & Accessories</option>
                                    <option value="subscription-services">Subscription Services (e.g., Software)</option>
                                    <option value="travel">Travel Accessories</option>
                                    <option value="bike-accessories">Bikes & Accessories</option>
                                    <option value="others">Others</option>
                                </select>

                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Product Image:</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 97%;">Add Product</button>
                            <a href="./user_profile.php" class="btn btn-success">Return to Profile</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include './footer.php';
    ?>
    <!-- Bootstrap JS (optional, for additional components) -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>