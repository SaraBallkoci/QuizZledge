<?php declare(strict_types=1);

require_once('QuizDB.php');

header('Content-Type: application/json');

define('DEFAULT_QUIZ_ID', '');
define('QUIZ_ID', 'quizId');

$quizDB = new QuizDB();

$quizId = isset($_GET[QUIZ_ID]) ? $_GET[QUIZ_ID] : DEFAULT_QUIZ_ID;

$questions = $quizDB->fetchQuestions($quizId);

echo json_encode($questions);

?>