<?php
/**
 * Item Fixture
 */
class ItemFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'trade_unit' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 14, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pack_size_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'product_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'consumer_unit' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 14, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'brand' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'variant' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'unit_net_contents' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'unit_of_measure' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'days_life' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'min_days_life' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
		'item_comment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'print_template_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'carton_label_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 1)
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
			'active' => 1,
			'code' => 'Lorem ip',
			'description' => 'Lorem ipsum dolor sit amet',
			'quantity' => 1,
			'trade_unit' => 'Lorem ipsum ',
			'pack_size_id' => 1,
			'product_type_id' => 1,
			'consumer_unit' => 'Lorem ipsum ',
			'brand' => 'Lorem ipsum dolor sit amet',
			'variant' => 'Lorem ipsum dolor sit amet',
			'unit_net_contents' => 1,
			'unit_of_measure' => 'Lo',
			'days_life' => 1,
			'min_days_life' => 1,
			'item_comment' => 'Lorem ipsum dolor sit amet',
			'print_template_id' => 1,
			'carton_label_id' => 1
		),
	);

}
