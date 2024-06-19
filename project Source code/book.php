<?php

$mysqli = new mysqli('localhost', 'root', '', 'bookingcalender');
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $stmt = $mysqli->prepare('select * from bbookings where date=?');
    $stmt->bind_param('s', $date);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['timeslot'];
            }
            $stmt->close();
        }
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $timeslots = $_POST['timeslot'];
    $stmt = $mysqli->prepare('select * from bbookings where date=? AND timeslot=?');
    $stmt->bind_param('ss', $date, $timeslots);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>Already Booked</div>";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO bbookings(name,email,date,timeslot)VALUES(?,?,?,?)");
            $stmt->bind_param('ssss', $name, $email, $date, $timeslots);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Booking Successful</div>";
            $bookings[] = $timeslots;
            $stmt->close();
            $mysqli->close();
        }
    }
}



$duration = 30;
$cleanup = 0;
$start = "12:00";
$end = "20:00";
function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $claenupinterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($claenupinterval)) {
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

    <title></title>

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

        /* @media only screen and (max-width:760px),
        (min-device-width:802px) and (max-device-width:1020px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            .empty {
                display: none;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:nth-of-type(1)::before {
                content: "Sunday";
            }

            td:nth-of-type(2)::before {
                content: "Monday";
            }

            td:nth-of-type(3)::before {
                content: "Tuesday";
            }

            td:nth-of-type(4)::before {
                content: "Wednesday";
            }

            td:nth-of-type(5)::before {
                content: "Thursday";
            }

            td:nth-of-type(6)::before {
                content: "Friday";
            }

            td:nth-of-type(7)::before {
                content: "Saturday";
            }

        }

        @media(min-width:641px) {
            table {
                table-layout: fixed;
            }

            td {
                width: 33%;
            }

            .row {
                margin-top: 20px;
            }

            .today {
                background: yellow;
            }
        } */
    </style>
</head>


<body>

    <div class="container">
        <h1 class="text-center">Book for date : <?php echo $date; ?></h1>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($msg) ? $msg : ''; ?>
            </div>
            <?php
            $timeslots = timeslots($duration, $cleanup, $start, $end);
            foreach ($timeslots as $ts) {
            ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <?php if (in_array($ts, $bookings)) { ?>
                            <button class="btn btn-danger book"><?php echo $ts; ?></button>
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
    </div>
    <div class="container">
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Booking :<span id="slot"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="timeslot">Timeslot</label>
                                        <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input required type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input required type="email" name="email" class="form-control">
                                    </div>
                                    <div class="form-group pull right">
                                        <button class="btn btn-primary" type="submit" name="submit">submit</button>
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

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <script>
        $('.book').on('click', (function() {
            var timeslot = $(this).attr('data-timeslot');
            $('#slot').html(timeslot);
            $('#timeslot').val(timeslot);
            $('#myModal').modal('show');
        }))
    </script>
</body>

</html>