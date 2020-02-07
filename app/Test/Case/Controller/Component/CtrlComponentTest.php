<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('CtrlComponent', 'Controller/Component');

/**
 * CtrlComponent Test Case
 * @property CtrlComponent $Ctrl
 */
class CtrlComponentTest extends CakeTestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $Collection = new ComponentCollection();
        $this->Ctrl = new CtrlComponent($Collection);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ctrl);

        parent::tearDown();
    }

    /**
     * testGet method
     *
     * @return void
     */
    public function testGet()
    {
        $controllerList = $this->Ctrl->get();
        $this->assertArrayHasKey('HelpController', $controllerList);
        $this->assertArrayHasKey('PalletsController', $controllerList);
        // $this->markTestIncomplete('testGet not implemented.');
    }

    /**
     * testFormatArray method
     *
     * @return void
     */
    public function testFormatArray()
    {
        $formattedArray = $this->Ctrl->formatArray(false);

        $this->assertGreaterThan(2, count($formattedArray));

        $formattedArray = $this->Ctrl->formatArray();
        $this->assertEqual(2, count($formattedArray));
    }

    /**
     * testFormatForPrinterViews method
     *
     * @return void
     */
    public function testFormatForPrinterViews()
    {
        $this->markTestIncomplete('testFormatForPrinterViews not implemented.');
    }

    /**
     * testFormatControllersWithActionOnlyList method
     *
     * @return void
     */
    public function testFormatControllersWithActionOnlyList()
    {
        $this->markTestIncomplete('testFormatControllersWithActionOnlyList not implemented.');
    }
}
