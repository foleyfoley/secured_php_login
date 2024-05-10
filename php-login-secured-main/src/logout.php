<?php

session_start();

// Clear session variables
session_unset();

// Destroy the session
session_destroy();

// Invalidate the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page with absolute URL
$protocol = 'http://';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $protocol = 'https://';
}
header("Location: " . $protocol . $_SERVER['HTTP_HOST'] . "/php-login");
exit();