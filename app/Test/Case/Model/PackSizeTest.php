<?php
App::uses('PackSize', 'Model');

/**
 * PackSize Test Case
 */
class PackSizeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.pack_size',
		'app.item',
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
		$this->PackSize = ClassRegistry::init('PackSize');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PackSize);

		parent::tearDown();
	}

}
