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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Advertisements</title>
    <style>
        .slideshow-container {
            max-width: 800px;
            position: relative;
            margin: auto;
        }

        .mySlides {
            display: none;
        }

        .mySlides img {
            width: 100%;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @-webkit-keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }
    </style>
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

    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            if (slides[slideIndex - 1]) {
                slides[slideIndex - 1].style.display = "block";
            }
            if (dots[slideIndex - 1]) {
                dots[slideIndex - 1].className += " active";
            }
            setTimeout(showSlides, 5000); // Change image every 5 seconds
        }

        function plusSlides(n) {
            slideIndex += n - 1;
            showSlides();
        }

        function currentSlide(n) {
            slideIndex = n - 1;
            showSlides();
        }
    </script>

</body>

</html>