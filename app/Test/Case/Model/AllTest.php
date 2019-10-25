<?php
App::uses('all', 'Model');

/**
 * all Test Case
 */
class allTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->all = ClassRegistry::init('all');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->all);

		parent::tearDown();
	}

}
