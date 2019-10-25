<?php
App::uses('Shift', 'Model');

/**
 * Shift Test Case
 */
class ShiftTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.shift',
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
		'app.production_line'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Shift = ClassRegistry::init('Shift');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Shift);

		parent::tearDown();
	}

/**
 * testShiftMinutes method
 *
 * @return void
 */
	public function testShiftMinutes() {
		$this->markTestIncomplete('testShiftMinutes not implemented.');
	}

}
