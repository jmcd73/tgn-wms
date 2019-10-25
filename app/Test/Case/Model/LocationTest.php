<?php
App::uses('Location', 'Model');

/**
 * Location Test Case
 */
class LocationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.location',
		'app.product_type',
		'app.inventory_status',
		'app.label',
		'app.printer',
		'app.shipment',
		'app.item',
		'app.pack_size',
		'app.print_template',
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
		$this->Location = ClassRegistry::init('Location');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Location);

		parent::tearDown();
	}

}
