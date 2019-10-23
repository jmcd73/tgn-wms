<?php
App::uses('Label', 'Model');

/**
 * Label Test Case
 */
class LabelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.label',
		'app.location',
		'app.product_type',
		'app.item',
		'app.pack_size',
		'app.machines_standard_rate',
		'app.machine',
		'app.report',
		'app.report_date',
		'app.shift',
		'app.down_time',
		'app.downtime_type',
		'app.reason_code',
		'app.shipment',
		'app.operator',
		'app.truck_registration',
		'app.inventory_status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Label = ClassRegistry::init('Label');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Label);

		parent::tearDown();
	}

/**
 * testFormatLookupRequestData method
 *
 * @return void
 */
	public function testFormatLookupRequestData() {
		$this->markTestIncomplete('testFormatLookupRequestData not implemented.');
	}

/**
 * testFormatLookupActionConditions method
 *
 * @return void
 */
	public function testFormatLookupActionConditions() {
		$this->markTestIncomplete('testFormatLookupActionConditions not implemented.');
	}

/**
 * testCheckChangeOK method
 *
 * @return void
 */
	public function testCheckChangeOK() {
		$this->markTestIncomplete('testCheckChangeOK not implemented.');
	}

/**
 * testGetGlobalMinDaysLife method
 *
 * @return void
 */
	public function testGetGlobalMinDaysLife() {
		$this->markTestIncomplete('testGetGlobalMinDaysLife not implemented.');
	}

/**
 * testDoNotShip method
 *
 * @return void
 */
	public function testDoNotShip() {
		$this->markTestIncomplete('testDoNotShip not implemented.');
	}

/**
 * testPalletReferenceLookup method
 *
 * @return void
 */
	public function testPalletReferenceLookup() {
		$this->markTestIncomplete('testPalletReferenceLookup not implemented.');
	}

/**
 * testBatchLookup method
 *
 * @return void
 */
	public function testBatchLookup() {
		$this->markTestIncomplete('testBatchLookup not implemented.');
	}

/**
 * testFormatBatch method
 *
 * @return void
 */
	public function testFormatBatch() {
		$this->markTestIncomplete('testFormatBatch not implemented.');
	}

/**
 * testFormatLookup method
 *
 * @return void
 */
	public function testFormatLookup() {
		$this->markTestIncomplete('testFormatLookup not implemented.');
	}

}
