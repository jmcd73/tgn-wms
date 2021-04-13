<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\TgnUtilsBehavior;
use Cake\Log\LogTrait;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\TgnUtilsBehavior Test Case
 */
class TgnUtilsBehaviorTest extends TestCase
{

    use LocatorAwareTrait, LogTrait;
    
    protected $fixtures = ['app.Settings', 'app.ProductTypes', 'app.Pallets'];

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

        $table = $this->getTableLocator()->get($this->table);

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
    public function testSsccGetReferenceNumber(): void
    {
        $reference = $this->TgnUtilsBehavior->getReferenceNumber('SSCC_REF','93529380');
        $expected = '302';

        $this->assertEquals($expected, $reference);
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
        $id = 3;
        $productTypesTable = $this->TgnUtilsBehavior->getSettingsTable('ProductTypes');

        $nextReference = $productTypesTable->get($id);

        $nsn0 = $nextReference->next_serial_number;

        $actual = $this->TgnUtilsBehavior->createPalletRef($id, $nsn0);

        $this->assertEquals('A00000149', $actual);
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

    public function testGetSetting()
    {
        $expected = 'James McDonald <james@toggen.com.au>' . "\n";
        $expected .= 'Lisa McDonald <lisa@toggen.com.au>';

        $setting = $this->TgnUtilsBehavior->getSetting('EMAIL_PALLET_LABEL_TO');
        tog("test", $setting);
        $this->assertEquals($expected, $setting, "Should return a string");
    }

    public function testGetSettingTraitSetting()
    {
        $expected = 'files/templates-glabels-3';

        $setting = $this->TgnUtilsBehavior->getSetting('TEMPLATE_ROOT');

        $this->assertEquals($expected, $setting, "Should return " . $expected);
    }


    /**
     * Test addressParse method
     *
     * @return void
     */
    public function testAddressParse(): void
    {

        $input = "James McDonald <james@toggen.com.au>\nLisa McDonald <lisa@toggen.com.au>";
    

        $expected = [
            'james@toggen.com.au' => 'James McDonald' ,
            'lisa@toggen.com.au' => 'Lisa McDonald'
        ];
        
        
        $actual = $this->TgnUtilsBehavior->addressParse($input);

        $this->assertEquals($expected, $actual);

    }


       /**
     * Test sendLabel method
     *
     * @return void
     */
    public function testEmptyEmail(): void
    {
        $input = '# bogus no email address' ;
        $input .= 'anothernotanemail';
        $expected = [];

        $actual = $this->TgnUtilsBehavior->addressParse($input);

        $this->assertEquals($expected, $actual);

    }
}