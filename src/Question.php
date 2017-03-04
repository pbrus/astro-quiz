<?php

namespace AstroQuiz;

class Question
{
    private const NUMANS = 4;
    private $qst;
    private $ans = array();     // contains NUMANS elements
    private $usrAns;
    private $correct;
    private $points;
    private $image;

    public function __construct($arrQst)
    {
        $j = 0;
        $this->qst = $arrQst[$j++];
        for ($i = 1; $i <= self::NUMANS; $i++) {
            $this->ans["key".(string)$i] = $arrQst[$j++];
        }
        $this->correct = $arrQst[$j++];
        $this->points = $arrQst[$j++];
        $this->image = $arrQst[$j++];
    }

    public function get()
    {
        return $this->qst;
    }

    public function amountAnswers()
    {
        return self::NUMANS;
    }

    public function getAnswers()
    {
        return $this->ans;
    }

    public function getRandAnswers()
    {
        $perIdx = array();      // permutation indices
        $rand = array();

        for ($i = 0; $i < self::NUMANS; $i++) {
            $val = $this->randExclusion($perIdx);
            $perIdx[$i] = $val;
            $rand["key".(string)$val] = $this->ans["key".(string)$val];
        }

        return $rand;
    }

    private function randExclusion($exArr)
    {
        while (True) {
            $num = rand(1,self::NUMANS);
            if (!in_array($num, $exArr)) break;
        }

        return $num;
    }

    public function saveUserAnswer($userAns)
    {
        $this->usrAns = $userAns;
    }

    public function evaluate()
    {
        $points = 0;

        if ($this->usrAns == $this->correct) {
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
