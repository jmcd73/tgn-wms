<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrintersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrintersTable Test Case
 */
class PrintersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrintersTable
     */
    protected $Printers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Printers',
        'app.Labels',
        'app.Pallets',
        'app.ProductionLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Printers') ? [] : ['className' => PrintersTable::class];
        $this->Printers = TableRegistry::getTableLocator()->get('Printers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Printers);

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
