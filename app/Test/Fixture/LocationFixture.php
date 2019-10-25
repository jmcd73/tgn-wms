<?php
/**
 * Location Fixture
 */
class LocationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'location' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'pallet_capacity' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'is_hidden' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'product_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'overflow' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'location' => 'Lorem ipsum dolor ',
			'pallet_capacity' => 1,
			'is_hidden' => 1,
			'description' => 'Lorem ipsum dolor sit amet',
			'created' => '2019-10-25 20:16:45',
			'modified' => '2019-10-25 20:16:45',
			'product_type_id' => 1,
			'overflow' => 1
		),
	);

}
