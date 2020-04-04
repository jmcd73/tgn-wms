<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HelpTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HelpTable Test Case
 */
class HelpTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HelpTable
     */
    protected $Help;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Help',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Help') ? [] : ['className' => HelpTable::class];
        $this->Help = TableRegistry::getTableLocator()->get('Help', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Help);

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
