<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_siswa';

// Create connection using mysqli
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset to utf8mb4 for proper encoding
mysqli_set_charset($conn, "utf8mb4");
?>
