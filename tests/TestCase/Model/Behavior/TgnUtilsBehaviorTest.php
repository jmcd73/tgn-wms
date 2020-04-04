<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\TgnUtilsBehavior;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\TgnUtilsBehavior Test Case
 */
class TgnUtilsBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\TgnUtilsBehavior
     */
    protected $TgnUtilsBehavior;

    protected $table = 'Pallets';

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $table = TableRegistry::getTableLocator()->get($this->table);

        $this->TgnUtilsBehavior = new TgnUtilsBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TgnUtilsBehavior);

        parent::tearDown();
    }

    /**
     * Test getBatchNumbers method
     *
     * @return void
     */
    public function testGetBatchNumbers(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSettingsTable method
     *
     * @return void
     */
    public function testGetSettingsTable(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSetting method
     *
     * @return void
     */
    public function testGetSetting(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test generateSSCCWithCheckDigit method
     *
     * @return void
     */
    public function testGenerateSSCCWithCheckDigit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test generateSSCC method
     *
     * @return void
     */
    public function testGenerateSSCC(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test generateCheckDigit method
     *
     * @return void
     */
    public function testGenerateCheckDigit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getReferenceNumber method
     *
     * @return void
     */
    public function testGetReferenceNumber(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getCompanyPrefix method
     *
     * @return void
     */
    public function testGetCompanyPrefix(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createPalletRef method
     *
     * @return void
     */
    public function testCreatePalletRef(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getHelpPage method
     *
     * @return void
     */
    public function testGetHelpPage(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getDateTimeStamp method
     *
     * @return void
     */
    public function testGetDateTimeStamp(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test formatLabelDates method
     *
     * @return void
     */
    public function testFormatLabelDates(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createSuccessMessage method
     *
     * @return void
     */
    public function testCreateSuccessMessage(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test formatYymmdd method
     *
     * @return void
     */
    public function testFormatYymmdd(): void
    {
        $testDate = '1973-01-31';
        $expectedDate = '730131';

        $returnedDate = $this->TgnUtilsBehavior->formatYymmdd($testDate, 'ymd');

        $this->assertTextEquals($expectedDate, $returnedDate);
    }

    public function testArrayToMysqlDate()
    {
        $testDate = '1973-01-31';
        $expectedDate = '730131';

        $returnedDate = $this->TgnUtilsBehavior->formatYymmdd($testDate, 'ymd');

        $this->assertTextEquals($expectedDate, $returnedDate);

        // code...
    }

    /**
     * Test log method
     *
     * @return void
     */
    public function testLog(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}