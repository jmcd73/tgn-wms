<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartonsTable;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartonsTable Test Case
 */
class CartonsTableTest extends TestCase
{
    use LocatorAwareTrait;
    /**
     * Test subject
     *
     * @var \App\Model\Table\CartonsTable
     */
    protected $Cartons;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cartons',
        'app.Pallets',
        'app.Items',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cartons') ? [] : ['className' => CartonsTable::class];
        $this->Cartons = $this->getTableLocator()->get('Cartons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cartons);

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
