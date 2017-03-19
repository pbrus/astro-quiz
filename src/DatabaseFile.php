<?php

namespace AstroQuiz;
use Brus\File;

class DatabaseFile extends File
{
    private const SEPARATOR = ":";
    private $rowInputDatabase = array();
    private $rowOutputDatabase = array();

    public function saveUserData($user, $allQuestions)
    {
        $amountQuestions = count($allQuestions);
        $score = 0;

        $elementsForInputRow[0] = $user->name();
        for ($i = 0; $i < $amountQuestions; $i++) {
            $points = $allQuestions[$i]->evaluate();
            $elementsForInputRow[$i + 1] = $points;
            $score += $points;
        }
        array_push($elementsForInputRow, $score);

        $this->rowInputDatabase = implode(self::SEPARATOR, $elementsForInputRow);
        $this->saveDataToFile();
    }

    private function saveDataToFile()
    {
        $fileDescriptor = $this->descriptor();
        flock($fileDescriptor, LOCK_EX);
        if (@fwrite($fileDescriptor, $this->rowInputDatabase . "\n") === FALSE) {
            throw new FailureDataSavingException("Cannot save data to " . $this->name() . " file");
        }
        flock($fileDescriptor, LOCK_UN);
    }
}

class FailureDataSavingException extends \Exception
{
}
