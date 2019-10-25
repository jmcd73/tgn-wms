<?php
/**
 * PrintTemplate Fixture
 */
class PrintTemplateFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'text_template' => array('type' => 'binary', 'null' => true, 'default' => null),
		'file_template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'is_file_template' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'unsigned' => false),
		'print_action' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'example_image' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'file_template_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'file_template_size' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'example_image_size' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'example_image_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show_in_label_chooser' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name_UNIQUE' => array('column' => 'name', 'unique' => 1)
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
			'description' => 'Lorem ipsum dolor sit amet',
			'text_template' => 'Lorem ipsum dolor sit amet',
			'file_template' => 'Lorem ipsum dolor sit amet',
			'active' => 1,
			'is_file_template' => 1,
			'print_action' => 'Lorem ipsum dolor sit amet',
			'created' => '2019-10-25 20:16:45',
			'modified' => '2019-10-25 20:16:45',
			'example_image' => 'Lorem ipsum dolor sit amet',
			'file_template_type' => 'Lorem ipsum dolor sit amet',
			'file_template_size' => 1,
			'example_image_size' => 1,
			'example_image_type' => 'Lorem ipsum dolor sit amet',
			'show_in_label_chooser' => 1,
			'parent_id' => 1,
			'lft' => 1,
			'rght' => 1
		),
	);

}
