<?php
include '.\classes\db_connection.php'; // Include the dbconnector class

// Initialize $date variable
$date = isset($_GET['date']) ? $_GET['date'] : '';

$bookings = array();
if (!empty($date)) {
    $stmt = $conn->prepare('SELECT * FROM reservation WHERE date=?');
    $stmt->bind_param('s', $date);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['timeslot'];
            }
        }
        $stmt->close();
    }
}

if (isset($_POST['submit'])) {
    $timeslot = $_POST['timeslot'];
    $stmt = $conn->prepare('SELECT * FROM reservation WHERE date=? AND timeslot=?');
    $stmt->bind_param('ss', $date, $timeslot);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>Already Booked</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO reservation(date, timeslot) VALUES(?, ?)");
            $stmt->bind_param('ss', $date, $timeslot);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Booking Successful</div>";
            $bookings[] = $timeslot;
        }
    }
    $stmt->close();
}

// Retrieve timeslot settings for the selected date
$stmt = $conn->prepare("SELECT * FROM timeslot_settings WHERE date=? ORDER BY id DESC LIMIT 1");
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $duration = $row['duration'];
    $cleanup = $row['cleanup'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
} else {
    // Default values if no settings are found
    $duration = 30;
    $cleanup = 0;
    $start_time = "12:00";
    $end_time = "20:00";
}

$conn->close();

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
    }

    return $slots;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .btn {
            margin-right: 8px;
        }

        .today {
            background: yellow;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Book for date: <?php echo htmlspecialchars($date); ?></h1>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($msg) ? $msg : ''; ?>
            </div>
            <?php
            $timeslots = timeslots($duration, $cleanup, $start_time, $end_time);
            foreach ($timeslots as $ts) {
            ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <?php if (in_array($ts, $bookings)) { ?>
                            <button class="btn btn-danger"><?php echo $ts; ?></button>
                        <?php } else { ?>
                            <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                        <?php } ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="container">
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Booking: <span id="slot"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="timeslot">Timeslot</label>
                                        <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                    </div>
                                    <div class="form-group pull-right">
                                        <button class="btn btn-primary" type="submit" name="submit">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.book').on('click', function() {
            var timeslot = $(this).data('timeslot');
            $('#slot').text(timeslot);
            $('#timeslot').val(timeslot);
            $('#myModal').modal('show');
        });
    </script>
</body>

</html>