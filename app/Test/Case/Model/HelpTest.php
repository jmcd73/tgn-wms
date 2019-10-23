<?php
App::uses('Help', 'Model');

/**
 * Help Test Case
 */
class HelpTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.help'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Help = ClassRegistry::init('Help');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Help);

		parent::tearDown();
	}

}
