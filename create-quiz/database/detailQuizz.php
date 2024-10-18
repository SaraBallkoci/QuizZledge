<?php

require("dbConnection.php");

$quizId = $conn->real_escape_string($_GET['quizId']); // Secure the input

// Retrieve quiz information
$sql = "SELECT * FROM private_quiz WHERE idQuiz = '$quizId'";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    $quizInfo = $result->fetch_assoc();

    // Retrieve questions associated with the quiz
    $sql = "SELECT * FROM question WHERE idQuiz = '$quizId'";
    $result = $conn->query($sql);

    $questions = array();
    while ($result !== false && $row = $result->fetch_assoc()) {
        $questionId = $row['idQuestion'];

        // Retrieve answers associated with the question
        $sqlAnswers = "SELECT * FROM answer WHERE idQuestion = '$questionId'";
        $resultAnswers = $conn->query($sqlAnswers);

        $answers = array();
        while ($resultAnswers !== false && $rowAnswers = $resultAnswers->fetch_assoc()) {
            $answers[] = $rowAnswers;
        }

        // Retrieve the correct answer associated with the question
        $sqlCorrectAnswer = "SELECT answer FROM answer WHERE idAns = (
            SELECT idAns FROM correct_answer WHERE idQuestion = '$questionId'
        )";
        $resultCorrectAnswer = $conn->query($sqlCorrectAnswer);

        if ($resultCorrectAnswer !== false) {
            $correctAnswer = $resultCorrectAnswer->fetch_assoc();
            if ($correctAnswer !== null) {
                $row['correctAnswer'] = $correctAnswer['answer'];
            }
        }

        $row['answers'] = $answers;
        $questions[] = $row;
    }

    $quizInfo['questions'] = $questions;

    // Convert to JSON format and send the response
    header("Content-Type: application/json");
    echo json_encode($quizInfo);
} else {
    echo "Quiz not found";
}

// Close the connection
$conn->close();

?>
