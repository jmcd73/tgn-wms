<?php
App::uses('PalletsController', 'Controller');
App::uses('TestFrameworkTrait', 'Test/Case/Lib/Framework');
require_once '/var/www/vendors/fzaninotto/faker/src/autoload.php';

/**
 * PalletsController Test Case
 */
class PalletsControllerTest extends ControllerTestCase
{
    use TestFrameworkTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        /*
        'app.pallet',
        'app.product_type',
        'app.location',
        'app.inventory_status',
        'app.production_line',
        'app.printer',
        'app.item',
        'app.pack_size',
        'app.print_template',
        'app.shift',
        'app.shipment',
        'app.user',
        'app.carton',
        'app.setting' */
    ];

    public function setUp()
    {
        parent::setUp();
        //  $this->PrintLabel = ClassRegistry::init('PrintLabel');
        // $this->Item = ClassRegistry::init('Item');
    }

    /**
     * testFormatReport method
     *
     * @return void
     */
    public function testFormatReport()
    {
        $this->markTestIncomplete('testFormatReport not implemented.');
    }

    /**
     * testShiftReport method
     *
     * @return void
     */
    public function testShiftReport()
    {
        $this->markTestIncomplete('testShiftReport not implemented.');
    }

    /**
     * testViewPartPalletsCartons method
     *
     * @return void
     */
    public function testViewPartPalletsCartons()
    {
        $this->markTestIncomplete('testViewPartPalletsCartons not implemented.');
    }

    /**
     * testBulkStatusRemove method
     *
     * @return void
     */
    public function testBulkStatusRemove()
    {
        $this->markTestIncomplete('testBulkStatusRemove not implemented.');
    }

    /**
     * testUpdateMinDaysLife method
     *
     * @return void
     */
    public function testUpdateMinDaysLife()
    {
        $this->markTestIncomplete('testUpdateMinDaysLife not implemented.');
    }

    /**
     * testBatchLookup method
     *
     * @return void
     */
    public function testBatchLookup()
    {
        $this->markTestIncomplete('testBatchLookup not implemented.');
    }

    /**
     * testPalletReferenceLookup method
     *
     * @return void
     */
    public function testPalletReferenceLookup()
    {
        $this->markTestIncomplete('testPalletReferenceLookup not implemented.');
    }

    /**
     * testItemLookup method
     *
     * @return void
     */
    public function testItemLookup()
    {
        $this->markTestIncomplete('testItemLookup not implemented.');
    }

    /**
     * testIndex method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('testIndex not implemented.');
    }

    /**
     * testLookupSearch method
     *
     * @return void
     */
    public function testLookupSearch()
    {
        $this->markTestIncomplete('testLookupSearch not implemented.');
    }

    /**
     * testLookup method
     *
     * @return void
     */
    public function testLookup()
    {
        $this->markTestIncomplete('testLookup not implemented.');
    }

    /**
     * testSscc method
     *
     * @return void
     */
    public function testSscc()
    {
        $this->markTestIncomplete('testSscc not implemented.');
    }

    /**
     * testSearch method
     *
     * @return void
     */
    public function testSearch()
    {
        $this->markTestIncomplete('testSearch not implemented.');
    }

    /**
     * testOnhand method
     *
     * @return void
     */
    public function testOnhand()
    {
        $this->markTestIncomplete('testOnhand not implemented.');
    }

    /**
     * testColumnsAndLevels method
     *
     * @return void
     */
    public function testColumnsAndLevels()
    {
        $this->markTestIncomplete('testColumnsAndLevels not implemented.');
    }

    /**
     * testPutAway method
     *
     * @return void
     */
    public function testPutAway()
    {
        $this->markTestIncomplete('testPutAway not implemented.');
    }

    /**
     * testUnassignedPallets method
     *
     * @return void
     */
    public function testUnassignedPallets()
    {
        $this->markTestIncomplete('testUnassignedPallets not implemented.');
    }

    /**
     * testSelectPalletPrintType method
     *
     * @return void
     */
    public function testSelectPalletPrintType()
    {
        $this->markTestIncomplete('testSelectPalletPrintType not implemented.');
    }

    /**
     * testPalletPrint method
     *
     * @return void
     */
    public function testPalletPrint()
    {
        $results = $this->testAction(
            '/Pallets/palletPrint/1',
            [
                'method' => 'get', 'results' => 'vars',
            ]
        );

        $faker = Faker\Factory::create('en_AU');
        $companyName = Configure::read('companyName');
        $item = $faker->randomElement(array_keys($this->vars['items']));
        $expectedItem = explode(' - ', $this->vars['items'][$item])[1];

        $formName = $faker->randomElement(['PalletLabelLeftPalletPrintForm', 'PalletLabelRightPalletPrintForm']);
        $productionLine = $faker->randomElement(array_keys($this->vars['productionLines']));
        $batch_nos = $faker->randomElement(array_keys($this->vars['batch_nos']));
        $referer = $this->vars['refer'];

        $data = [
            $formName => [
                'batch_no' => $batch_nos,
                'item' => $item,
                'production_line' => $productionLine,
                'formName' => $formName,
                'refer' => $referer,
            ],
        ];

        $results = $this->testAction('/Pallets/palletPrint/1', [
            'data' => $data,
        ]);

        //echo print_r(compact('item', 'productionLine', 'batch_nos', 'formName'));

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-palletPrint.pdf');

        $outputContents = $this->getContents($outputFile);

        $outputContents = $this->stripSpacesAndNewLines($outputContents);

        $this->assertFileExists($outputFile);

        $this->assertContains($companyName, $outputContents);
        $this->assertContains($expectedItem, $outputContents);
        $this->assertContains($batch_nos, $outputContents);
    }

    /**
     * testPalletReprint method
     *
     * @return void
     */
    public function testPalletReprint()
    {
        $this->markTestIncomplete('testPalletReprint not implemented.');
    }

    /**
     * testView method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('testView not implemented.');
    }

    /**
     * testAdd method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('testAdd not implemented.');
    }

    /**
     * testChangeLocation method
     *
     * @return void
     */
    public function testChangeLocation()
    {
        $this->markTestIncomplete('testChangeLocation not implemented.');
    }

    /**
     * testMultiEdit method
     *
     * @return void
     */
    public function testMultiEdit()
    {
        $this->markTestIncomplete('testMultiEdit not implemented.');
    }

    /**
     * testEdit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('testEdit not implemented.');
    }

    /**
     * testEditPallet method
     *
     * @return void
     */
    public function testEditPallet()
    {
        $this->markTestIncomplete('testEditPallet not implemented.');
    }

    /**
     * testMove method
     *
     * @return void
     */
    public function testMove()
    {
        $this->markTestIncomplete('testMove not implemented.');
    }

    /**
     * testDelete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('testDelete not implemented.');
    }

    /**
     * testLocationSpaceUsage method
     *
     * @return void
     */
    public function testLocationSpaceUsage()
    {
        $this->markTestIncomplete('testLocationSpaceUsage not implemented.');
    }
}