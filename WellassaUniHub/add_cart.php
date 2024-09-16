<?php
require_once './php/classes/db_connection.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Initialize database connection
$db = new DbConnection();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
    $image_path = isset($_POST['image_path']) ? $_POST['image_path'] : '';

    if ($product_id && $name && $price) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $product_id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'name' => $name,
                'price' => $price,
                'image_path' => $image_path,
                'quantity' => 1
            ];
        }
    }
}

if (isset($_GET['remove'])) {
    $key = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .cart-item img {
            max-width: 100px;
            height: auto;
        }

        .cart-item {
            margin-bottom: 20px;
        }

        .back-to-shop {
            position: absolute;
            top: 80px; /* Adjust based on navbar height */
            left: 20px;
            z-index: 1000;
        }

        .btn-custom {
            width: 60%;
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

    <!-- Back to Shop Button -->
    <a href="shop.php" class="btn btn-primary back-to-shop">Back to Shop</a>

    <div class="container mt-5">
        <h2 class="text-center">Shopping Cart</h2>
        <div class="row">
            <div class="col-md-12">
                <?php if (empty($cart)) : ?>
                    <p>Your cart is empty.</p>
                <?php else : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $key => $item) : ?>
                                <tr class="cart-item">
                                    <td><img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Product Image"></td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>LKR <?php echo htmlspecialchars($item['price']); ?></td>
                                    <td>
                                        <input type="number" class="form-control quantity" data-key="<?php echo $key; ?>" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                                    </td>
                                    <td>LKR <span class="item-total"><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></span></td>
                                    <td>
                                        <a href="?remove=<?php echo $key; ?>" class="btn btn-danger btn-custom">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <h4>Total: LKR <span id="cart-total"><?php echo number_format($total, 2); ?></span></h4>
                        <a href="checkout.php" class="btn btn-success btn-custom">Buy Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Update total when quantity changes
            $('.quantity').on('input', function () {
                const key = $(this).data('key');
                const quantity = parseInt($(this).val(), 10);
                const price = parseFloat($(this).closest('tr').find('td:nth-child(3)').text().replace('LKR ', ''));
                const itemTotal = price * quantity;
                $(this).closest('tr').find('.item-total').text(itemTotal.toFixed(2));

                // Update cart total
                let total = 0;
                $('.item-total').each(function () {
                    total += parseFloat($(this).text());
                });
                $('#cart-total').text(total.toFixed(2));

                // Optionally, you could also send an AJAX request to update the cart in the server-side session
                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: {
                        key: key,
                        quantity: quantity
                    }
                });
            });
        });
    </script>
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
