<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PackSizesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PackSizesTable Test Case
 */
class PackSizesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PackSizesTable
     */
    protected $PackSizes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PackSizes',
        'app.Items',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PackSizes') ? [] : ['className' => PackSizesTable::class];
        $this->PackSizes = TableRegistry::getTableLocator()->get('PackSizes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PackSizes);

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
