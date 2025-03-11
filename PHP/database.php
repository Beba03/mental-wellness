<?php
$servername = "sql8.freesqldatabase.com";
$username = "sql8767118";
$password = "ACVyISAule";
$dbname = "sql8767118";


// Create database connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>