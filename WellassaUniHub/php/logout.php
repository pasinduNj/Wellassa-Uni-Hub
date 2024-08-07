<!-- logout.php -->
<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Delete cookies if they exist

if (isset($_COOKIE['auth_key'])) {
    setcookie('auth_key', '', time() - 3600, '/');

}


// Redirect to the login page
header("Location: ../login.php");
exit();
?>
