<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ToggenHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ToggenHelper Test Case
 */
class ToggenHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\ToggenHelper
     */
    protected $Toggen;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Toggen = new ToggenHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Toggen);

        parent::tearDown();
    }
}
