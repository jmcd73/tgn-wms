<?php
/**
 * ReportPackSize Fixture
 */
class ReportPackSizeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'conv_factor' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,3', 'unsigned' => false),
		'comment' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort_order' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'cost_centre_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'disabled' => array('type' => 'boolean', 'null' => false, 'default' => null),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'type' => 'Lorem ip',
			'conv_factor' => '',
			'comment' => 'Lorem ipsum dolor sit amet',
			'sort_order' => 1,
			'cost_centre_id' => 1,
			'disabled' => 1
		),
	);

}
