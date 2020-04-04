<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShipmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShipmentsTable Test Case
 */
class ShipmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShipmentsTable
     */
    protected $Shipments;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Shipments',
        'app.Operators',
        'app.TruckRegistrations',
        'app.ProductTypes',
        'app.Labels',
        'app.Pallets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Shipments') ? [] : ['className' => ShipmentsTable::class];
        $this->Shipments = TableRegistry::getTableLocator()->get('Shipments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Shipments);

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
