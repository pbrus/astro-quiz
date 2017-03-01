<?php

namespace AstroQuiz;
use Brus\File;

class QuestionFile extends File
{
    private const NUMLINES = 8;      // lines per question
    private $numquests = -1;

    public function properSize()
    {
        $state = True;
        $lines = $this->size();

        if ($lines % self::NUMLINES) {
            $state = False;
            $this->error = "Wrong structure in " . $this->name() . " file";
        } else if ($this->numquests == -1) {
            $this->numquests = $lines / self::NUMLINES;
        }

        return $state;
    }

    public function amountQuestions()
    {
        $n = $this->numquests;

        if ($n == -1) {
            if ($this->properSize()) {
                $n = $this->numquests;
            }
        }

        return $n;
    }

    public function readQuestion()
    {
        $question = array();

        for ($i = 0; $i < self::NUMLINES; $i++) {
            $question[$i] = fgets($this->descriptor());
        }

        return $question;
    }
}
