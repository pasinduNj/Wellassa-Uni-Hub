<?php
// Include your database connection script and start the session
include './classes/db_connection.php';
include './classes/UserClass.php';
session_start();

$db = new DbConnection();
$conn = $db->getConnection();

// Get the current date
$currentDate = date('Y-m-d');

// Get the service provider ID from the GET parameter
$userId = $_GET['userId'];

// Fetch timeslots for the specific service provider from the current date and future dates
$sql = "SELECT timeslot_id, date, start_time, end_time, status FROM timeslots WHERE date >= ? AND sp_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentDate, $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Timeslots</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .booked {
            background-color: #f8d7da;
            color: #721c24;
        }

        .available {
            background-color: #d4edda;
            color: #155724;
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
    <script>
        function storeTimeslotId() {
            var selectedTimeslot = document.querySelector('input[name="timeslot_id"]:checked');
            if (selectedTimeslot) {
                sessionStorage.setItem('selected_timeslot_id', selectedTimeslot.value);
            }
            return true;
        }
    </script>
</head>

<body>
    <?php
    $user = $_SESSION['user_id'];
    ?>
    <div class="container">
        <h1>Available Timeslots from <?php echo $currentDate; ?> Onwards</h1>
        <?php if ($result->num_rows > 0) : ?>
            <form action="reserve.php" method="post" onsubmit="return storeTimeslotId()">
                <input type="hidden" name="cus_id" value="<?php echo $userId; ?>">
                <input type="hidden" name="current_id" value="<?php echo $user; ?>">
                <table>
                    <tr>
                        <th>Select</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="<?php echo $row['status'] === 'booked' ? 'booked' : 'available'; ?>">
                            <td>
                                <?php if ($row['status'] === 'free') : ?>
                                    <input type="radio" name="timeslot_id" value="<?php echo $row['timeslot_id']; ?>" required>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['end_time']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <input type="submit" value="Reserve">
                <a href="../Reservation_view.php<?php echo $userId ? '?userId=' . $userId : ''; ?>" class="btn">Return to Home</a>
            </form>
        <?php else : ?>
            <p>No available timeslots for this service provider from today onwards.</p>
            <a href="../Reservation_view.php<?php echo $userId ? '?userId=' . $userId : ''; ?>" class="btn">Return to Home</a>
        <?php endif; ?>
    </div>
</body>

</html>