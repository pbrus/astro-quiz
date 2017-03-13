<?php

namespace Brus;

class File
{
    private $fileName;
    private $filePointer;
    protected $error;

    public function __construct($name)
    {
        $this->fileName = $name;
        $this->readable();
    }

    private function readable()
    {
        if (!file_exists($this->fileName)) {
            throw new NoFileException("Cannot find " . $this->fileName . " file");
        } else if (!$this->filePointer = @fopen($this->fileName, 'rw')) {
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
        $fd = $this->descriptor();
        flock($fd, LOCK_SH);

        while (fgets($fd)) {
            $lines++;
        }

        rewind($fd);
        flock($fd, LOCK_UN);

        return $lines;
    }
}

class NoFileException extends \Exception
{
}

class NoFileAccessException extends \Exception
{
}
