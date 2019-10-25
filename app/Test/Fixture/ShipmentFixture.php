<?php
/**
 * Shipment Fixture
 */
class ShipmentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'operator_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'truck_registration_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'shipper' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'con_note' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'product_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'destination' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'label_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'shipped' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'time_start' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'time_finish' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'time_total' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'truck_temp' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false),
		'dock_temp' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false),
		'product_temp' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'operator_id' => 1,
			'truck_registration_id' => 1,
			'shipper' => 'Lorem ipsum dolor sit amet',
			'con_note' => 'Lorem ipsum dolor sit amet',
			'product_type_id' => 1,
			'destination' => 'Lorem ipsum dolor sit amet',
			'label_count' => 1,
			'shipped' => 1,
			'time_start' => '2019-10-25 20:16:46',
			'time_finish' => '2019-10-25 20:16:46',
			'time_total' => 1,
			'truck_temp' => 1,
			'dock_temp' => 1,
			'product_temp' => 1,
			'created' => '2019-10-25 20:16:46',
			'modified' => '2019-10-25 20:16:46'
		),
	);

}
