<?php
session_start();

$userName = $_SESSION['user'];
$category = $_SESSION['category']; 
$totalQuestions = $_SESSION['amountOfQuestions'];

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "quizzledge";

$db = new mysqli($servername, $username, $password, $database);

if ($db->connect_errno) {
    die("Connection failed: " . mysqli_connect_error());
}

// Store questions and user answer pairs to session
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents("log.txt", print_r($data, true)); // This will write the payload to a log.txt file

// Calculate wrong answers after initializing $data

$response = ['success' => false];
$operationSuccess = false; // Initialized to default value

if (isset($data['responses'])) {
    $_SESSION['responses'] = $data['responses'];
    $response['success'] = true;
}

// Compare score to previous score and update if higher
if (isset($data['score'])) {
    $_SESSION['score'] = $data['score'];
    $response['success'] = true;

    // Get leaderboard id based on category name
    $stmt = $db->prepare("SELECT idLeaderboard FROM online_quiz WHERE categoryIndex = ?");
    $stmt->bind_param("s", $category);
    if ($stmt->execute()) {
        //file_put_contents("log.txt", "FIRST QUERRY WORKED", FILE_APPEND);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idLeaderboard = $row['idLeaderboard'];

    // Fetch the current score for this user on this leaderboard
    $stmt = $db->prepare("SELECT correctAnswers FROM score WHERE idLeaderboard = ? AND userName = ?");
    $stmt->bind_param("is", $idLeaderboard, $userName);
    if ($stmt->execute()) {
        //file_put_contents("log.txt", "SECOND QUERRY WORKED", FILE_APPEND);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentScore = $row ? $row['correctAnswers'] : 0;

    //file_put_contents("log.txt", "BEFORE IF\n", FILE_APPEND);
    // If the new score is higher, insert or update it in the database.
    if ($data['score'] >= $currentScore) {
        //file_put_contents("log.txt", $data['score'], FILE_APPEND);
        //file_put_contents("log.txt", $currentScore, FILE_APPEND);
        if (!empty($row)) { // If there's already a record for this user and leaderboard, update it.
            $stmt = $db->prepare("UPDATE score SET correctAnswers = ?, questionAmount = ? WHERE idLeaderboard = ? AND userName = ?");
            $stmt->bind_param("iiis", $data['score'], $totalQuestions, $idLeaderboard, $userName);
            //file_put_contents("log.txt", "ALREADY A RECORD\n", FILE_APPEND);
        } else { // Else, insert a new record.
            $query = "INSERT INTO score (correctAnswers, questionAmount, time, idLeaderboard, userName) VALUES (" . $data['score'] . ", " . $totalQuestions . ", '00:00:00', " . $idLeaderboard . ", '" . $userName . "')";

            if ($db->query($query) === TRUE) {
                file_put_contents("log.txt", "Insert successful\n", FILE_APPEND);
            } else {
                file_put_contents("log.txt", "Error: " . $db->error . "\n", FILE_APPEND);
            }

        }

        
        if($stmt->execute()) {
            //file_put_contents("log.txt", "QUERRY SUCCESS\n", FILE_APPEND);
            $operationSuccess = true; // Query was successful
        } else {
            //file_put_contents("log.txt", "QUERRY FAILED\n", FILE_APPEND);
            $operationSuccess = false; // Query failed
            $response['errorMessage'] = $stmt->error; // Store the error message
        }
    
        if ($db->affected_rows === 0) {
            $operationSuccess = false; // No rows were affected.
            $response['errorMessage'] = 'No rows were affected. The data might already exist or failed to store.';
        }
    }
}

if ($response['success'] && $operationSuccess) {
    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Data missing or storage failed', 'error' => $response['errorMessage'] ?? 'Unknown error']);
}
?>