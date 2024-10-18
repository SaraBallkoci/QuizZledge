<?php declare(strict_types=1);

require_once 'Answer.php';

class Question {

    private string $questionText;
    private array $answers;

    public function __construct(string $questionText, array $answers) {
        $this->questionText = $questionText;
        $this->answers = $answers;
    }

    public function questionText(): string {
        return $this->questionText;
    }

    public function answers(): array {
        return $this->answers;
    }
}