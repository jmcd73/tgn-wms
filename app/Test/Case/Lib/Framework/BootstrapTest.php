<?php

App::uses('TestFrameworkTrait', 'Test/Case/Lib/Framework');

class BootstrapTests
{
    use TestFrameworkTrait;

    public function __construct()
    {
    }

    public function startTests()
    {
        $this->cleanUpOutputDir();
    }
}

$ret = (new BootstrapTests())->startTests();