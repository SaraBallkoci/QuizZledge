<?php declare(strict_types=1);

class CheckQuizId {

    private const PRIVATE_QUIZ_ID = "privateQuizId";

    private const SERVER = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DATABASE = "quizzledge";

    private mysqli $database;
    private string $privateQuizId;

    public function __construct() {
        error_reporting(E_ALL);

        $this->privateQuizId = "";
        $this->database = new mysqli(self::SERVER, self::USERNAME, self::PASSWORD, self::DATABASE);

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

    private function processReceivedData(): void {
        if (isset($_POST[self::PRIVATE_QUIZ_ID])) {
            $this->privateQuizId = $_POST[self::PRIVATE_QUIZ_ID];
        }
    }

    private function checkUponPrivateQuizId(): void {
        $privateQuizId = $this->privateQuizId;
        
        $isValidPrivateQuizId = $this->containsQuizWithPrivateQuizId($privateQuizId);
        
        $redirectLocation = "";

        if ($isValidPrivateQuizId) {
            $redirectLocation = "../quiz/quiz.php?privateQuizId=" . $privateQuizId;
        } else {
            $redirectLocation = "quiz-room.php";
        }

        header("HTTP/1.1 303 See Other");
        header("Location: " . $redirectLocation);
        die();
    }

    private function containsQuizWithPrivateQuizId(string $privateQuizId): bool {
        $data = array();

		$stmt = $this->database->prepare("SELECT pq.idQuiz FROM private_quiz pq WHERE pq.idQuiz = ? LIMIT 1");

        $stmt->bind_param("s", $privateQuizId);
        $stmt->execute();
        $resultSet = $stmt->get_result();

        $isNotEmpty = $resultSet->num_rows !== 0;

        $resultSet->free();
        $stmt->close();

        return $isNotEmpty;
    }

    public static function main():void
    {
        try {
            $page = new CheckQuizId();
            $page->processReceivedData();
            $page->checkUponPrivateQuizId();
        } catch (Exception $e) {
            header("Content-Type: text/html; charset=UTF-8");
            $e->getMessage();
        }
    }
}

CheckQuizId::main();