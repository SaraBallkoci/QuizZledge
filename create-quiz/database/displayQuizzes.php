<?php
// Connect to your database
require("dbConnection.php");


// Initialize the response variable
$response = array();

// Fetch quizzes from the database
$sql = "SELECT * FROM private_quiz ORDER BY creation_date DESC"; // Adjust this query as per your database schema

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the response as JSON
echo json_encode($response);
?>
