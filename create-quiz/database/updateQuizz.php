<?php
// Receive the data of the quiz to be updated
$data = json_decode(file_get_contents("php://input"));

require("dbConnection.php");

// Get the ID of the quiz to be updated
$quizId = $data->idQuizz;
$newTitle = $data->title;
$newDescription = $data->description;
$newQuestions = $data->questions; // An array of question objects

// Define a variable to check if an error occurs
$hasError = false;

// Start a transaction
$conn->begin_transaction();

// Delete existing answers associated with the questions of the quiz
$sql = "SELECT idQuestion FROM question WHERE idQuiz = '$quizId'";
$result = $conn->query($sql);
if (!$result) {
    $hasError = true;
    echo "Error while fetching questions: " . $conn->error;
}

while ($row = $result->fetch_assoc()) {
    $questionId = $row['idQuestion'];

    // Delete answers from the correct_answer table associated with this question
    $sql = "DELETE FROM correct_answer WHERE idQuestion = '$questionId'";
    if (!$conn->query($sql)) {
        $hasError = true;
        echo "Error while deleting correct answers: " . $conn->error;
    }

    // Then, delete answers from the answer table associated with this question
    $sql = "DELETE FROM answer WHERE idQuestion = '$questionId'";
    if (!$conn->query($sql)) {
        $hasError = true;
        echo "Error while deleting answers: " . $conn->error;
    }
}

// Delete existing questions associated with this quiz
$sql = "DELETE FROM question WHERE idQuiz = '$quizId'";
if (!$conn->query($sql)) {
    $hasError = true;
    echo "Error while deleting questions: " . $conn->error;
}

// Update the title and description of the quiz
$sql = "UPDATE private_quiz SET title = '$newTitle', description = '$newDescription' WHERE idQuiz = '$quizId'";
if (!$conn->query($sql)) {
    $hasError = true;
    echo "Error while updating title and description: " . $conn->error;
}

// Insert new questions and answers
foreach ($newQuestions as $question) {
    $newQuestion = $question->question;
    $newAnswers = $question->answers; // An array of answers as strings
    $correctAnswer = $question->correctAnswer; // The index of the correct answer

    // Insert the new question
    $sql = "INSERT INTO question (question, idQuiz) VALUES ('$newQuestion', '$quizId')";
    if (!$conn->query($sql)) {
        $hasError = true;
        echo "Error while inserting question: " . $conn->error;
    }

    $questionId = $conn->insert_id;

    // Insert new answers
    foreach ($newAnswers as $index => $answerText) {
        $sql = "INSERT INTO answer (answer, idQuestion) VALUES ('$answerText', $questionId)";
        if ($conn->query($sql)) {
            $answerId = $conn->insert_id; // Get the ID of the inserted answer

            // If it's the correct answer, insert it into the correct_answer table
            if ($index == $correctAnswer) {
                $sql = "INSERT INTO correct_answer (idAns, idQuestion) VALUES ($answerId, $questionId)";
                if (!$conn->query($sql)) {
                    $hasError = true;
                    echo "Error while inserting correct answer: " . $conn->error;
                }
            }
        } else {
            $hasError = true;
            echo "Error while inserting answer: " . $conn->error;
        }
    }
}

// If no errors are detected, commit the transaction; otherwise, roll it back
if (!$hasError) {
    $conn->commit();
    echo "Quiz updated successfully!";
} else {
    $conn->rollback();
}

// Close the database connection
$conn->close();
?>
