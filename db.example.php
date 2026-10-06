<?php
// Copy this file to db.php and set your local MySQL credentials.
$host = '127.0.0.1';
$database = 'student_task_manager';
$username = 'root';
$password = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$database;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $error) {
    http_response_code(500);
    exit('Database connection failed. Check the local credentials in db.php and import database.sql.');
}
