<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShiftsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShiftsTable Test Case
 */
class ShiftsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShiftsTable
     */
    protected $Shifts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Shifts',
        'app.ProductTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Shifts') ? [] : ['className' => ShiftsTable::class];
        $this->Shifts = TableRegistry::getTableLocator()->get('Shifts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Shifts);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
