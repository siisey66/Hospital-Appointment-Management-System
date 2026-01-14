<?php
// Secure session cookie flags
declare(strict_types=1);
ini_set('session.cookie_httponly', '1');
ini_set('session.use_strict_mode', '1');
// config.php

session_start();

// Session expiry: 5 minutes inactivity
define('SESSION_TIMEOUT', 300);

if (!empty($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    setcookie('remember_me', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
    header("Location: login.php?expired=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();



$host = 'localhost';
$db   = 'hospital_app';
$user = 'root';
$pass = '';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die("Database connection failed.");
}
