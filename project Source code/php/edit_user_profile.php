<?php
session_start();
$userType=$_SESSION['user_type'];


?>

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
        <h2>Update User Information</h2>
        <form action="/php/edit_process_user_profile.php?id=<?php echo $_SESSION['user_id']; ?>" method="POST">
          <?php if($userType=="customer"){
	 
            echo '<div class="form-group">
              <label for="firstName">First Name</label>
                <input type="text" class="form-control"  name="firstName" >
            </div>';
            echo '<div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control"  name="lastName">
            </div>';	
          }else{
            echo '<div class="form-group">
            <label for="firstName">First Name</label>
              <input type="text" class="form-control"  name="firstName" >
          </div>';
          echo '<div class="form-group">
              <label for="lastName">Last Name</label>
              <input type="text" class="form-control"  name="lastName">
          </div>';	
            echo '<div class="form-group">
                <label for="businessName">Business Name</label>
                <input type="text" class="form-control" name="businessName">
            </div>';
             echo '<div class="form-group">
                <label for="wphone">Whatsapp number</label>
                <input type="text" class="form-control" name="wphone">
            </div>';
             echo '<div class="form-group">             
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" >
            </div>';
             echo '<div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3" ></textarea>
            </div>';
            echo '<div class="form-group">             
                <label for="amountPer">Advance Amount</label>
                <input type="number" class="form-control" name="amountPer" >
            </div>';
          }
             
           /* <!--
            <div class="form-group">
                <label for="profileImage">Profile Image</label>
                <input type="file" class="form-control-file" id="profileImage" name="profileImage" required>
            </div>
            -->
            */
             echo '<button type="submit" class="btn btn-primary">Submit</button>';
          
          ?>
        </form>
    </div>
</body>
</html>
