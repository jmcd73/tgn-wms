<?php
App::uses('Item', 'Model');

/**
 * Item Test Case
 */
class ItemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.item',
		'app.pack_size',
		'app.print_template',
		'app.product_type',
		'app.location',
		'app.label',
		'app.printer',
		'app.shipment',
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
		$this->Item = ClassRegistry::init('Item');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Item);

		parent::tearDown();
	}

/**
 * testGetPalletPrintItems method
 *
 * @return void
 */
	public function testGetPalletPrintItems() {
		$this->markTestIncomplete('testGetPalletPrintItems not implemented.');
	}

/**
 * testItemLookup method
 *
 * @return void
 */
	public function testItemLookup() {
		$this->markTestIncomplete('testItemLookup not implemented.');
	}

/**
 * testFmtItem method
 *
 * @return void
 */
	public function testFmtItem() {
		$this->markTestIncomplete('testFmtItem not implemented.');
	}

/**
 * testCodeDescPack method
 *
 * @return void
 */
	public function testCodeDescPack() {
		$this->markTestIncomplete('testCodeDescPack not implemented.');
	}

/**
 * testCheckItemCodeIsValid method
 *
 * @return void
 */
	public function testCheckItemCodeIsValid() {
		$this->markTestIncomplete('testCheckItemCodeIsValid not implemented.');
	}

}
