<?php
App::uses('PrintTemplate', 'Model');

/**
 * PrintTemplate Test Case
 */
class PrintTemplateTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.print_template',
		'app.item',
		'app.pack_size',
		'app.machines_standard_rate',
		'app.machine',
		'app.report',
		'app.report_date',
		'app.shift',
		'app.product_type',
		'app.location',
		'app.label',
		'app.shipment',
		'app.operator',
		'app.truck_registration',
		'app.inventory_status',
		'app.user',
		'app.label_history',
		'app.down_time',
		'app.downtime_type',
		'app.reason_code'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PrintTemplate = ClassRegistry::init('PrintTemplate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PrintTemplate);

		parent::tearDown();
	}

}
