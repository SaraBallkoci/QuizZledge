<?php declare(strict_types=1);

class Answer {

    private string $content;
    private bool $isCorrect;

    public function __construct(string $content, bool $isCorrect) {
        $this->content = $content;
        $this->isCorrect = $isCorrect;
    }

    public function content(): string {
        return $this->content;
    }

    public function isCorrect(): bool {
        return $this->isCorrect;
    }
}