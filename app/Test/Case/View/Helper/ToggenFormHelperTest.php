<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('ToggenFormHelper', 'View/Helper');

/**
 * ToggenFormHelper Test Case
 */
class ToggenFormHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->ToggenForm = new ToggenFormHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ToggenForm);

		parent::tearDown();
	}

}
