<?php

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

class File
{
    private $filename;
    private $ptr;
    protected $error;

    public function __construct($str)
    {
        $this->filename = $str;
        $this->readable();
    }

    private function readable()
    {
        if (!file_exists($this->filename)) {
            throw new NoFileException("Cannot find " . $this->filename . " file");
        } else if (!$this->ptr = @fopen($this->filename, 'r')) {
            throw new NoFileAccessException("Cannot read " . $this->filename . " file");
        }
    }

    public function __destruct()
    {
        if ($this->ptr != NULL) {
            fclose($this->ptr);
        }
    }

    public function error()
    {
        return $this->error;
    }

    public function name()
    {
        return $this->filename;
    }

    protected function descriptor()
    {
        return $this->ptr;
    }

    public function size()
    {
        $lines = 0;
        $fd = $this->descriptor();

        while (fgets($fd)) {
            $lines++;
        }

        rewind($fd);

        return $lines;
    }
}

class NoFileException extends Exception
{
}

class NoFileAccessException extends Exception
{
}

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

class User
{
    private const MINLEN = 3;
    private $name;
    private $points = 0;
    private $error;

    public function __construct($username)
    {
        $this->name = $username;
    }

    public function validName()
    {
        $state = True;

        if (empty($this->name)) {
            $state = False;
            $this->error = "Please, fill the form out";
        } else if (strlen($this->name) < self::MINLEN) {
            $state = False;
            $this->error = "The name must contain at least " . self::MINLEN . " letters";
        } else if (preg_match('/[^a-zA-Z\s_]/', $this->name)) {
            $state = False;
            $this->error = "Please, use only letters, spaces or underscores";
        }

        return $state;
    }

    public function error()
    {
        return $this->error;
    }

    public function name()
    {
        return $this->name;
    }
}
