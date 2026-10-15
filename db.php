<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_registration";

mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $database
);

if (!$conn) {
    error_log(mysqli_connect_error());
    die("Database connection failed. Check XAMPP and database settings.");
}

mysqli_set_charset($conn, "utf8mb4");
?>
