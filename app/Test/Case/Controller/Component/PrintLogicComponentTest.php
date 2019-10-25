<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('PrintLogicComponent', 'Controller/Component');

/**
 * PrintLogicComponent Test Case
 */
class PrintLogicComponentTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->PrintLogic = new PrintLogicComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PrintLogic);

		parent::tearDown();
	}

/**
 * testFormatPrintLine method
 *
 * @return void
 */
	public function testFormatPrintLine() {
		$this->markTestIncomplete('testFormatPrintLine not implemented.');
	}

/**
 * testGetCwd method
 *
 * @return void
 */
	public function testGetCwd() {
		$this->markTestIncomplete('testGetCwd not implemented.');
	}

/**
 * testSetCwd method
 *
 * @return void
 */
	public function testSetCwd() {
		$this->markTestIncomplete('testSetCwd not implemented.');
	}

/**
 * testSetPrintContentArray method
 *
 * @return void
 */
	public function testSetPrintContentArray() {
		$this->markTestIncomplete('testSetPrintContentArray not implemented.');
	}

/**
 * testGetPrintContentArrayValue method
 *
 * @return void
 */
	public function testGetPrintContentArrayValue() {
		$this->markTestIncomplete('testGetPrintContentArrayValue not implemented.');
	}

/**
 * testSetGlabelsTemplate method
 *
 * @return void
 */
	public function testSetGlabelsTemplate() {
		$this->markTestIncomplete('testSetGlabelsTemplate not implemented.');
	}

/**
 * testGetGlabelsTemplate method
 *
 * @return void
 */
	public function testGetGlabelsTemplate() {
		$this->markTestIncomplete('testGetGlabelsTemplate not implemented.');
	}

/**
 * testGetJobId method
 *
 * @return void
 */
	public function testGetJobId() {
		$this->markTestIncomplete('testGetJobId not implemented.');
	}

/**
 * testSetJobId method
 *
 * @return void
 */
	public function testSetJobId() {
		$this->markTestIncomplete('testSetJobId not implemented.');
	}

/**
 * testSetOutFile method
 *
 * @return void
 */
	public function testSetOutFile() {
		$this->markTestIncomplete('testSetOutFile not implemented.');
	}

/**
 * testGetOutFile method
 *
 * @return void
 */
	public function testGetOutFile() {
		$this->markTestIncomplete('testGetOutFile not implemented.');
	}

/**
 * testGetArrayProperties method
 *
 * @return void
 */
	public function testGetArrayProperties() {
		$this->markTestIncomplete('testGetArrayProperties not implemented.');
	}

/**
 * testFormatSampleLabel method
 *
 * @return void
 */
	public function testFormatSampleLabel() {
		$this->markTestIncomplete('testFormatSampleLabel not implemented.');
	}

/**
 * testSetPrintCopies method
 *
 * @return void
 */
	public function testSetPrintCopies() {
		$this->markTestIncomplete('testSetPrintCopies not implemented.');
	}

/**
 * testFormatGLabelSample method
 *
 * @return void
 */
	public function testFormatGLabelSample() {
		$this->markTestIncomplete('testFormatGLabelSample not implemented.');
	}

/**
 * testFormatCustomLabel method
 *
 * @return void
 */
	public function testFormatCustomLabel() {
		$this->markTestIncomplete('testFormatCustomLabel not implemented.');
	}

/**
 * testFormatShippingLabelsGeneric method
 *
 * @return void
 */
	public function testFormatShippingLabelsGeneric() {
		$this->markTestIncomplete('testFormatShippingLabelsGeneric not implemented.');
	}

/**
 * testSplitValueIntoTwoParts method
 *
 * @return void
 */
	public function testSplitValueIntoTwoParts() {
		$this->markTestIncomplete('testSplitValueIntoTwoParts not implemented.');
	}

/**
 * testFormatCrossdockLabelPrintLine method
 *
 * @return void
 */
	public function testFormatCrossdockLabelPrintLine() {
		$this->markTestIncomplete('testFormatCrossdockLabelPrintLine not implemented.');
	}

/**
 * testInsertNewLineAtComma method
 *
 * @return void
 */
	public function testInsertNewLineAtComma() {
		$this->markTestIncomplete('testInsertNewLineAtComma not implemented.');
	}

/**
 * testFormatShippingLabelPrintLine method
 *
 * @return void
 */
	public function testFormatShippingLabelPrintLine() {
		$this->markTestIncomplete('testFormatShippingLabelPrintLine not implemented.');
	}

/**
 * testSendPdfToLpr method
 *
 * @return void
 */
	public function testSendPdfToLpr() {
		$this->markTestIncomplete('testSendPdfToLpr not implemented.');
	}

/**
 * testGlabelsBatchPrint method
 *
 * @return void
 */
	public function testGlabelsBatchPrint() {
		$this->markTestIncomplete('testGlabelsBatchPrint not implemented.');
	}

/**
 * testRunProcess method
 *
 * @return void
 */
	public function testRunProcess() {
		$this->markTestIncomplete('testRunProcess not implemented.');
	}

/**
 * testGetPrintSettings method
 *
 * @return void
 */
	public function testGetPrintSettings() {
		$this->markTestIncomplete('testGetPrintSettings not implemented.');
	}

/**
 * testGetPrintJobName method
 *
 * @return void
 */
	public function testGetPrintJobName() {
		$this->markTestIncomplete('testGetPrintJobName not implemented.');
	}

/**
 * testCreateTempFile method
 *
 * @return void
 */
	public function testCreateTempFile() {
		$this->markTestIncomplete('testCreateTempFile not implemented.');
	}

/**
 * testSendPrint method
 *
 * @return void
 */
	public function testSendPrint() {
		$this->markTestIncomplete('testSendPrint not implemented.');
	}

}
