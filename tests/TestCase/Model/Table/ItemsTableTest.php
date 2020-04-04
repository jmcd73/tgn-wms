<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemsTable Test Case
 */
class ItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemsTable
     */
    protected $Items;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Items',
        'app.PackSizes',
        'app.ProductTypes',
        'app.PrintTemplates',
        'app.Cartons',
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
        $config = TableRegistry::getTableLocator()->exists('Items') ? [] : ['className' => ItemsTable::class];
        $this->Items = TableRegistry::getTableLocator()->get('Items', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Items);

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
