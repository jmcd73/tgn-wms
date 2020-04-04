<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PalletsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PalletsTable Test Case
 */
class PalletsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PalletsTable
     */
    protected $Pallets;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Pallets',
        'app.ProductionLines',
        'app.Items',
        'app.Printers',
        'app.Locations',
        'app.Shipments',
        'app.InventoryStatuses',
        'app.ProductTypes',
        'app.Cartons',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Pallets') ? [] : ['className' => PalletsTable::class];
        $this->Pallets = TableRegistry::getTableLocator()->get('Pallets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Pallets);

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
