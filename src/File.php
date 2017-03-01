<?php

namespace Brus;

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

class NoFileException extends \Exception
{
}

class NoFileAccessException extends \Exception
{
}
