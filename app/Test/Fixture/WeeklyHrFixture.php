<?php
/**
 * WeeklyHr Fixture
 */
class WeeklyHrFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'cost_centre_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'permanent_hrs' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '11,2', 'unsigned' => false),
		'casual_hrs' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '11,2', 'unsigned' => false),
		'week_ending_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'cost_centre_id' => 1,
			'permanent_hrs' => '',
			'casual_hrs' => '',
			'week_ending_id' => 1
		),
	);

}
