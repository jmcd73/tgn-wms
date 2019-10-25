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

/**
 * testSetDocumentationRoot method
 *
 * @return void
 */
	public function testSetDocumentationRoot() {
		$this->markTestIncomplete('testSetDocumentationRoot not implemented.');
	}

/**
 * testGetMarkdown method
 *
 * @return void
 */
	public function testGetMarkdown() {
		$this->markTestIncomplete('testGetMarkdown not implemented.');
	}

/**
 * testListMdFiles method
 *
 * @return void
 */
	public function testListMdFiles() {
		$this->markTestIncomplete('testListMdFiles not implemented.');
	}

}
