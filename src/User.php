<?php

namespace AstroQuiz;

class User
{
    private const MINLEN = 3;
    private const MAXLEN = 25;
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
        } else if (strlen($this->name) > self::MAXLEN) {
            $state = False;
            $this->error = "The name cannot contain more than " . self::MAXLEN . " letters";
        } else if (preg_match('/[^a-zA-Z\s_]/', $this->name)) {
            $state = False;
            $this->error = "Please, use only Latin letters, spaces or underscores";
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
