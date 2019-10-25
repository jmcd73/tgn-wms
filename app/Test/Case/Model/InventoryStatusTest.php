<?php
App::uses('InventoryStatus', 'Model');

/**
 * InventoryStatus Test Case
 */
class InventoryStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.inventory_status',
		'app.label',
		'app.product_type',
		'app.location',
		'app.production_line',
		'app.printer',
		'app.item',
		'app.pack_size',
		'app.print_template',
		'app.shift',
		'app.shipment',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InventoryStatus = ClassRegistry::init('InventoryStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InventoryStatus);

		parent::tearDown();
	}

/**
 * testCreateStockViewPermsList method
 *
 * @return void
 */
	public function testCreateStockViewPermsList() {
		$this->markTestIncomplete('testCreateStockViewPermsList not implemented.');
	}

}
