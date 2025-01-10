<?php
session_start();
require_once './php/classes/db_connection.php';
require_once './php/classes/Product.php';

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Initialize database connection
$db = new DbConnection();
$conn = $db->getConnection();

// Initialize Product class
$product = new Product($conn);

// Add product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = (float)$_POST['product_price'];
    $product_image = $_POST['product_image'];
    $available_stock = (int)$_POST['available_stock'];

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            // If product is already in cart, increment quantity if stock allows
            if ($item['quantity'] < $available_stock) {
                $_SESSION['cart'][$key]['quantity']++;
            }
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
            'image_path' => $product_image,
            'available_stock' => $available_stock
        ];
    }
}

// Handling AJAX requests for updating quantity or removing an item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_quantity') {
        $key = (int)$_POST['key'];
        $quantity = (int)$_POST['quantity'];

        if (isset($_SESSION['cart'][$key])) {
            $product_id = $_SESSION['cart'][$key]['id'];
            $productDetails = $product->getProductById($product_id);
            $available_stock = $productDetails['quantity'];

            // Limit quantity to available stock
            $_SESSION['cart'][$key]['quantity'] = min($quantity, $available_stock);
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
            'cart_total' => number_format($cart_total, 2),
            'quantity' => $_SESSION['cart'][$key]['quantity'],
            'available_stock' => $available_stock
        ]);
        exit;
    } elseif ($_POST['action'] === 'remove_item') {
        $key = (int)$_POST['key'];

        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
        }

        // Recalculate cart total
        $cart_total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cart_total += $item['price'] * $item['quantity'];
        }

        // Return the updated cart total and remaining items as JSON response
        echo json_encode([
            'cart_total' => number_format($cart_total, 2),
            'remaining_items' => count($_SESSION['cart'])
        ]);
        exit;
    }
}

// Regular PHP logic for displaying the cart
$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $key => $item) {
    // Update available stock for each item
    $productDetails = $product->getProductById($item['id']);
    $_SESSION['cart'][$key]['available_stock'] = $productDetails['quantity'];
    $total += $item['price'] * $item['quantity'];
}

// PayHere integration
$merchant_id = '1228450'; // Replace with your PayHere Merchant ID
$merchant_secret = "NjY3MjAxNzYzNDE0NjczMDA5OTQwNDk4MTA0NTEzNTU2MDI4NDA2";
$currency = "LKR";
$order_id = time(); // Use time as unique order ID

