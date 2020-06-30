<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\TgnTestComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\TgnTestComponent Test Case
 */
class TgnTestComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\TgnTestComponent
     */
    protected $TgnTest;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->markTestIncomplete();
        $registry = new ComponentRegistry();
        $this->TgnTest = new TgnTestComponent($registry);
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
        unset($this->TgnTest);

        parent::tearDown();
    }
}
