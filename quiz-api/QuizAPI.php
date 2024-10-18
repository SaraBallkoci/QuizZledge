<?php declare(strict_types=1);

class QuizAPI {

    private const BASE_URL = "https://opentdb.com/api.php";

    private const AMOUNT = 'amount';
    private const CATEGORY = 'category';
    private const DIFFICULTY = 'difficulty';
    private const TYPE = 'type';

    private const RESPONSE_CODE = 'response_code';
    private const ERROR = 'error';
    private const RESULTS = 'results';
    
    private const QUESTION = 'question';
    private const ANSWERS = 'answers';
    private const CORRECT_ANSWER = 'correct_answer';
    private const INCORRECT_ANSWERS = 'incorrect_answers';
    private const ANSWER = 'answer';
    private const IS_CORRECT = 'isCorrect';

    public function __construct() {

    }

    public function fetchQuestions(string $amount, string $category, string $difficulty, string $type): mixed {
        $apiURL = $this->buildApiURL($amount, $category, $difficulty, $type);

        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
            exit;
        }
        
        curl_close($ch);

        $data = json_decode($response, true);

        if ($data[self::RESPONSE_CODE] != 0) {
            echo json_encode([self::ERROR => 'API error: ' . $data[self::ERROR]]);
            exit;
        }

        return $this->getQuestions($data);
    }

    private function buildApiURL(string $amount, string $category, string $difficulty, string $type): string {
        $querySegments = array();

        if (!empty($amount))
            $querySegments[] = self::AMOUNT . "=" . $amount;

        if (!empty($category))
            $querySegments[] = self::CATEGORY . "=" . $category;

        if (!empty($difficulty))
            $querySegments[] = self::DIFFICULTY . "=" . $difficulty;

        if (!empty($type))
            $querySegments[] = self::TYPE . "=" . $type;
        
        if (count($querySegments) == 0)
            return '';

        $joinedQuerySegments = "?" . join("&", $querySegments);

        $apiURL = self::BASE_URL . $joinedQuerySegments;

        return $apiURL;
    }

    private function getQuestions(mixed $data): array {
        $questions = array();

        foreach ($data[self::RESULTS] as $questionData) {
            $question = $questionData[self::QUESTION];
            $answers = $this->createAnswerArray($questionData[self::CORRECT_ANSWER], $questionData[self::INCORRECT_ANSWERS]);

            $questions[] = array(
                self::QUESTION => $question,
                self::ANSWERS => $answers
            );
        }

        return $questions;
    }

    private function createAnswerArray(string $correctAnswer, array $incorrectAnswers): array {
        $answers = array();

        $answers[] = array(self::ANSWER => $correctAnswer, self::IS_CORRECT => true);

        foreach ($incorrectAnswers as $answer) {
            $answers[] = array(self::ANSWER => $answer, self::IS_CORRECT => false);
        }

        // Shuffle the answers so the correct answer is not always the first
        shuffle($answers);

        return $answers;
    }
}