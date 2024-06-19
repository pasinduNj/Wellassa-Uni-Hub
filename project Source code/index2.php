<?php
function build_calender($month, $year)
{
    $mysqli = new mysqli('localhost', 'root', '', 'bookingcalender');
    $stmt = $mysqli->prepare('select * from bbookings where MONTH(date)= ? AND YEAR(date)=?');
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['date'];
            }
            $stmt->close();
        }
    }



    $daysOfWeek = array('sunday', 'Monday', 'Tuesday', 'wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');

    $prev_month = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prev_year = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $next_month = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $next_year = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));
    $calender = "<center><h2>$monthName $year</h2>";
    $calender .= "<a class='btn btn-primary btn-sm' href='?month=" . $prev_month . "&year=" . $prev_year . "'>Prev Month</a>";
    $calender .= "<a class='btn btn-primary btn-sm' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a>";
    $calender .= "<a class='btn btn-primary btn-sm' href='?month=" . $next_month . "&year=" . $next_year . "'>Next Month</a></center>";

    $calender .= "<br><table class='table table-bordered' width='100%'table border ='1px solid black'  >";
    $calender .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calender .= "<th class='header'> $day</th>";
    }
    $calender .= "</th><tr>";
    $currentDay = 1;
    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calender .= "<td class='empty'></td>";
        }
    }


    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {


        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calender .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('l', strtotime($date)));
        $today = $date == date('Y-m-d') ? 'today' : '';
        if ($date < date('Y-m-d')) {
            $calender .= "<td class='$today'><h4>$currentDay</h4><a class='btn btn-danger btn-xs'>N/A</a></td>";
        } else {
            $totalbookings = checkSlots($mysqli, $date);
            if ($totalbookings == 16) {
                $calender .= "<td class='$today'><h4>$currentDay</h4><a href='#''.$date.''' class='btn btn-danger btn-xs'>All Booked</a></td>";
            } else {
                $availableslots = 16 - $totalbookings;
                $calender .= "<td class='$today'><h4>$currentDay</h4><a href='book.php?date=" . $date . "' class='btn btn-success btn-xs'>Book</a><small><li>$availableslots slots available</i></small></td>";
            }
        }

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calender .= "<td></td>";
        }
    }

    $calender .= "</tr>";
    $calender .= "</table>";




    return $calender;
}

function checkSlots($mysqli, $date)
{
    $stmt = $mysqli->prepare('select * from bbookings where date=?');
    $stmt->bind_param('s', $date);
    $totalbookings = 0;
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalbookings++;
            }
            $stmt->close();
        }
    }
    return $totalbookings;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src='main.js'></script>
    <style>
        .btn {
            margin-right: 8px;
        }

        .today {
            background: yellow;
        }

        @media only screen and (max-width:760px),
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
        }
    </style>
</head>


<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $dateComponents = getdate();
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                } else {
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                }

                echo build_calender($month, $year);


                ?>
            </div>
        </div>
    </div>

</body>

</html>