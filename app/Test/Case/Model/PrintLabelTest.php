<?php
App::uses('PrintLabel', 'Model');

/**
 * PrintLabel Test Case
 */
class PrintLabelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.print_label'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PrintLabel = ClassRegistry::init('PrintLabel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PrintLabel);

		parent::tearDown();
	}

/**
 * testGetGlabelsDetail method
 *
 * @return void
 */
	public function testGetGlabelsDetail() {
		$this->markTestIncomplete('testGetGlabelsDetail not implemented.');
	}

/**
 * testCreateSequenceList method
 *
 * @return void
 */
	public function testCreateSequenceList() {
		$this->markTestIncomplete('testCreateSequenceList not implemented.');
	}

/**
 * testFormatPrintLogData method
 *
 * @return void
 */
	public function testFormatPrintLogData() {
		$this->markTestIncomplete('testFormatPrintLogData not implemented.');
	}

/**
 * testCheckStartEndCorrect method
 *
 * @return void
 */
	public function testCheckStartEndCorrect() {
		$this->markTestIncomplete('testCheckStartEndCorrect not implemented.');
	}

/**
 * testMyNotEmpty method
 *
 * @return void
 */
	public function testMyNotEmpty() {
		$this->markTestIncomplete('testMyNotEmpty not implemented.');
	}

/**
 * testStateOrCustomDestination method
 *
 * @return void
 */
	public function testStateOrCustomDestination() {
		$this->markTestIncomplete('testStateOrCustomDestination not implemented.');
	}

}
