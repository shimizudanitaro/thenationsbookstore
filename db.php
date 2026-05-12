<?php
$host     = "localhost";
$user     = "root";
$password = "";        // your XAMPP MySQL password
$database = "bookstore";
$port     = 3306;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($host, $user, $password, $database, $port);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    // Log server-side if needed, but display helpful message in dev environment
    error_log('DB connection error: ' . $e->getMessage());
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>