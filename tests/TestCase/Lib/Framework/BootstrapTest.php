<?php

namespace App\Test\TestCase\Lib\Framework;

use App\Test\TestCase\Lib\Framework\TestFrameworkTrait;

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