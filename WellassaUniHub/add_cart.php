<?php
session_start();
require_once './php/classes/db_connection.php';

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Initialize database connection
$db = new DbConnection();
$conn = $db->getConnection();

// Add product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = (float)$_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity'] += 1; // Increase quantity
            $found = true;
            break;
        }
    }

    // If not found, add a new entry
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1,
            'image_path' => $product_image
        ];
    }
}

// Handling AJAX requests for updating quantity or removing an item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_quantity') {
        $key = (int)$_POST['key'];
        $quantity = (int)$_POST['quantity'];

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }

        // Recalculate item total and cart total
        $item_total = $_SESSION['cart'][$key]['price'] * $_SESSION['cart'][$key]['quantity'];
        $cart_total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cart_total += $item['price'] * $item['quantity'];
        }

        // Return the updated totals as JSON response
        echo json_encode([
            'item_total' => number_format($item_total, 2),
            'cart_total' => number_format($cart_total, 2)
        ]);
        exit;
    } elseif ($_POST['action'] === 'remove_item') {
        $key = (int)$_POST['key'];

        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        // Recalculate cart total
        $cart_total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cart_total += $item['price'] * $item['quantity'];
        }

        // Return the updated cart total as JSON response
        echo json_encode([
            'cart_total' => number_format($cart_total, 2)
        ]);
        exit;
    }
}

// Regular PHP logic for displaying the cart
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
            top: 80px;
            /* Adjust based on navbar height */
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
                                <tr class="cart-item" data-key="<?php echo $key; ?>">
                                    <td><img src="<?php echo '.' . htmlspecialchars($item['image_path']); ?>" alt="Product Image"></td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>LKR <?php echo htmlspecialchars($item['price']); ?></td>
                                    <td>
                                        <input type="number" class="form-control quantity" data-key="<?php echo $key; ?>" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                                    </td>
                                    <td>LKR <span class="item-total"><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span></td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-custom remove-item" data-key="<?php echo $key; ?>">Remove</a>
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

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Update total when quantity changes using AJAX
            $('.quantity').on('input', function() {
                const key = $(this).data('key');
                const quantity = parseInt($(this).val(), 10);

                $.ajax({
                    url: '', // Current PHP file
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'update_quantity',
                        key: key,
                        quantity: quantity
                    },
                    success: function(response) {
                        // Update the item total and cart total in the UI
                        $(`tr[data-key="${key}"]`).find('.item-total').text(response.item_total);
                        $('#cart-total').text(response.cart_total);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Remove item using AJAX
            $('.remove-item').on('click', function(e) {
                e.preventDefault();
                const key = $(this).data('key');

                $.ajax({
                    url: '', // Current PHP file
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'remove_item',
                        key: key
                    },
                    success: function(response) {
                        // Remove the item from the cart in the UI
                        $(`tr[data-key="${key}"]`).remove();
                        $('#cart-total').text(response.cart_total);

                        // Check if the cart is empty
                        if ($('.cart-item').length === 0) {
                            $('.container').html('<p>Your cart is empty.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>