<?php
require './classes/db_connection.php';

$db = new DbConnection();
$conn = $db->getConnection();

// Delete expired advertisements
$today = date('Y-m-d');
$delete_sql = "DELETE FROM advertisements WHERE until_date < ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("s", $today);
$delete_stmt->execute();
$delete_stmt->close();

$sql = "SELECT * FROM advertisements ORDER BY upload_date DESC";
$result = $conn->query($sql);

$ads = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ads[] = $row;
    }
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="assets/css/advertisements.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Advertisements</title>
    
</head>

<body>

    <h1>Advertisements</h1>

    <div class="slideshow-container">
        <?php foreach ($ads as $index => $ad) : ?>
            <div class="mySlides fade">
                <div class="numbertext"><?= $index + 1 ?> / <?= count($ads) ?></div>
                <img src="<?= htmlspecialchars($ad['image_path']) ?>" alt="<?= htmlspecialchars($ad['title']) ?>">
                <div class="text"><?= htmlspecialchars($ad['title']) ?><br><?= htmlspecialchars($ad['description']) ?><br>Expires on: <?= $ad['until_date'] ?></div>
            </div>
        <?php endforeach; ?>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <br>

    <div style="text-align:center">
        <?php for ($i = 1; $i <= count($ads); $i++) : ?>
            <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
        <?php endfor; ?>
    </div>
    <script src="assets/js/advertisement.js"></script>

</body>

</html>