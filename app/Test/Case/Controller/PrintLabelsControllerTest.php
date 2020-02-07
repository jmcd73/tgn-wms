<?php
App::uses('PrintLabelsController', 'Controller');
App::uses('PrintLabel', 'Model');
App::uses('Item', 'Model');
App::uses('LabelFactory', 'Lib/Print');
App::uses('Hash', 'Utility');
App::uses('TestFrameworkTrait', 'Test/Case/Lib/Framework');

require_once '/var/www/vendors/fzaninotto/faker/src/autoload.php';

/**
 * PrintLabelsController Test Case
 */
class PrintLabelsControllerTest extends ControllerTestCase
{
    use TestFrameworkTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        //'app.print_label',
        //'app.setting'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->PrintLabel = ClassRegistry::init('PrintLabel');
        $this->Item = ClassRegistry::init('Item');
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->PrintLabel, $this->Item);
    }

    /**
     * testShippingLabels method
     *
     * @return void
     */
    public function testShippingLabels()
    {
        $expectedNumber = rand(1, 99);

        $faker = Faker\Factory::create('en_AU');
        $expectedState = $faker->stateAbbr;
        $expectedAddress = $faker->address;
        $expectedCopies = $faker->randomElement([1, 2]);

        $postData = [
            'PrintLabel' => [
                'printer' => 1,
                'copies' => $expectedCopies,
                'sequence-start' => 1,
                'sequence-end' => 9,
                'state' => $expectedState,
                'address' => $expectedAddress,
                'reference' => 'SO-M00006',
            ],
        ];

        $result = $this->testAction(
            '/PrintLabels/shippingLabels',
            ['data' => $postData]
        );

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-shippingLabels.pdf');

        $outputContents = $this->getContents($outputFile);

        $outputContents = $this->stripSpacesAndNewLines($outputContents);

        $this->assertFileExists($outputFile);
        $this->assertContains($expectedState, $outputContents);

        // cut the address into chunks and check each chunk is in the output

        $expectedAddress = str_replace(',', '', $expectedAddress);
        $expectedAddress = str_replace("\n", ' ', $expectedAddress);

        $this->assertContains($expectedAddress, $outputContents);
    }

    /**
     * testKeepRefrigerated method
     *
     * @return void
     */
    public function testKeepRefrigerated()
    {
        $expectedNumber = rand(1, 99);

        $data = [
            'PrintLabel' => [
                'printer' => 1,
                'copies' => $expectedNumber,
            ],
        ];
        $result = $this->testAction(
            '/PrintLabels/keepRefrigerated',
            ['data' => $data]
        );

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-keepRefrigerated.pdf');

        $this->assertFileExists($outputFile);

        $outputContents = $this->getContents($outputFile);

        //$outputContents = trim(implode("\n", $outputContents));

        $this->assertContains('KEEP REFRIGERATED', $outputContents);
        $this->assertContains('AT OR BELOW 4°C', $outputContents);
        $this->assertContains('DO NOT FREEZE', $outputContents);
    }

    /**
     * testBigNumber method
     *
     * @return void
     */
    public function testBigNumber()
    {
        $expectedNumber = rand(1, 99);

        $offset = strlen($expectedNumber) === 1 ? '0310' : '0160';

        $expectedTextLine = sprintf('^FT%s,1000^A0N,1000,500^FD%d^FS', $offset, $expectedNumber);

        $expectedQtyLine = sprintf('^PQ%d,0,1,Y^XZ', $expectedNumber);

        $data = [
            'PrintLabel' => [
                'printerId' => 1,
                'printer' => 'PDF Printer',
                'number' => $expectedNumber,
                'quantity' => $expectedNumber,
            ],
        ];

        $result = $this->testAction(
            '/PrintLabels/bigNumber',
            ['data' => $data]
        );

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-bigNumber.pdf');

        $this->assertFileExists($outputFile);

        // can't check output of pdf because the PDF symbol table is garbled
        // so check the raw output
        $outputContents = file_get_contents(TMP . 'bigNumber_print.txt');

        // test if it creates an output file
        $this->assertTrue(is_file($outputFile), $outputFile . ' bigNumber PDF file missing!');
        $this->assertContains($expectedTextLine, $outputContents);
        $this->assertContains($expectedQtyLine, $outputContents);
    }

    /**
     * testGlabelSampleLabels method
     *
     * @return void
     */
    public function testGlabelSampleLabels()
    {
        $data = [
            'printer' => 1,
            'copies' => 44,
            'print_action' => 'glabelSampleLabels',
        ];

        $printerDetails = [
            'Printer' => [
                'id' => 1,
                'active' => 1,
                'name' => 'PDF Printer',
                'options' => '',
                'queue_name' => 'PDF',
            ],
        ];

        $template = $this->PrintLabel->getGlabelsDetail('PrintLabels', 'glabelSampleLabels');

        $printResult = LabelFactory::create($data['print_action'])
        ->format($data)->print(
            $printerDetails,
            $template->file_path
        );

        $actualCopies = explode(' ', $printResult['cmd'])[4];
        $this->assertEqual($data['copies'], $actualCopies, 'Expected print copies not the same as actual');
    }

    /**
     * shippingLabels:ShippingLabel variablePages 1
     * crossdockLabels:CrossdockLabel variablePages 1
     */
    public function testExpectedPrintCountIsAlwaysOneForShippingLabel()
    {
        /*
            [printer] => 1
            [copies] => 2
            [sequence-start] => 2
            [sequence-end] => 8
            [state] => VIC
            [address] => Address 1 2 three
            [reference] => SO-MOOOOO888
            [print_action] => shippingLabels
        */

        $faker = Faker\Factory::create('en_AU');
        $expectedState = $faker->stateAbbr;
        $expectedAddress = $faker->address;
        $expectedReference = 'PO' . sprintf('%06d', rand(1, 999999));
        $expectedCopies = $faker->randomElement([1, 2]);
        $sequenceStart = $faker->randomElement([1, 2, 3, 4, 5]);
        $sequenceEnd = rand($sequenceStart, 99);
        $expectedLprCmdCopies = 1;

        $data = [
            'printer' => 1,
            'copies' => $expectedCopies,
            'address' => $expectedAddress,
            'state' => $expectedState,
            'print_action' => 'shippingLabels',
            'reference' => $expectedReference,
            'sequence-start' => $sequenceStart,
            'sequence-end' => $sequenceEnd,
        ];

        $printerDetails = [
            'Printer' => [
                'id' => 1,
                'active' => 1,
                'name' => 'PDF Printer',
                'options' => '',
                'queue_name' => 'PDF',
            ],
        ];

        $template = $this->PrintLabel->getGlabelsDetail('PrintLabels', 'shippingLabels');

        $printResult = LabelFactory::create($data['print_action'])
        ->format($data)->print(
            $printerDetails,
            $template->file_path
        );

        $actualCopies = explode(' ', $printResult['cmd'])[4];
        $this->assertEqual($expectedLprCmdCopies, $actualCopies, 'Expected print copies not the same as actual');
    }

    /**
     * shippingLabels:ShippingLabel variablePages 1
     * crossdockLabels:CrossdockLabel variablePages 1
     */
    public function testExpectedPrintCountIsAlwaysOneForCrossdockLabel()
    {
        /*
                [sending_co] => 100% Bottling Company
                [printer] => 1
                [purchase_order] => PO-1232983290
                [address] => Woolworths Laverton
                [booked_date] => 21/01/2020
                [sequence-start] => 1
                [sequence-end] => 5
                [copies] => 1
                [print_action] => crossdockLabels
         */
        $faker = Faker\Factory::create('en_AU');
        $expectedState = $faker->stateAbbr;
        $expectedPO = 'SO-M' . sprintf('%07d', rand(1, 9999999));
        $expectedCopies = $faker->randomElement([1, 2]);
        $sequenceStart = $faker->randomElement([1, 2, 3, 4, 5]);
        $sequenceEnd = rand($sequenceStart, 99);
        $expectedLprCmdCopies = 1;
        $expectedBookedDate = $faker->date('d/m/Y');

        $data = [
            'sending_co' => 'Toggen IT Services',
            'printer' => 1,
            'purchase_order' => $expectedPO,
            'copies' => $expectedCopies,
            'address' => $faker->company,
            'state' => $expectedState,
            'print_action' => 'crossdockLabels',
            'booked_date' => $expectedBookedDate,
            'sequence-start' => $sequenceStart,
            'sequence-end' => $sequenceEnd,
        ];

        $printerDetails = [
            'Printer' => [
                'id' => 1,
                'active' => 1,
                'name' => 'PDF Printer',
                'options' => '',
                'queue_name' => 'PDF',
            ],
        ];

        $template = $this->PrintLabel->getGlabelsDetail('PrintLabels', 'crossdockLabels');

        $printResult = LabelFactory::create($data['print_action'])
            ->format($data)
            ->print(
                $printerDetails,
                $template->file_path
            );

        $actualCopies = explode(' ', $printResult['cmd'])[4];
        $this->assertEqual($expectedLprCmdCopies, $actualCopies, 'Expected print copies not the same as actual');
    }

    /**
     * testLabelChooser method
     *
     * @return void
     */
    public function testLabelChooser()
    {
        $this->markTestIncomplete('testLabelChooser not implemented.');
    }

    /**
     * testCustomPrint method
     *
     * @return void
     */
    public function testCustomPrint()
    {
        $this->markTestIncomplete('testCustomPrint not implemented.');
    }

    /**
     * testSampleLabels method
     *
     * @return void
     */
    public function testSampleLabels()
    {
        $action = 'sampleLabels';

        $expectedNumber = rand(1, 400);

        $faker = Faker\Factory::create('en_AU');
        $companyName = $faker->company;
        $productName = $faker->words(3, true);
        $date1 = $faker->date('d/m/Y');
        $date2 = $faker->date('d/m/Y');
        for ($i = 1; $i < 5; $i++) {
            ${'genericLine' . $i} = $faker->words(rand(1, 5), true);
        }

        /*
            [printer] => 1
            [copies] => 8
            [productName] => SAMPLE PRODUCTS
            [batch] => 9152XX
            [manufactureDate] => 27/01/2020
            [bestBefore] => 28/01/2020
            [comment] => Comment (36 Characters max)
        */

        $batch = sprintf('%05d', rand(0, 99999));

        $data = [
            'PrintLabel' => [
                'printer' => 1,
                'copies' => $expectedNumber,
                'batch' => $batch,
                'productName' => $productName,
                'manufactureDate' => $date1,
                'bestBefore' => $date2,
                'comment' => $genericLine1,
            ],
        ];

        $result = $this->testAction(
            '/PrintLabels/' . $action,
            ['data' => $data]
        );

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-' . $action . '.pdf');

        $outputContents = $this->getContents($outputFile);

        $this->assertFileExists($outputFile);
        $outputContents = $this->stripSpacesAndNewLines($outputContents);
        //$outputContents = file_get_contents(TMP . 'PrintTempFile.txt');
        $exptedLine = $this->stripSpacesAndNewLines($genericLine1);
        $this->assertContains($productName, $outputContents);
        $this->assertContains($date1, $outputContents);
        $this->assertContains($date2, $outputContents);
        $this->assertContains($exptedLine, $outputContents);
    }

    /**
     * testDayofyear method
     *
     * @return void
     */
    public function testDayofyear()
    {
        $this->markTestIncomplete('testDayofyear not implemented.');
    }

    /**
     * testCompleted method
     *
     * @return void
     */
    public function testCompleted()
    {
        $this->markTestIncomplete('testCompleted not implemented.');
    }

    /**
     * testPrintCartonLabels method
     *
     * @return void
     */
    public function testPrintCartonLabels()
    {
        $faker = Faker\Factory::create();

        $items = $this->Item->find('all', [
            'fields' => [
                'trade_unit',
                'description',
            ],
            'conditions' => [
                'Item.code LIKE' => '6%',
            ],
            'contain' => [
            ],
        ]);

        $elements = Hash::extract($items, '{n}.Item');

        $product = $faker->randomElement($elements);

        $count = rand(1, 99);

        $data = [
            'barcode' => $product['trade_unit'],
            'print_action' => 'cartonPrint',
            'description' => $product['description'],
            'count' => $count,
            'printer_id' => 1,
            'printer_friendly_name' => 'PDF Printer',
        ];

        $printTemplate = $this->Item->find('first', [
            'conditions' => [
                'Item.trade_unit' => $data['barcode'],
            ],
            'contain' => [
                'CartonLabel',
            ],
        ]);

        $printerDetails = $this->PrintLabel->getLabelPrinterById($data['printer_id']);

        $results = $this->testAction(
            '/PrintLabels/printCartonLabels',
            ['data' => $data]
        );

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-printCartonLabels.pdf');

        $this->assertFileExists($outputFile);

        $outputContents = file_get_contents(TMP . 'printCartonLabels_print.txt');

        // test if it creates an output file
        $this->assertFileExists($outputFile, $outputFile . ' bigNumber PDF file missing!');
        $this->assertContains('A ' . $count, $outputContents);
        $this->assertContains('B 8,8,0,GS1-128,38,0.56;(01)' . $product['trade_unit'], $outputContents);
        $this->assertContains('T 6,4,0,596,pt16;' . $product['description'], $outputContents);

        //$this->markTestIncomplete('testPrintCartonLabels not implemented.');
    }

    /**
     * testPrintLog method
     *
     * @return void
     */
    public function testPrintLog()
    {
        $this->markTestIncomplete('testPrintLog not implemented.');
    }

    /**
     * testCartonPrint method
     *
     * @return void
     */
    public function testCartonPrint()
    {
        $this->markTestIncomplete('testCartonPrint not implemented.');
    }

    /**
     * testCrossdockLabels method
     *
     * @return void
     */
    public function testCrossdockLabels()
    {
        $this->markTestIncomplete('testCrossdockLabels not implemented.');
    }

    /**
     * testShippingLabelsGeneric method
     *
     * @return void
     */
    public function testGenericShippingLabels()
    {
        $expectedNumber = rand(1, 99);

        $result = $this->testAction(
            '/PrintLabels/shippingLabelsGeneric',
            ['result' => 'vars', 'method' => 'get']
        );

        $this->assertContains('PDF Printer', $this->vars['printers']['printers'], "Can't find it");
        $this->assertContains('1', $this->vars['printers']['default'], "Can't find it");

        $faker = Faker\Factory::create('en_AU');
        $companyName = $faker->company;
        $productName = $faker->words(2, true);
        $productDescription = $faker->words(5, true);
        for ($i = 1; $i < 5; $i++) {
            ${'genericLine' . $i} = $faker->words(rand(1, 5), true);
        }

        $data = [
            'PrintLabel' => [
                'printer' => 1,
                'copies' => 2,
                'companyName' => $companyName,
                'productName' => $productName,
                'productDescription' => $productDescription,
                'genericLine1' => $genericLine1,
                'genericLine2' => $genericLine2,
                'genericLine3' => $genericLine3,
                'genericLine4' => $genericLine4,
            ],
        ];

        $result = $this->testAction(
            '/PrintLabels/shippingLabelsGeneric',
            ['data' => $data]
        );

        $outputFile = $this->checkForPdfPrintOutput($this->outputDir, '.*-shippingLabelsGeneric.pdf');

        $outputContents = $this->getContents($outputFile);

        $outputContents = $this->stripSpacesAndNewLines($outputContents);

        $this->assertContains($companyName, $outputContents);
        $this->assertContains($genericLine1, $outputContents);
        $this->assertContains($genericLine2, $outputContents);
        $this->assertContains($genericLine3, $outputContents);
        $this->assertContains($genericLine4, $outputContents);
    }
}