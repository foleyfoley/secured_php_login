<?php

session_start();

if( isset($_SESSION['user_id']) ){
    header("Location: /php-login");
    exit();
}

require 'database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password'])):
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $pass = $_POST['password']; // Do not use raw, it should be hashed and verified.

    $stmt = $conn->prepare('SELECT id, password FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: /php-login");
        exit();
    } else {
        $message = 'Sorry, those credentials do not match';
    }

endif;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Below</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

    <div class="header">
        <a href="/php-login">Your App Name</a>
    </div>

    <?php if(!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <h1>Login</h1>
    <span>or <a href="register.php">register here</a></span>

    <form action="login.php" method="POST">
        
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="and password" name="password">

        <input type="submit">

    </form>

</body>
</html>
