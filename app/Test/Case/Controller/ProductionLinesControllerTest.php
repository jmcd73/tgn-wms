<?php
App::uses('ProductionLinesController', 'Controller');

/**
 * ProductionLinesController Test Case
 */
class ProductionLinesControllerTest extends ControllerTestCase {

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
		'app.shift',
		'app.setting'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->markTestIncomplete('testIndex not implemented.');
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->markTestIncomplete('testView not implemented.');
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$this->markTestIncomplete('testAdd not implemented.');
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$this->markTestIncomplete('testEdit not implemented.');
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
		$this->markTestIncomplete('testDelete not implemented.');
	}

}
