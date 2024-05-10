<?php

session_start();

if( isset($_SESSION['user_id']) ){
    header("Location: /php-login");
    exit();
}

require 'database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])):
    
    if($_POST['password'] !== $_POST['confirm_password']) {
        $message = 'Passwords do not match.';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $message = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if($stmt->execute()):
                $message = 'Successfully created new user';
                header('Location: login.php');
                exit();
            else:
                $message = 'Sorry there must have been an issue creating your account';
            endif;
        }
    }
endif;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Below</title>
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

    <h1>Register</h1>
    <span>or <a href="login.php">login here</a></span>

    <form action="register.php" method="POST">
        
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="Enter password" name="password">
        <input type="password" placeholder="Confirm password" name="confirm_password">
        <input type="submit">

    </form>

</body>
</html>