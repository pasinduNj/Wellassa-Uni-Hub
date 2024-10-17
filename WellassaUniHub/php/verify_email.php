
<?php

include './classes/db_connection.php';
$db = new DbConnection();
$conn = $db->getConnection();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT user_id, password, expires_at FROM verify WHERE token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password, $expires_at);
        $stmt->fetch();
        if (strtotime($expires_at) > time()) {
            $stmt = $conn->prepare("UPDATE user SET password = ? WHERE user_id = ?");
            $stmt->bind_param('ss', $password, $user_id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            header("Location: ../login.php?S=1");
            exit();
        } else {
            header("Location: ../forgot_password.php?S=7");
            exit();
        }
    } else {
        header("Location: ../forgot_password.php?S=8");
        exit();
    }
} else {
    header("Location: ../forgot_password.php?S=9");
    exit();
}
