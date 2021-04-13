<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoryStatusesTable;
use Cake\ORM\Locator\LocatorAwareTrait;
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
        $config = $this->getTableLocator()->exists('InventoryStatuses') ? [] : ['className' => InventoryStatusesTable::class];
        $this->InventoryStatuses = $this->getTableLocator()->get('InventoryStatuses', $config);
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
