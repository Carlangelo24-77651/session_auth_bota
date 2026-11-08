<?php
// db.php - database connection + secure session start
$host = '127.0.0.1';
$db   = 'auth_demo';
$user = 'root';
$pass = '';          // XAMPP default is empty


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('Database connection failed.');
}


if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,       // JS cannot read the session cookie
        'samesite' => 'Strict',
    ]);
    session_start();
}


function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }