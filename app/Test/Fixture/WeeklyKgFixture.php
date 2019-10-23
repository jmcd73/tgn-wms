<?php
/**
 * WeeklyKg Fixture
 */
class WeeklyKgFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'report_pack_size_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'entered' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'converted' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '11,2', 'unsigned' => false),
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
			'report_pack_size_id' => 1,
			'entered' => 1,
			'converted' => '',
			'week_ending_id' => 1
		),
	);

}
