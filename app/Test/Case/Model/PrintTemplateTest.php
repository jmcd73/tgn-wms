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

/**
 * testDeleteFileTemplate method
 *
 * @return void
 */
	public function testDeleteFileTemplate() {
		$this->markTestIncomplete('testDeleteFileTemplate not implemented.');
	}

}
