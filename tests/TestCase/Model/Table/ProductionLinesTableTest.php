<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductionLinesTable;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductionLinesTable Test Case
 */
class ProductionLinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductionLinesTable
     */
    protected $ProductionLines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProductionLines',
        'app.Printers',
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
        $config = $this->getTableLocator()->exists('ProductionLines') ? [] : ['className' => ProductionLinesTable::class];
        $this->ProductionLines = $this->getTableLocator()->get('ProductionLines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProductionLines);

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
