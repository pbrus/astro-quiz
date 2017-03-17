<?php

namespace AstroQuiz;
use Brus\File;

class ConfigureFile extends File
{
    private $parameters = array(
        'password' => null,
        'question-file' => null,
        'width-image' => null
    );

    public function getPassword()
    {
        if (isset($this->parameters['password']) === FALSE) {
            $this->loadConfigureParameters();
        }

        return $this->parameters['password'];
    }

    public function getFilenameWithQuestions()
    {
        if (isset($this->parameters['question-file']) === FALSE) {
            $this->loadConfigureParameters();
        }

        return $this->parameters['question-file'];
    }

    public function getImagesWidth()
    {
        if (isset($this->parameters['width-image']) === FALSE) {
            $this->loadConfigureParameters();
        }

        return $this->parameters['width-image'];
    }

    private function loadConfigureParameters()
    {
        $fileDescriptor = $this->descriptor();
        $size = $this->size();
        flock($fileDescriptor, LOCK_SH);

        while ($size--) {
            $line = fgets($fileDescriptor);
            foreach ($this->parameters as $key => $value) {
                $modkey = $key . ":";
                $regex = "/^" . $modkey . "/";
                if (preg_match($regex, $line)) {
                    $this->parameters[$key] = trim(str_replace($modkey, "", $line));
                }
            }
        }

        rewind($fileDescriptor);
        flock($fileDescriptor, LOCK_UN);
        $this->validLoadingConfigureParameters();
    }

    private function validLoadingConfigureParameters()
    {
        foreach ($this->parameters as $key => $value) {
            if ((isset($value) === FALSE) || $value == "") {
                throw new WrongConfiguration("Incorrect structure in " . $this->name() . " file");
            }
        }
    }
}

class WrongConfiguration extends \Exception
{
}
