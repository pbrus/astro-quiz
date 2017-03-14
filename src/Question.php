<?php

namespace AstroQuiz;

class Question
{
    private const NUMANS = 4;
    private $question;
    private $possibleAnswers = array();     // contains NUMANS elements
    private $userAnswer;
    private $correctAnswer;
    private $points;
    private $image;

    public function __construct($questionData)
    {
        $j = 0;
        $this->question = $questionData[$j++];
        for ($i = 1; $i <= self::NUMANS; $i++) {
            $this->possibleAnswers["key".(string)$i] = $questionData[$j++];
        }
        $this->correctAnswer = trim("key".(string)$questionData[$j++]);
        $this->points = (float)$questionData[$j++];
        $this->image = trim($questionData[$j++]);
    }

    public function get()
    {
        return $this->question;
    }

    public function amountAnswers()
    {
        return self::NUMANS;
    }

    public function getAnswers()
    {
        return $this->possibleAnswers;
    }

    public function getRandAnswers()
    {
        $permutationIndices = array();
        $randomOrderAnswers = array();

        for ($i = 0; $i < self::NUMANS; $i++) {
            $val = $this->randExclusion($permutationIndices);
            $permutationIndices[$i] = $val;
            $randomOrderAnswers["key".(string)$val] = $this->possibleAnswers["key".(string)$val];
        }

        return $randomOrderAnswers;
    }

    private function randExclusion($permutationIndices)
    {
        while (True) {
            $number = rand(1, self::NUMANS);
            if (!in_array($number, $permutationIndices)) {
                break;
            }
        }

        return $number;
    }

    public function saveUserAnswer($userAns)
    {
        $this->userAnswer = $userAns;
    }

    public function evaluate()
    {
        $score = 0;
        if ($this->userAnswer == $this->correctAnswer) {
            $score = $this->points;
        }

        return $score;
    }

    public function weight()
    {
        return $this->points;
    }

    public function image()
    {
        return $this->image;
    }
}
