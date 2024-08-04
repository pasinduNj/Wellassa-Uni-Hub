<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Advertisement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Advertisement</h2>
        <form action="process_ad.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="description" class="form-label">Advertisement Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Advertisement Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="provider" class="form-label">Service Provider Name</label>
                <input type="text" class="form-control" id="provider" name="provider" required>
            </div>
            <div class="mb-3">
                <label for="till_date" class="form-label">Till Date</label>
                <input type="date" class="form-control" id="till_date" name="till_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>