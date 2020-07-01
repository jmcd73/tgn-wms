<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CtrlComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CtrlComponent Test Case
 */
class CtrlComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\CtrlComponent
     */
    protected $Ctrl;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Ctrl = new CtrlComponent($registry);
        $this->markTestIncomplete();
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
        unset($this->Ctrl);

        parent::tearDown();
    }
}
