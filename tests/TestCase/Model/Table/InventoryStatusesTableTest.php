<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoryStatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InventoryStatusesTable Test Case
 */
class InventoryStatusesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InventoryStatusesTable
     */
    protected $InventoryStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.InventoryStatuses',
        'app.Labels',
        'app.Pallets',
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
        $config = TableRegistry::getTableLocator()->exists('InventoryStatuses') ? [] : ['className' => InventoryStatusesTable::class];
        $this->InventoryStatuses = TableRegistry::getTableLocator()->get('InventoryStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->InventoryStatuses);

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
