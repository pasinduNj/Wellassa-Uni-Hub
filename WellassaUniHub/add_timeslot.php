<?php
// Include your database connection script
include './php/classes/db_connection.php';
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

    echo "Timeslots added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Timeslots</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }

        .container-form {

            width: 50%;
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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


    <div class="main-content">
        <div class="container-form">
            <h2>Add Timeslots</h2>
            <form action="add_timeslot.php" method="post">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required>

                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required>

                <label for="interval_duration">Interval Duration (minutes):</label>
                <input type="number" id="interval_duration" name="interval_duration" required min="1" value="30">

                <input type="submit" value="Add Timeslots">
            </form>
        </div>
    </div>

    <?php
    include './footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>