// Generate hash for PayHere
$hash = strtoupper(md5($merchant_id . $order_id . number_format($total, 2, '.', '') . $currency . strtoupper(md5($merchant_secret))));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo|Cinzel|Poppins:200,300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
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
                        <tbody id="cart-items">
                            <?php foreach ($cart as $key => $item) : ?>
                                <tr class="cart-item" data-key="<?php echo $key; ?>">
                                    <td><img src="<?php echo '.' . htmlspecialchars($item['image_path']); ?>" alt="Product Image"></td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>LKR <?php echo htmlspecialchars($item['price']); ?></td>
                                    <td>
                                        <input type="number" class="form-control quantity"
                                            data-key="<?php echo $key; ?>"
                                            value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                            min="1"
                                            max="<?php echo htmlspecialchars($item['available_stock']); ?>">
                                        <small class="text-muted">Available: <?php echo htmlspecialchars($item['available_stock']); ?></small>
                                    </td>
                                    <td>LKR <span class="item-total"><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span></td>
                                    <td>
                                        <button class="btn btn-danger btn-custom remove-item" data-key="<?php echo $key; ?>">Remove</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <h4>Total: LKR <span id="cart-total"><?php echo number_format($total, 2); ?></span></h4>
                        <button class="btn btn-success btn-custom" onclick="paymentGateWay()">Buy Now</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include './footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.payhere.lk/lib/payhere.js"></script>

    <script>
        $(document).ready(function() {
            // Update total when quantity changes using AJAX
            $(document).on('input', '.quantity', function() {
                const key = $(this).data('key');
                const quantity = parseInt($(this).val(), 10);
                const max = parseInt($(this).attr('max'), 10);

                // Ensure quantity doesn't exceed max
                if (quantity > max) {
                    $(this).val(max);
                }

                $.ajax({
                    url: '', // Current PHP file
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'update_quantity',
                        key: key,
                        quantity: Math.min(quantity, max)
                    },
                    success: function(response) {
                        // Update the item total and cart total in the UI
                        $(`tr[data-key="${key}"]`).find('.item-total').text(response.item_total);
                        $('#cart-total').text(response.cart_total);
                        // Update the quantity input
                        $(`tr[data-key="${key}"]`).find('.quantity').val(response.quantity);
                        // Update the available stock display
                        $(`tr[data-key="${key}"]`).find('small').text(`Available: ${response.available_stock}`);
                        // Update the total for the payment gateway
                        window.cartTotal = parseFloat(response.cart_total.replace(',', ''));
                        // Update the hash for PayHere
                        updatePayHereHash(window.cartTotal);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Remove item using AJAX
            $(document).on('click', '.remove-item', function(event) {
                event.preventDefault();
                const key = $(this).data('key');
                const row = $(this).closest('tr');

                $.ajax({
                    url: '',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'remove_item',
                        key: key
                    },
                    success: function(response) {
                        // Update the cart total in the UI
                        $('#cart-total').text(response.cart_total);
                        // Remove the item from the table
                        row.remove();
                        // Update the total for the payment gateway
                        window.cartTotal = parseFloat(response.cart_total.replace(',', ''));
                        // Update the hash for PayHere
                        updatePayHereHash(window.cartTotal);

                        // If cart is empty, show empty cart message
                        if (response.remaining_items === 0) {
                            $('#cart-items').html('<tr><td colspan="6"><p>Your cart is empty.</p></td></tr>');
                            $('.btn-success').prop('disabled', true);
                        } else {
                            // Re-index the data-key attributes
                            $('.cart-item').each(function(index) {
                                $(this).attr('data-key', index);
                                $(this).find('.quantity').attr('data-key', index);
                                $(this).find('.remove-item').attr('data-key', index);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

        function updatePayHereHash(total) {
            const merchantId = '<?php echo $merchant_id; ?>';
            const merchantSecret = '<?php echo $merchant_secret; ?>';
            const orderId = '<?php echo $order_id; ?>';
            const currency = '<?php echo $currency; ?>';

            // Format total to two decimal places
            const formattedTotal = parseFloat(total).toFixed(2);

            // Generate new hash
            const hashString = merchantId + orderId + formattedTotal + currency + CryptoJS.MD5(merchantSecret).toString().toUpperCase();
            const newHash = CryptoJS.MD5(hashString).toString().toUpperCase();

            // Update global hash variable
            window.payHereHash = newHash;
        }

        function paymentGateWay() {
            const orderId = '<?php echo $order_id; ?>';
            const total = window.cartTotal || <?php echo number_format($total, 2, '.', ''); ?>;

            // Ensure the amount is formatted correctly (two decimal places)
            const formattedTotal = parseFloat(total).toFixed(2);

            const payment = {
                "sandbox": true,
                "merchant_id": "<?php echo $merchant_id; ?>",
                "return_url": "http://localhost/notify.php",
                "cancel_url": "http://localhost/notify.php",
                "notify_url": "http://localhost/notify.php",
                "order_id": orderId,
                "items": "Your Order",
                "currency": "<?php echo $currency; ?>",
                "amount": formattedTotal,
                "first_name": "<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>",
                "last_name": "",
                "email": "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>",
                "phone": "",
                "address": "",
                "city": "",
                "country": "",
                "hash": window.payHereHash || "<?php echo $hash; ?>"
            };

            console.log("Payment object:", payment); // Ensure values are correct

            payhere.startPayment(payment);
        }
    </script>
</body>

</html>