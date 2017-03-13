<?php

namespace AstroQuiz;
use Brus\File;

class QuestionFile extends File
{
    private const LINESPERQUESTION = 8;
    private $amountQuestions = -1;

    public function properSize()
    {
        $status = True;
        $howManyLines = $this->size();

        if ($howManyLines % self::LINESPERQUESTION) {
            $status = False;
            $this->error = "Wrong structure in " . $this->name() . " file";
        } else if ($this->amountQuestions == -1) {
            $this->amountQuestions = $howManyLines / self::LINESPERQUESTION;
        }

        return $status;
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
        $fd = $this->descriptor();
        flock($fd, LOCK_SH);

        for ($i = 0; $i < self::LINESPERQUESTION; $i++) {
            $question[$i] = fgets($fd);
        }

        flock($fd, LOCK_UN);

        return $question;
    }
}
