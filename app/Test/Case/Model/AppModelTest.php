<?php
App::uses('AppModel', 'Model');

/**
 * AppModel Test Case
 */
class AppModelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.app_model'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AppModel = ClassRegistry::init('AppModel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AppModel);

		parent::tearDown();
	}

/**
 * testGetLabelPrinterById method
 *
 * @return void
 */
	public function testGetLabelPrinterById() {
		$this->markTestIncomplete('testGetLabelPrinterById not implemented.');
	}

/**
 * testGetLabelPrinters method
 *
 * @return void
 */
	public function testGetLabelPrinters() {
		$this->markTestIncomplete('testGetLabelPrinters not implemented.');
	}

/**
 * testGetSetting method
 *
 * @return void
 */
	public function testGetSetting() {
		$this->markTestIncomplete('testGetSetting not implemented.');
	}

/**
 * testGetViewPermNumber method
 *
 * @return void
 */
	public function testGetViewPermNumber() {
		$this->markTestIncomplete('testGetViewPermNumber not implemented.');
	}

/**
 * testDbConfig method
 *
 * @return void
 */
	public function testDbConfig() {
		$this->markTestIncomplete('testDbConfig not implemented.');
	}

/**
 * testDivideValues method
 *
 * @return void
 */
	public function testDivideValues() {
		$this->markTestIncomplete('testDivideValues not implemented.');
	}

/**
 * testArrayToMysqlDate method
 *
 * @return void
 */
	public function testArrayToMysqlDate() {
		$this->markTestIncomplete('testArrayToMysqlDate not implemented.');
	}

/**
 * testGetDateTimeDiff method
 *
 * @return void
 */
	public function testGetDateTimeDiff() {
		$this->markTestIncomplete('testGetDateTimeDiff not implemented.');
	}

/**
 * testFormatValidationErrors method
 *
 * @return void
 */
	public function testFormatValidationErrors() {
		$this->markTestIncomplete('testFormatValidationErrors not implemented.');
	}

/**
 * testAddMinutesToDateTime method
 *
 * @return void
 */
	public function testAddMinutesToDateTime() {
		$this->markTestIncomplete('testAddMinutesToDateTime not implemented.');
	}

/**
 * testPalletsDotCartons method
 *
 * @return void
 */
	public function testPalletsDotCartons() {
		$this->markTestIncomplete('testPalletsDotCartons not implemented.');
	}

/**
 * testGetDateTimeStamp method
 *
 * @return void
 */
	public function testGetDateTimeStamp() {
		$this->markTestIncomplete('testGetDateTimeStamp not implemented.');
	}

/**
 * testFormatLabelDates method
 *
 * @return void
 */
	public function testFormatLabelDates() {
		$this->markTestIncomplete('testFormatLabelDates not implemented.');
	}

/**
 * testGetBatchNumbers method
 *
 * @return void
 */
	public function testGetBatchNumbers() {
		$this->markTestIncomplete('testGetBatchNumbers not implemented.');
	}

/**
 * testCheckBatchNum method
 *
 * @return void
 */
	public function testCheckBatchNum() {
		$this->markTestIncomplete('testCheckBatchNum not implemented.');
	}

/**
 * testCreatePalletRef method
 *
 * @return void
 */
	public function testCreatePalletRef() {
		$this->markTestIncomplete('testCreatePalletRef not implemented.');
	}

/**
 * testGetHelpPage method
 *
 * @return void
 */
	public function testGetHelpPage() {
		$this->markTestIncomplete('testGetHelpPage not implemented.');
	}

}
