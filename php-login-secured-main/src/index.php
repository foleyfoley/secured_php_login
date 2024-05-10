<?php

session_start();

require 'database.php';

$user = NULL;

if( isset($_SESSION['user_id']) ){
    $stmt = $conn->prepare('SELECT id, email FROM users WHERE id = :id');
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Your Web App</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

    <div class="header">
        <a href="/php-login">Your Web App</a>
    </div>

    <?php if( $user ): ?>

        <br />Welcome <?= htmlspecialchars($user['email']); ?>
        <br /><br />You are successfully logged in!
        <br /><br />
        <a href="logout.php">Logout?</a>

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>

</body>
</html>