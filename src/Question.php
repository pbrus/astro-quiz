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

    public function __construct($allQuestions)
    {
        $j = 0;
        $this->question = $allQuestions[$j++];
        for ($i = 1; $i <= self::NUMANS; $i++) {
            $this->possibleAnswers["key".(string)$i] = $allQuestions[$j++];
        }
        $this->correctAnswer = $allQuestions[$j++];
        $this->points = $allQuestions[$j++];
        $this->image = $allQuestions[$j++];
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
            if (!in_array($number, $permutationIndices)) break;
        }

        return $number;
    }

    public function saveUserAnswer($userAns)
    {
        $this->userAnswer = $userAns;
    }

    public function evaluate()
    {
        $points = 0;

        if ($this->userAnswer == $this->correctAnswer) {
            $points = $this->points;
        }

        return $points;
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
