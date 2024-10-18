<?php
// Retrieve data sent from the client (validate and protect against CSRF and SQL injections)
$data = json_decode(file_get_contents("php://input"));

require("dbConnection.php");

// Initialize the response variable
$response = "";
$timestamp = time();
$date = date("Y-m-d H:i:s", $timestamp);

// Initialize a variable to track if the transaction should be committed or rolled back
$commitTransaction = true;

// Start a new transaction
$conn->begin_transaction();

try {
    // Adding a new leaderboard
    //$newQuizz = $data->newQuizz;
    $newQuizz = $data;
    $sql = "INSERT INTO leaderboard (idLeaderboard) VALUES (NULL)";

    if ($conn->query($sql) === TRUE) {
        // Get the ID of the leaderboard you just inserted
        $leaderboardId = $conn->insert_id;
        $response .= "New leaderboard added successfully with ID: $leaderboardId.\n";

        // Adding new quizz
        $title = $newQuizz->title;
        $description = $newQuizz->description;
        $userName = $newQuizz->userName;
        $idQuiz = $newQuizz->idQuizz;

        // First, insert a new quizz with a null ID
        $sql = "INSERT INTO private_quiz (idQuiz, title, description, idLeaderboard, userName,creation_date) VALUES ('$idQuiz', '$title', '$description', $leaderboardId, '$userName','$date')";

        if ($conn->query($sql) === TRUE) {
            // Get the ID of the quizz you just inserted
            $response .= "New quizz added successfully with ID: $idQuiz.\n";

            // Adding questions and answers
            $questions = $newQuizz->questions;

            foreach ($questions as $questionData) {
                $question = $questionData->question;
                $sql = "INSERT INTO question (question, idQuiz) VALUES ('$question', '$idQuiz')";

                if ($conn->query($sql) === TRUE) {
                    $questionId = $conn->insert_id;
                    $response .= "New question added successfully with ID: $questionId.\n";

                    $answers = $questionData->answers;
                    $correctAnswer = $questionData->correctAnswer;

                    $insertedAnswers = array(); // Pour suivre les réponses insérées

                    foreach ($answers as $index => $answer) {
                        $sql = "INSERT INTO answer (answer, idQuestion) VALUES ('$answer', $questionId)";

                        if ($conn->query($sql) === TRUE) {
                            $insertedAnswers[] = $conn->insert_id;
                            $response .= "New answer added successfully for question ID: $questionId.\n";
                        } else {
                            $commitTransaction = false; // Marquer la transaction pour un rollback
                            $response .= "Error adding answer: " . $conn->error . "\n";
                        }
                    }

                    // Vérifier si l'indice de la réponse correcte est valide
                    if ($correctAnswer >= 0 && $correctAnswer < count($insertedAnswers)) {
                        $correctAnswerId = $insertedAnswers[$correctAnswer];
                        $sql = "INSERT INTO correct_answer (idAns, idQuestion) VALUES ($correctAnswerId, $questionId)";

                        if ($conn->query($sql) === TRUE) {
                            $response .= "Correct answer added successfully for question ID: $questionId.\n";
                        } else {
                            $commitTransaction = false; // Marquer la transaction pour un rollback
                            $response .= "Error adding correct answer: " . $conn->error . "\n";
                        }
                    } else {
                        $commitTransaction = false; // Marquer la transaction pour un rollback
                        $response .= "Invalid correctAnswer index.\n";
                    }
                } else {
                    $commitTransaction = false; // Marquer la transaction pour un rollback
                    $response .= "Error adding question: " . $conn->error . "\n";
                }
            }
        } else {
            $commitTransaction = false; // Marquer la transaction pour un rollback
            $response .= "Error adding quizz: " . $conn->error . "\n";
        }
    } else {
        $commitTransaction = false; // Marquer la transaction pour un rollback
        $response = "Error adding leaderboard: " . $conn->error . "\n";
    }

    // Si tout s'est bien passé, commit la transaction
    if ($commitTransaction) {
        $conn->commit();
    } else {
        $conn->rollback();
    }
} catch (Exception $e) {
    // En cas d'exception, effectuez un rollback
    $conn->rollback();
    $response = "Transaction failed: " . $e->getMessage() . "\n";
}

// Close the database connection
$conn->close();

// Return the response as text
echo $response;
?>
