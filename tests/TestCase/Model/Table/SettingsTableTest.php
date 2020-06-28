<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\ORM\Entity;

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

    public function testFindSettingByName() {

        $query = $this->Settings->find('all')->where([ 'name' => 'EMAIL_PALLET_LABEL_TO'])->first();
        $this->assertInstanceOf('Cake\Orm\Entity', $query);

       // $result = $query->enableHydration(false)->toArray();

      
    }

    public function testFindThree(): void
    {
        $query = $this->Settings->find('all', ['limit' => 3]);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();
        
        $expected = [
            [
                'id' => 3,
              'setting_in_comment' =>    false,
                'name' =>    'SSCC_REF',
                'setting' =>    '427',
                'comment' =>    'SSCC Reference number ',
            ],
            [
                'id' => 4,
              'setting_in_comment' =>    false,
                'name' =>    'SSCC_EXTENSION_DIGIT',
                'setting' =>    '1',
                'comment' =>    'SSCC extension digit',

            ],
            [
                'id' => 5,
              'setting_in_comment' =>    false,
                'name' =>    'SSCC_COMPANY_PREFIX',
                'setting' =>    '93529380',
                'comment' =>    'Added a bogus prefix',

            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
