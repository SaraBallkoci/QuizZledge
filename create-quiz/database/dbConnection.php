<?php
// Connect to your database (customize this according to your database)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quizzledge";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>