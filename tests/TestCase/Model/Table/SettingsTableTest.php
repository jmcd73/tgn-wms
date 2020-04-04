<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SettingsTable Test Case
 */
class SettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SettingsTable
     */
    protected $Settings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Settings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Settings') ? [] : ['className' => SettingsTable::class];
        $this->Settings = TableRegistry::getTableLocator()->get('Settings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Settings);

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
