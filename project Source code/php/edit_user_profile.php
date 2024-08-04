<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit User Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Submit User Data</h2>
        <form action="/php/edit_operation_user_profile.php" method="POST">
           
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="businessName">Business Name</label>
                <input type="text" class="form-control" id="businessName" name="businessName" required>
            </div>
            <div class="form-group">
                <label for="wphone">Whatsapp number</label>
                <input type="text" class="form-control" id="wphone" name="wphone" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <!--
            <div class="form-group">
                <label for="profileImage">Profile Image</label>
                <input type="file" class="form-control-file" id="profileImage" name="profileImage" required>
            </div>
-->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
