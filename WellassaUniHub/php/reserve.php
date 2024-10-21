<?php
// Include your database connection script
include './classes/db_connection.php';
include './classes/UserClass.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();
//timeslotID
$timeslot_id = $_POST['timeslot_id'];
//provider_id
$userId = $_POST['cus_id'];
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

// Function to get timeslot details
function getTimeslotDetails($conn, $timeslot_id)
{
    $sql = "SELECT date, start_time, end_time FROM timeslots WHERE timeslot_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $timeslot_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$timeslot_details = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $timeslot_id = $_POST['timeslot_id'];
    $user_id = $_POST['current_id'];
    $cus_id = $user_id;

    // Get timeslot details
    $timeslot_details = getTimeslotDetails($conn, $timeslot_id);

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

        $message = "Reservation created! Please proceed to payment.";
        $_SESSION['reservation_id'] = $reservation_id;
        $_SESSION['timeslot_id'] = $timeslot_id;
    } else {
        $message = "Error: " . $stmt->error;
    }
}

// If timeslot_id is in session but details aren't loaded (e.g., on page refresh)
if (!$timeslot_details && isset($_SESSION['timeslot_id'])) {
    $timeslot_details = getTimeslotDetails($conn, $_SESSION['timeslot_id']);
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

        .timeslot-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .timeslot-details h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .detail-row {
            margin: 10px 0;
        }

        .detail-label {
            font-weight: bold;
            margin-right: 10px;
        }

        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-btn {
            background-color: #4CAF50;
        }

        .payment-btn {
            background-color: #007bff;
        }

        .back-btn:hover {
            background-color: #45a049;
        }

        .payment-btn:hover {
            background-color: #0056b3;
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
    <?php
    //current_id
    $user = $_SESSION['user_id'];

    ?>
    <div class="container">
        <h1>Reserve Timeslot</h1>
        <?php
        if (isset($message)) {
            $messageClass = strpos($message, 'Error') !== false ? 'error' : 'success';
            echo "<div class='message {$messageClass}'>{$message}</div>";
        }

        // Display timeslot details if available
        if ($timeslot_details) {
            echo '<div class="timeslot-details">';
            echo '<h2>Selected Timeslot</h2>';
            echo '<div class="detail-row"><span class="detail-label">Date:</span>' . $timeslot_details['date'] . '</div>';
            echo '<div class="detail-row"><span class="detail-label">Start Time:</span>' . $timeslot_details['start_time'] . '</div>';
            echo '<div class="detail-row"><span class="detail-label">End Time:</span>' . $timeslot_details['end_time'] . '</div>';
            echo '<div class="detail-row"><span class="detail-label">timeslotid:</span>' . $timeslot_id . '</div>';
            echo '</div>';
        }

        // Get the user ID from POST data if available, otherwise try GET
        $returnUserId = isset($_POST['cus_id']) ? $_POST['cus_id'] : (isset($_GET['userId']) ? $_GET['userId'] : '');
        ?>

        <div class="button-group">
            <a href="cancel_reservation.php<?php echo $returnUserId ? '?userId=' . $returnUserId : ''; ?>" class="btn back-btn">Back to Available Timeslots</a>
            <?php if (isset($_SESSION['reservation_id'])) : ?>
                <form action="process_payment.php" method="post" style="display: inline;">
                    <input type="hidden" name="reservation_id" value="<?php echo $_SESSION['reservation_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $returnUserId; ?>">
                    <input type="hidden" name="cus_id" value="<?php echo $userId; ?>">
                    <input type="hidden" name="current_id" value="<?php echo $user; ?>">
                    <input type="hidden" name="timeslot_id" value="<?php echo $timeslot_id; ?>">
                    <button type="submit" class="btn payment-btn">Proceed to Payment</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>