<?php
$mysqli = new mysqli('localhost', 'root', '', 'wellassaunihub');

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $cleanup = $_POST['cleanup'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Insert or update timeslot settings for the specific date
    $stmt = $mysqli->prepare("REPLACE INTO timeslot_settings (date, duration, cleanup, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('siiss', $date, $duration, $cleanup, $start_time, $end_time);
    $stmt->execute();
    $stmt->close();

    $msg = "<div class='alert alert-success'>Timeslot settings updated successfully for $date.</div>";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Timeslots</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Manage Timeslots for Specific Dates</h1>
        <hr>
        <?php echo isset($msg) ? $msg : ''; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration (minutes)</label>
                <input type="number" class="form-control" name="duration" required>
            </div>
            <div class="form-group">
                <label for="cleanup">Cleanup Time (minutes)</label>
                <input type="number" class="form-control" name="cleanup" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" class="form-control" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" class="form-control" name="end_time" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save Settings</button>
        </form>
    </div>
</body>

</html>