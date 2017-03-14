<?php

namespace AstroQuiz;
use Brus\File;

class DatabaseFile extends File
{
    private const SEPARATOR = "|";

    public function saveUserData()
    {
        $fileDescriptor = $this->descriptor($user, $allQuestions);
        flock($fileDescriptor, LOCK_EX);

        flock($fileDescriptor, LOCK_UN);
    }
}
