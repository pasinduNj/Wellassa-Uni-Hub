<?php
// Include your database connection script
include './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();


// Hardcoded customer ID for testing
$cus_id = 'CUS-001'; // Replace this with the actual customer ID you want to test with

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
</head>

<body>
    <div class="container">
        <h1>Reserve Timeslot</h1>
        <?php if (isset($message)) {
            echo "<p>$message</p>";
        } ?>
        <a href="Bindex.php">Back to Available Timeslots</a>
    </div>
</body>

</html>