<?php

namespace AstroQuiz;

class User
{
    private const MINLEN = 3;
    private const MAXLEN = 25;
    private $name;
    private $points = 0;
    private $error;

    public function __construct($userName)
    {
        $this->name = $userName;
    }

    public function validName()
    {
        $isValidNameStatus = TRUE;

        if (empty($this->name)) {
            $isValidNameStatus = FALSE;
            $this->error = "Please, fill the form out";
        } else if (strlen($this->name) < self::MINLEN) {
            $isValidNameStatus = FALSE;
            $this->error = "The name must contain at least " . self::MINLEN . " letters";
        } else if (strlen($this->name) > self::MAXLEN) {
            $isValidNameStatus = FALSE;
            $this->error = "The name cannot contain more than " . self::MAXLEN . " letters";
        } else if (preg_match('/[^a-zA-Z\s_]/', $this->name)) {
            $isValidNameStatus = FALSE;
            $this->error = "Please, use only Latin letters, spaces or underscores";
        }

        return $isValidNameStatus;
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
