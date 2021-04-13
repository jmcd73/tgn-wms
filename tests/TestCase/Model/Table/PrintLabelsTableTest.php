<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrintLabelsTable;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrintLabelsTable Test Case
 */
class PrintLabelsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrintLabelsTable
     */
    protected $PrintLabels;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PrintLabels',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PrintLabels') ? [] : ['className' => PrintLabelsTable::class];
        $this->PrintLabels = $this->getTableLocator()->get('PrintLabels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PrintLabels);

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
