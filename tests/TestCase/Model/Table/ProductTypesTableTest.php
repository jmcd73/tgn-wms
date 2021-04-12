<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductTypesTable;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductTypesTable Test Case
 */
class ProductTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductTypesTable
     */
    protected $ProductTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProductTypes',
        'app.InventoryStatuses',
        'app.Locations',
        'app.Items',
        'app.Labels',
        'app.Pallets',
        'app.ProductionLines',
        'app.Shifts',
        'app.Shipments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductTypes') ? [] : ['className' => ProductTypesTable::class];
        $this->ProductTypes = $this->getTableLocator()->get('ProductTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProductTypes);

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
