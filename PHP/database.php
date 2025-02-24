<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mentalwellnessdb";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

