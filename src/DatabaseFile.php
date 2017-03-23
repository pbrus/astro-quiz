<?php

namespace AstroQuiz;
use Brus\File;

class DatabaseFile extends File
{
    private const SEPARATOR = ":";
    private $rowInputDatabase;
    private $database = NULL;
    private $amountUsers;
    private $amountQuestions;

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

    public function isNameDuplicated($userName)
    {
        $isNameDuplicatedStatus = FALSE;
        $fileDescriptor = $this->descriptor();
        $size = $this->size();
        flock($fileDescriptor, LOCK_SH);

        while ($size--) {
            $line = explode(self::SEPARATOR, fgets($fileDescriptor));
            $currentName = $line[0];
            if ($currentName == $userName) {
                $isNameDuplicatedStatus = TRUE;
                $this->error = "Name " . $currentName . " is already busy";
                break;
            }
        }

        rewind($fileDescriptor);
        flock($fileDescriptor, LOCK_UN);

        return $isNameDuplicatedStatus;
    }

    public function getDatabase()
    {
        if (isset($this->database) === FALSE) {
            $this->readDatabaseFile();
        }

        return $this->database;
    }

    private function readDatabaseFile()
    {
        $userIterator = 0;
        $fileDescriptor = $this->descriptor();
        flock($fileDescriptor, LOCK_EX);

        while ($userLineData = fgets($fileDescriptor)) {
            $this->database[$userIterator++] = explode(self::SEPARATOR, $userLineData);
        }

        rewind($fileDescriptor);
        flock($fileDescriptor, LOCK_UN);
        $this->countUsers();
        $this->countQuestions();
    }

    private function countUsers()
    {
        $this->amountUsers = count($this->database);
    }

    private function countQuestions()
    {
        if (empty($this->database)) {
            $countQuestions = 0;
        } else {
            $countQuestions = count($this->database[0]) - 2;
        }

        $this->amountQuestions = $countQuestions;
    }

    public function amountUsers()
    {
        if (isset($this->database) === FALSE) {
            $this->readDatabaseFile();
        }

        return $this->amountUsers;
    }

    public function amountQuestions()
    {
        if (isset($this->database) === FALSE) {
            $this->readDatabaseFile();
        }

        return $this->amountQuestions;
    }

    public function getDatabaseSortedByResults($mode = "ASC")
    {
        $sortedDatabase = $this->getDatabase();

        if ($mode == "ASC") {
            usort($sortedDatabase, function($firstElement, $secondElement) {
                return $firstElement[$this->amountQuestions + 1] <=> $secondElement[$this->amountQuestions + 1];
            });
        } else if ($mode == "DESC") {
            usort($sortedDatabase, function($firstElement, $secondElement) {
                return $secondElement[$this->amountQuestions + 1] <=> $firstElement[$this->amountQuestions + 1];
            });
        }

        return $sortedDatabase;
    }
}

class FailureDataSavingException extends \Exception
{
}
