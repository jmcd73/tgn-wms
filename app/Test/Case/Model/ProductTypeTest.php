<?php
App::uses('ProductType', 'Model');

/**
 * ProductType Test Case
 */
class ProductTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product_type',
		'app.location',
		'app.label',
		'app.printer',
		'app.shipment',
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
		$this->ProductType = ClassRegistry::init('ProductType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductType);

		parent::tearDown();
	}

/**
 * testGetStorageTemperatureSelectOptions method
 *
 * @return void
 */
	public function testGetStorageTemperatureSelectOptions() {
		$this->markTestIncomplete('testGetStorageTemperatureSelectOptions not implemented.');
	}

}
