<?php
// reservation_confirmation.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reservation Status</h1>
        <?php
        if (isset($_SESSION['payment_message'])) {
            echo "<div class='message success'>" . $_SESSION['payment_message'] . "</div>";
            unset($_SESSION['payment_message']);
        }

        $userId = isset($_GET['userId']) ? $_GET['userId'] : '';
        ?>

        <a href="../Reservation_view.php<?php echo $userId ? '?userId=' . $userId : ''; ?>" class="btn">Return to Home</a>
    </div>
</body>

</html>