<?php

namespace AstroQuiz;
use Brus\File;

class QuestionFile extends File
{
    private const NUMLINES = 8;      // lines per question
    private $numQuests = -1;

    public function properSize()
    {
        $state = True;
        $lines = $this->size();

        if ($lines % self::NUMLINES) {
            $state = False;
            $this->error = "Wrong structure in " . $this->name() . " file";
        } else if ($this->numQuests == -1) {
            $this->numQuests = $lines / self::NUMLINES;
        }

        return $state;
    }

    public function amountQuestions()
    {
        $n = $this->numQuests;

        if ($n == -1) {
            if ($this->properSize()) {
                $n = $this->numQuests;
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
