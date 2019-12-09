<?php
App::uses('Carton', 'Model');

/**
 * Carton Test Case
 */
class CartonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.carton',
		'app.pallet',
		'app.product_type',
		'app.location',
		'app.inventory_status',
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
		$this->Carton = ClassRegistry::init('Carton');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Carton);

		parent::tearDown();
	}

/**
 * testNotShipped method
 *
 * @return void
 */
	public function testNotShipped() {
		$this->markTestIncomplete('testNotShipped not implemented.');
	}

/**
 * testIsUniqueDate method
 *
 * @return void
 */
	public function testIsUniqueDate() {
		$this->markTestIncomplete('testIsUniqueDate not implemented.');
	}

}
