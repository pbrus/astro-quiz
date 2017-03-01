<?php

namespace AstroQuiz;

class Question
{
    private const NUMANS = 4;
    private $qst;
    private $ans = array();     // contains NUMANS elements
    private $usrans;
    private $corr;
    private $pts;
    private $img;

    public function __construct($arrqst)
    {
        $j = 0;
        $this->qst = $arrqst[$j++];
        for ($i = 1; $i <= self::NUMANS; $i++) {
            $this->ans["key".(string)$i] = $arrqst[$j++];
        }
        $this->corr = $arrqst[$j++];
        $this->pts = $arrqst[$j++];
        $this->img = $arrqst[$j++];
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
        $peridx = array();      // permutation indices
        $rand = array();

        for ($i = 0; $i < self::NUMANS; $i++) {
            $val = $this->randExclusion($peridx);
            $peridx[$i] = $val;
            $rand["key".(string)$val] = $this->ans["key".(string)$val];
        }

        return $rand;
    }

    private function randExclusion($exarr)
    {
        while (True) {
            $num = rand(1,self::NUMANS);
            if (!in_array($num, $exarr)) break;
        }

        return $num;
    }

    public function saveUserAnswer($uans)
    {
        $this->usrans = $uans;
    }

    public function evaluate()
    {
        $points = 0;

        if ($this->usrans == $this->corr) {
            $points = $this->pts;
        }

        return $points;
    }

    public function image()
    {
        return $this->img;
    }
}
