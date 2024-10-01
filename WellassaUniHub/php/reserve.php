<?php
// Include your database connection script
include './classes/db_connection.php';
include './classes/UserClass.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();

// Function to generate new reservation ID
function generateReservationID($conn)
{
    $sql = "SELECT reservation_id FROM reservations ORDER BY reservation_id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['reservation_id'];
        $num = (int) substr($last_id, 4) + 1;
        return 'RES-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    } else {
        return 'RES-0001';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $timeslot_id = $_POST['timeslot_id'];
    $user_id = $_POST['current_id'];
    $cus_id = $user_id;
    // Generate new reservation ID
    $reservation_id = generateReservationID($conn);

    // Insert new reservation
    $sql = "INSERT INTO reservations (reservation_id, cus_id, timeslot_id, payment_status, reservation_date) VALUES (?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $reservation_id, $cus_id, $timeslot_id);
    if ($stmt->execute()) {
        // Update the timeslot status to 'booked'
        $update_sql = "UPDATE timeslots SET status = 'booked' WHERE timeslot_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("s", $timeslot_id);
        $update_stmt->execute();

        $message = "Reservation made successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Timeslot</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-link:hover {
            background-color: #45a049;
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

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reserve Timeslot</h1>
        <?php
        if (isset($message)) {
            $messageClass = strpos($message, 'Error') !== false ? 'error' : 'success';
            echo "<div class='message {$messageClass}'>{$message}</div>";
        }

        // Get the user ID from POST data if available, otherwise try GET
        $returnUserId = isset($_POST['cus_id']) ? $_POST['cus_id'] : (isset($_GET['userId']) ? $_GET['userId'] : '');
        ?>

        <a href="Bindex.php<?php echo $returnUserId ? '?userId=' . $returnUserId : ''; ?>" class="back-link">Back to Available Timeslots</a>
    </div>
</body>

</html>