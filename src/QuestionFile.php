<?php

namespace AstroQuiz;
use Brus\File;

class QuestionFile extends File
{
    private const LINESPERQUESTION = 8;
    private $amountQuestions = -1;

    public function properSize()
    {
        $isProperSizeStatus = TRUE;
        $howManyLines = $this->size();

        if ($howManyLines % self::LINESPERQUESTION) {
            $isProperSizeStatus = FALSE;
            $this->error = "Wrong structure in " . $this->name() . " file";
        } else if ($this->amountQuestions == -1) {
            $this->amountQuestions = $howManyLines / self::LINESPERQUESTION;
        }

        return $isProperSizeStatus;
    }

    public function amountQuestions()
    {
        $n = $this->amountQuestions;

        if ($n == -1) {
            if ($this->properSize()) {
                $n = $this->amountQuestions;
            }
        }

        return $n;
    }

    public function readQuestion()
    {
        $question = array();
        $fileDescriptor = $this->descriptor();
        flock($fileDescriptor, LOCK_SH);

        for ($i = 0; $i < self::LINESPERQUESTION; $i++) {
            $question[$i] = fgets($fileDescriptor);
        }

        flock($fileDescriptor, LOCK_UN);

        return $question;
    }
}
