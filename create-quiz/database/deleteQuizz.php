<?php
require("dbConnection.php");


$idQuizzToDelete = $conn->real_escape_string($_GET['quizId']); // Secure the input
$idLeaderboard = $conn->real_escape_string($_GET['leaderboardId']); // Secure the input

// Start a database transaction for data consistency
$conn->begin_transaction();

try {
    // Delete records from the `correct_answer` table
    $sql = "DELETE FROM correct_answer WHERE idQuestion IN (SELECT idQuestion FROM question WHERE idQuiz = '$idQuizzToDelete')";
    $conn->query($sql);

    // Delete records from the `answer` table
    $sql = "DELETE FROM answer WHERE idQuestion IN (SELECT idQuestion FROM question WHERE idQuiz = '$idQuizzToDelete')";
    $conn->query($sql);

    // Delete records from the `question` table
    $sql = "DELETE FROM question WHERE idQuiz = '$idQuizzToDelete'";
    $conn->query($sql);

    // Delete the record from the `private_quiz` table
    $sql = "DELETE FROM private_quiz WHERE idQuiz = '$idQuizzToDelete'";
    $conn->query($sql);

    // Delete the associated leaderboard (you need to customize this part)
    $sql = "DELETE FROM leaderboard WHERE idLeaderboard = '$idLeaderboard'";
    $conn->query($sql);

    // Commit the transaction (if all queries were successful)
    $conn->commit();

    echo "Quiz with ID $idQuizzToDelete has been deleted along with related data, including the associated leaderboard.";
} catch (Exception $e) {
    // Rollback the transaction if an error occurs
    $conn->rollback();
    echo "An error occurred: " . $e->getMessage();
}

// Close the database connection
$conn->close();
?>
