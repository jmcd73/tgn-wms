<?php

namespace App\Lib\PrintLabels;

class PrintResult
{
    public $command = '';
    public $stdout = '';
    public $stderr = '';
    public $returnValue = 0;

    public function __construct($cmd, $stdout, $stderr, $returnValue)
    {
        $this->command = $cmd;
        $this->stdout = $stdout;
        $this->stderr = $stderr;
        $this->returnValue = $returnValue;
    }
}