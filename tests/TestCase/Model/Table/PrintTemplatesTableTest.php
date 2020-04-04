<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrintTemplatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrintTemplatesTable Test Case
 */
class PrintTemplatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrintTemplatesTable
     */
    protected $PrintTemplates;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PrintTemplates',
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
        $config = TableRegistry::getTableLocator()->exists('PrintTemplates') ? [] : ['className' => PrintTemplatesTable::class];
        $this->PrintTemplates = TableRegistry::getTableLocator()->get('PrintTemplates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PrintTemplates);

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
