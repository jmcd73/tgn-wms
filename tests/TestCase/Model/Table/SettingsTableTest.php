<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SettingsTable;
use Cake\ORM\Locator\LocatorAwareTrait;
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
        $config = $this->getTableLocator()->exists('Settings') ? [] : ['className' => SettingsTable::class];
        $this->Settings = $this->getTableLocator()->get('Settings', $config);
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

    public function testFindThreeSettings(): void
    {
        $query = $this->Settings->find('all', ['limit' => 3]);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();
        
        $expected = [
            [
                'id' => 3,
                'name' =>    'SSCC_REF',
                'setting' =>    '302',
                'comment' =>    'SSCC Reference number',
            ],
            [
                'id' => 4,
                'name' =>    'SSCC_EXTENSION_DIGIT',
                'setting' =>    '1',
                'comment' =>    'SSCC extension digit',

            ],
            [
                'id' => 5,
                'name' =>    'SSCC_COMPANY_PREFIX',
                'setting' =>    '99999999',
                'comment' =>    'Added a bogus prefix',

            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
