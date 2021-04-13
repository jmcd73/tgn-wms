<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrintLogTable;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrintLogTable Test Case
 */
class PrintLogTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrintLogTable
     */
    protected $PrintLog;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PrintLog',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PrintLog') ? [] : ['className' => PrintLogTable::class];
        $this->PrintLog = $this->getTableLocator()->get('PrintLog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PrintLog);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
