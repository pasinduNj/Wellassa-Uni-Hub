<?php
// Include your database connection script
include './classes/db_connection.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();


// Hardcoded service provider ID for testing
//$sp_id = 'SP-001'; // Replace this with the actual service provider ID you want to test with
$sp_id = $_SESSION['user_id'];

function generateTimeslotID($conn)
{
    $sql = "SELECT timeslot_id FROM timeslots ORDER BY timeslot_id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['timeslot_id'];
        $num = (int) substr($last_id, 3) + 1;
        return 'TS-' . str_pad($num, 5, '0', STR_PAD_LEFT);
    } else {
        return 'TS-00001';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $interval_duration = intval($_POST['interval_duration']); // Get interval duration in minutes

    // Convert start and end times to DateTime objects
    $start_datetime = new DateTime("$date $start_time");
    $end_datetime = new DateTime("$date $end_time");

    while ($start_datetime < $end_datetime) {
        $timeslot_id = generateTimeslotID($conn);
        $slot_start_time = $start_datetime->format('H:i:s');
        $start_datetime->modify("+$interval_duration minutes");
        $slot_end_time = $start_datetime->format('H:i:s');

        $sql = "INSERT INTO timeslots (timeslot_id, sp_id, date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, 'free')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $timeslot_id, $sp_id, $date, $slot_start_time, $slot_end_time);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }

    header("Location: ../add_timeslot.php?S=1");
}
