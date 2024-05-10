<?php
$server = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_NAME'];

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Turns on exceptions for errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Sets default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES => false, // Disables emulation of prepared statements
];

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password, $options);
    // Optionally, enforce SSL connection if your environment supports it
    // $conn->setAttribute(PDO::MYSQL_ATTR_SSL_CA, '/path/to/server-cert.pem');
} catch(PDOException $e) {
    error_log($e->getMessage()); // Log error to server's error log
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    die('A database error occurred, please try again later.');
}