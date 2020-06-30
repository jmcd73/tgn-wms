<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

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
        $this->markTestIncomplete();
        parent::setUp();
        $view = new View();
       
    }

    public function testWouldBeGood()
    {
        $this->markTestIncomplete();
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
