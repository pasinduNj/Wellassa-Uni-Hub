<?php
session_start();

// Handle adding product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $image_path = isset($_POST['image_path']) ? $_POST['image_path'] : null; // Ensure this is set

    if ($product_id && $name && $price) {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name' => $name,
                'price' => $price,
                'image_path' => $image_path, // Save image path
                'quantity' => 1
            ];
        } else {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        }
    }

    header('Location: add_cart.php');
    exit();
}

// Handle update and delete actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'update' && isset($_GET['id']) && isset($_GET['quantity'])) {
        $id = $_GET['id'];
        $quantity = $_GET['quantity'];
        if ($quantity > 0 && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    } elseif ($_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);
    }
}

// Get the cart items
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total amount
$totalAmount = 0;
foreach ($cart as $item) {
    if (isset($item['price']) && isset($item['quantity'])) {
        $totalAmount += $item['price'] * $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 100px;
            width: 100px;
        }

        .btn-sm {
            font-size: 0.875rem;
        }

        .quantity {
            width: 60px;
        }

        .cart-table th,
        .cart-table td {
            text-align: center;
        }

        .cart-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Shopping Cart</h2>
        <?php if (empty($cart)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <table class="table table-bordered cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name'] ?? ''); ?></td>
                            <td>
                                <?php if (!empty($item['image_path'])) : ?>
                                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" class="cart-image" alt="Product Image">
                                <?php else : ?>
                                    No image available
                                <?php endif; ?>
                            </td>
                            <td>LKR <?php echo htmlspecialchars($item['price'] ?? '0'); ?></td>
                            <td>
                                <input type="number" value="<?php echo htmlspecialchars($item['quantity'] ?? '1'); ?>" min="1" class="quantity" data-id="<?php echo htmlspecialchars($id); ?>">
                            </td>
                            <td>LKR <?php echo htmlspecialchars(($item['price'] ?? 0) * ($item['quantity'] ?? 0)); ?></td>
                            <td>
                                <a href="add_cart.php?action=delete&id=<?php echo htmlspecialchars($id); ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <h3>Total Amount: LKR <?php echo number_format($totalAmount, 2); ?></h3>
                <a href="checkout.php" class="btn btn-success">BuyNOW</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript to update quantity -->
    <script>
        document.querySelectorAll('.quantity').forEach(input => {
            input.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                const quantity = this.value;
                window.location.href = `add_cart.php?action=update&id=${id}&quantity=${quantity}`;
            });
        });
    </script>

    <!-- Bootstrap JS (optional, for additional components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>