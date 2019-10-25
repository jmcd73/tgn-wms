<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('NavBarHelper', 'View/Helper');

/**
 * NavBarHelper Test Case
 */
class NavBarHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->NavBar = new NavBarHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->NavBar);

		parent::tearDown();
	}

}
