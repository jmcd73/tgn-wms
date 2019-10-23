<?php
App::uses('LabelsLocation', 'Model');

/**
 * LabelsLocation Test Case
 *
 */
class LabelsLocationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.labels_location',
		'app.labels',
		'app.locations'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LabelsLocation = ClassRegistry::init('LabelsLocation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LabelsLocation);

		parent::tearDown();
	}

}
