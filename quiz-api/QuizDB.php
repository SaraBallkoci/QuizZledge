<?php declare(strict_types=1);

require_once 'constants.php';

class QuizDB {

    private const BASE_URL = "https://opentdb.com/api.php";
    
    private const QUESTION = 'question';
    private const ANSWERS = 'answers';
    private const CORRECT_ANSWER = 'correct_answer';
    private const INCORRECT_ANSWERS = 'incorrect_answers';
    private const ANSWER = 'answer';
    private const IS_CORRECT = 'isCorrect';

    private mysqli $database;

    public function __construct() {
        error_reporting(E_ALL);
        $this->database = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

        // Check connection
        if ($this->database->connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
        }

        // set charset to UTF8!!
        if (!$this->database->set_charset("utf8")) {
            throw new Exception($this->_database->error);
        }
    }  
    
    public function __destruct() {
        $this->database->close();
    }

    public function fetchQuestions(string $privateQuizId): mixed {
        if (empty($privateQuizId))
            return array();

        $questions = $this->getData($privateQuizId);

        return $questions;
    }

    private function getData(string $privateQuizId): array {
        $data = array();

		$stmt = $this->database->prepare("
            SELECT 
                q.question,
                a.answer,
                CASE 
                    WHEN ca.idAns IS NOT NULL AND ca.idQuestion IS NOT NULL THEN true
                    ELSE false
                END AS isCorrect
            FROM question q 
            JOIN answer a ON q.idQuestion = a.idQuestion 
            LEFT OUTER JOIN correct_answer ca ON ca.idQuestion = q.idQuestion AND ca.idAns = a.idAns
            WHERE q.idQuiz = ?"
        );

        $stmt->bind_param("s", $privateQuizId);
        $stmt->execute();
        $resultSet = $stmt->get_result();

        $tempData = array();

        while($row = $resultSet->fetch_assoc()) {
            $question = $row[self::QUESTION];
            $answer = $row[self::ANSWER];
            $isCorrect = $row[self::IS_CORRECT];

            $tempData[$question][] = array(
                self::ANSWER => $answer,
                self::IS_CORRECT => $isCorrect
            );
        }

        foreach ($tempData as $question => $answers) {
            // Shuffle the answers so the correct answer is not always the first
            shuffle($answers);

            $data[] = array(
                self::QUESTION => $question,
                self::ANSWERS => $answers
            );
        }

        $resultSet->free();
        $stmt->close();

        return $data;
    }
}