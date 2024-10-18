<?php declare(strict_types=1);

require_once('QuizAPI.php');

header('Content-Type: application/json');

// http://localhost/DVA231-Group-2/quiz-api/quiz-api.php?amount=10&category=9&difficulty=easy&type=multiple

define('AMOUNT', 'amount');
define('CATEGORY', 'category');
define('DIFFICULTY', 'difficulty');
define('TYPE', 'type');

define('DEFAULT_AMOUNT', '10');
define('DEFAULT_CATEGORY', '');
define('DEFAULT_DIFFICULTY', '');
define('DEFAULT_TYPE', '');

$quizAPI = new QuizAPI();

$amount = isset($_GET[AMOUNT]) ? $_GET[AMOUNT] : DEFAULT_AMOUNT;
$category = isset($_GET[CATEGORY]) ? $_GET[CATEGORY] : DEFAULT_CATEGORY;
$difficulty = isset($_GET[DIFFICULTY]) ? $_GET[DIFFICULTY] : DEFAULT_DIFFICULTY;
$type = isset($_GET[TYPE]) ? $_GET[TYPE] : DEFAULT_TYPE;

$questions = $quizAPI->fetchQuestions($amount, $category, $difficulty, $type);

echo json_encode($questions);

?>