<?php
App::uses('Menu', 'Model');

/**
 * Menu Test Case
 */
class MenuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.menu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Menu = ClassRegistry::init('Menu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Menu);

		parent::tearDown();
	}

/**
 * testReturnRoles method
 *
 * @return void
 */
	public function testReturnRoles() {
		$this->markTestIncomplete('testReturnRoles not implemented.');
	}

/**
 * testFindStacked method
 *
 * @return void
 */
	public function testFindStacked() {
		$this->markTestIncomplete('testFindStacked not implemented.');
	}

/**
 * testFmtReasonCode method
 *
 * @return void
 */
	public function testFmtReasonCode() {
		$this->markTestIncomplete('testFmtReasonCode not implemented.');
	}

}
