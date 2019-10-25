<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('ToggenHtmlHelper', 'View/Helper');

/**
 * ToggenHtmlHelper Test Case
 */
class ToggenHtmlHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->ToggenHtml = new ToggenHtmlHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ToggenHtml);

		parent::tearDown();
	}

/**
 * testBuildClass method
 *
 * @return void
 */
	public function testBuildClass() {
		$this->markTestIncomplete('testBuildClass not implemented.');
	}

}
