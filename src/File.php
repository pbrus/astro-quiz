<?php

namespace Brus;

class File
{
    private $fileName;
    private $filePointer;
    protected $error;

    public function __construct($name, $mode = "r")
    {
        $this->fileName = $name;
        $this->readable($mode);
    }

    private function readable($mode)
    {
        if (file_exists($this->fileName) === FALSE) {
            throw new NoFileException("Cannot find " . $this->fileName . " file");
        } else if (($this->filePointer = @fopen($this->fileName, $mode)) === FALSE) {
            throw new NoFileAccessException("Cannot read " . $this->fileName . " file");
        }
    }

    public function __destruct()
    {
        if ($this->filePointer != NULL) {
            fclose($this->filePointer);
        }
    }

    public function error()
    {
        return $this->error;
    }

    public function name()
    {
        return $this->fileName;
    }

    protected function descriptor()
    {
        return $this->filePointer;
    }

    public function size()
    {
        $lines = 0;
        $fileDescriptor = $this->descriptor();
        flock($fileDescriptor, LOCK_SH);

        while (fgets($fileDescriptor)) {
            $lines++;
        }

        rewind($fileDescriptor);
        flock($fileDescriptor, LOCK_UN);

        return $lines;
    }

    public function isEmpty()
    {
        $status = FALSE;

        if (filesize($this->fileName) == 0) {
            $status = TRUE;
        }

        return $status;
    }
}

class NoFileException extends \Exception
{
}

class NoFileAccessException extends \Exception
{
}
