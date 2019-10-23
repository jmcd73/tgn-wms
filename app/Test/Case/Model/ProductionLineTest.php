<?php
App::uses('ProductionLine', 'Model');

/**
 * ProductionLine Test Case
 */
class ProductionLineTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.production_line',
		'app.product_type',
		'app.location',
		'app.label',
		'app.shipment',
		'app.item',
		'app.pack_size',
		'app.machines_standard_rate',
		'app.print_template',
		'app.report',
		'app.inventory_status',
		'app.user',
		'app.label_history',
		'app.shift'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductionLine = ClassRegistry::init('ProductionLine');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductionLine);

		parent::tearDown();
	}

}
