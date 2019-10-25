<?php
App::uses('Shipment', 'Model');

/**
 * Shipment Test Case
 */
class ShipmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.shipment',
		'app.product_type',
		'app.location',
		'app.label',
		'app.printer',
		'app.item',
		'app.pack_size',
		'app.print_template',
		'app.inventory_status',
		'app.user',
		'app.production_line',
		'app.shift'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Shipment = ClassRegistry::init('Shipment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Shipment);

		parent::tearDown();
	}

/**
 * testGetShipmentLabelOptions method
 *
 * @return void
 */
	public function testGetShipmentLabelOptions() {
		$this->markTestIncomplete('testGetShipmentLabelOptions not implemented.');
	}

/**
 * testGetShipmentLabels method
 *
 * @return void
 */
	public function testGetShipmentLabels() {
		$this->markTestIncomplete('testGetShipmentLabels not implemented.');
	}

/**
 * testLabelCount method
 *
 * @return void
 */
	public function testLabelCount() {
		$this->markTestIncomplete('testLabelCount not implemented.');
	}

/**
 * testIsDifferentArrays method
 *
 * @return void
 */
	public function testIsDifferentArrays() {
		$this->markTestIncomplete('testIsDifferentArrays not implemented.');
	}

/**
 * testCheckLabelsNotChanged method
 *
 * @return void
 */
	public function testCheckLabelsNotChanged() {
		$this->markTestIncomplete('testCheckLabelsNotChanged not implemented.');
	}

/**
 * testDestinationLookup method
 *
 * @return void
 */
	public function testDestinationLookup() {
		$this->markTestIncomplete('testDestinationLookup not implemented.');
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
 * testGetIds method
 *
 * @return void
 */
	public function testGetIds() {
		$this->markTestIncomplete('testGetIds not implemented.');
	}

/**
 * testFormatLabels method
 *
 * @return void
 */
	public function testFormatLabels() {
		$this->markTestIncomplete('testFormatLabels not implemented.');
	}

/**
 * testMarkDisabled method
 *
 * @return void
 */
	public function testMarkDisabled() {
		$this->markTestIncomplete('testMarkDisabled not implemented.');
	}

/**
 * testGetDisabled method
 *
 * @return void
 */
	public function testGetDisabled() {
		$this->markTestIncomplete('testGetDisabled not implemented.');
	}

/**
 * testGetShipmentTypeByLabelIds method
 *
 * @return void
 */
	public function testGetShipmentTypeByLabelIds() {
		$this->markTestIncomplete('testGetShipmentTypeByLabelIds not implemented.');
	}

/**
 * testCompareShipmentTypes method
 *
 * @return void
 */
	public function testCompareShipmentTypes() {
		$this->markTestIncomplete('testCompareShipmentTypes not implemented.');
	}

/**
 * testIsEmpty method
 *
 * @return void
 */
	public function testIsEmpty() {
		$this->markTestIncomplete('testIsEmpty not implemented.');
	}

/**
 * testNoChangeOnceShipped method
 *
 * @return void
 */
	public function testNoChangeOnceShipped() {
		$this->markTestIncomplete('testNoChangeOnceShipped not implemented.');
	}

/**
 * testCheckPallets method
 *
 * @return void
 */
	public function testCheckPallets() {
		$this->markTestIncomplete('testCheckPallets not implemented.');
	}

}
