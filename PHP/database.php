<?php
$servername = "sql8.freesqldatabase.com";
$username = "sql8764433";
$password = "2d8yRrstHt";
$dbname = "sql8764433";


// Create database connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

