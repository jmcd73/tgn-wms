<?php
App::uses('Printer', 'Model');

/**
 * Printer Test Case
 */
class PrinterTest extends CakeTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        // 'app.printer',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Printer = ClassRegistry::init('Printer');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Printer);

        parent::tearDown();
    }

    /**
     * testGetCupsURL method
     *
     * @return void
     */
    public function testGetCupsURL()
    {
        $this->markTestIncomplete('testGetCupsURL not implemented.');
    }

    /**
     * testGetLocalPrinterList method
     *
     * @return void
     */
    public function testGetLocalPrinterList()
    {
        echo print_r($this->Printer->getLocalPrinterList());
        $this->markTestIncomplete('testGetLocalPrinterList not implemented.');
    }

    /**
     * testIsControllerActionDuplicated method
     *
     * @return void
     */
    public function testIsControllerActionDuplicated()
    {
        $this->markTestIncomplete('testIsControllerActionDuplicated not implemented.');
    }
}
