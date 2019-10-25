<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('ReactEmbedComponent', 'Controller/Component');

/**
 * ReactEmbedComponent Test Case
 */
class ReactEmbedComponentTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->ReactEmbed = new ReactEmbedComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ReactEmbed);

		parent::tearDown();
	}

/**
 * testGetAssets method
 *
 * @return void
 */
	public function testGetAssets() {
		$this->markTestIncomplete('testGetAssets not implemented.');
	}

/**
 * testBaseUrl method
 *
 * @return void
 */
	public function testBaseUrl() {
		$this->markTestIncomplete('testBaseUrl not implemented.');
	}

/**
 * testAssets method
 *
 * @return void
 */
	public function testAssets() {
		$this->markTestIncomplete('testAssets not implemented.');
	}

}
