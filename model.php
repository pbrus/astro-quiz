<?php

class Question
{
	private $qst;
	private $ans = array();	// contains $num_ans elements
	private $num_ans = 4;
	private $usr_ans;
	private $corr;
	private $pts;
	private $img;
	
	function __construct(&$fd)
	{
		$this->qst = fgets($fd);
		for ($i = 0; $i < $this->num_ans; $i++)
			$this->ans[$i] = fgets($fd);
		$this->corr = fgets($fd);
		$this->pts = fgets($fd);
		$this->img = fgets($fd);
	}
}

class File
{
	protected $filename;
	protected $ptr;
	protected $error;
	
	function __construct($str)
	{
		$this->filename = $str;
	}
	
	function __destruct()
	{
		if ($this->ptr != NULL)
			fclose($this->ptr);
	}
	
	function readable()
	{
		$state = True;
		if (!$this->ptr = @fopen($this->filename, 'r'))
		{
			$this->error = "Cannot read " . $this->filename . " file";
			$state = False;
		}
				
		return $state;
	}
	
	function error()
	{
		return $this->error;
	}
}
