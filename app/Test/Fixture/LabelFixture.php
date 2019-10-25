<?php
/**
 * Label Fixture
 */
class LabelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'production_line_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'item' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'item_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'best_before' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bb_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'gtin14' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 14, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'qty_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'qty' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'unsigned' => false, 'key' => 'index'),
		'qty_previous' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'qty_modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'pl_ref' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sscc' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 18, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'batch' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'printer_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'print_date' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'cooldown_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'min_days_life' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'production_line' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'location_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'shipment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'inventory_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'inventory_status_note' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inventory_status_datetime' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'ship_low_date' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'picked' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'product_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'pl_ref' => array('column' => 'pl_ref', 'unique' => 1),
			'sscc' => array('column' => 'sscc', 'unique' => 1),
			'item' => array('column' => 'item', 'unique' => 0),
			'item_id' => array('column' => 'item_id', 'unique' => 0),
			'description' => array('column' => 'description', 'unique' => 0),
			'print_date' => array('column' => array('print_date', 'bb_date'), 'unique' => 0),
			'bb_date' => array('column' => 'bb_date', 'unique' => 0),
			'batch' => array('column' => 'batch', 'unique' => 0),
			'qty' => array('column' => 'qty', 'unique' => 0),
			'item_id_desc' => array('column' => 'item_id', 'unique' => 0),
			'print_date_desc' => array('column' => 'print_date', 'unique' => 0),
			'qty_desc' => array('column' => 'qty', 'unique' => 0),
			'bb_date_desc' => array('column' => 'bb_date', 'unique' => 0),
			'location_id' => array('column' => 'location_id', 'unique' => 0),
			'location_id_desc' => array('column' => 'location_id', 'unique' => 0),
			'shipment_id' => array('column' => 'shipment_id', 'unique' => 0),
			'shipment_id_desc' => array('column' => 'shipment_id', 'unique' => 0)
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
			'production_line_id' => 1,
			'item' => 'Lorem ip',
			'description' => 'Lorem ipsum dolor sit amet',
			'item_id' => 1,
			'best_before' => 'Lorem ip',
			'bb_date' => '2019-10-25',
			'gtin14' => 'Lorem ipsum ',
			'qty_user_id' => 1,
			'qty' => 1,
			'qty_previous' => 'Lorem ipsum dolor sit amet',
			'qty_modified' => '2019-10-25 20:16:44',
			'pl_ref' => 'Lorem ipsum dolor ',
			'sscc' => 'Lorem ipsum dolo',
			'batch' => 'Lore',
			'printer_id' => 'Lorem ipsum dolor sit amet',
			'print_date' => '2019-10-25 20:16:44',
			'cooldown_date' => '2019-10-25 20:16:44',
			'min_days_life' => 1,
			'production_line' => 'Lorem ipsum dolor sit amet',
			'location_id' => 1,
			'shipment_id' => 1,
			'inventory_status_id' => 1,
			'inventory_status_note' => 'Lorem ipsum dolor sit amet',
			'inventory_status_datetime' => '2019-10-25 20:16:44',
			'created' => '2019-10-25 20:16:44',
			'modified' => '2019-10-25 20:16:44',
			'ship_low_date' => 1,
			'picked' => 1,
			'product_type_id' => 1
		),
	);

}
