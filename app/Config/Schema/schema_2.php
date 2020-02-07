<?php
class AppSchema extends CakeSchema
{
    public $file = 'schema_2.php';

    public function before($event = [])
    {
        return true;
    }

    public function after($event = [])
    {
    }

    public $cartons = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'pallet_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'],
        'count' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 3, 'unsigned' => false],
        'best_before' => ['type' => 'date', 'null' => true, 'default' => null],
        'production_date' => ['type' => 'date', 'null' => true, 'default' => null],
        'item_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'This is for future use if we decide to go with mixed pallets'],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'user_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'date_label_id' => ['column' => ['pallet_id', 'best_before'], 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $help = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'controller_action' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'markdown_document' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'controller_action_UNIQUE' => ['column' => 'controller_action', 'unique' => 1],
            'tgn-UQ' => ['column' => 'controller_action', 'unique' => 0],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $inventory_statuses = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'perms' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'comment' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $items = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'active' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'code' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'description' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'quantity' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'trade_unit' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 14, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'pack_size_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'product_type_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'consumer_unit' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 14, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'brand' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'variant' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'unit_net_contents' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'unit_of_measure' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'days_life' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'min_days_life' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false],
        'item_comment' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'print_template_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'carton_label_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'pallet_label_copies' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 1, 'unsigned' => false],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'code' => ['column' => 'code', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $locations = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'location' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'pallet_capacity' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'is_hidden' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'description' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'product_type_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $menus = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'active' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'divider' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'header' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'admin_menu' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'name' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'description' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'url' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 254, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'options' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 254, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'title' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'lft' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'rght' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'bs_url' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'extra_args' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $pack_sizes = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'pack_size' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'comment' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $pallets = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'inventory_status_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'item_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'],
        'location_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'],
        'description' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'item' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'best_before' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'bb_date' => ['type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'],
        'gtin14' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 14, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'qty' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'unsigned' => false, 'key' => 'index'],
        'qty_previous' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'qty_modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'pl_ref' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'sscc' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 18, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'batch' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'index', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'printer' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'print_date' => ['type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'],
        'cooldown_date' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'min_days_life' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'production_line' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'printer_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'product_type_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'qty_user_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'shipment_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'],
        'inventory_status_note' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'inventory_status_datetime' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'ship_low_date' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'picked' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'production_line_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'pl_ref' => ['column' => 'pl_ref', 'unique' => 1],
            'sscc' => ['column' => 'sscc', 'unique' => 1],
            'item' => ['column' => 'item', 'unique' => 0],
            'item_id' => ['column' => 'item_id', 'unique' => 0],
            'description' => ['column' => 'description', 'unique' => 0],
            'print_date' => ['column' => ['print_date', 'bb_date'], 'unique' => 0],
            'bb_date' => ['column' => 'bb_date', 'unique' => 0],
            'batch' => ['column' => 'batch', 'unique' => 0],
            'qty' => ['column' => 'qty', 'unique' => 0],
            'item_id_desc' => ['column' => 'item_id', 'unique' => 0],
            'print_date_desc' => ['column' => 'print_date', 'unique' => 0],
            'qty_desc' => ['column' => 'qty', 'unique' => 0],
            'bb_date_desc' => ['column' => 'bb_date', 'unique' => 0],
            'location_id' => ['column' => 'location_id', 'unique' => 0],
            'location_id_desc' => ['column' => 'location_id', 'unique' => 0],
            'shipment_id' => ['column' => 'shipment_id', 'unique' => 0],
            'shipment_id_desc' => ['column' => 'shipment_id', 'unique' => 0],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $print_log = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'print_data' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'print_action' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $print_templates = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'description' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'text_template' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 2000, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'file_template' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'active' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'is_file_template' => ['type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1, 'unsigned' => false],
        'print_action' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'example_image' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'file_template_type' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'file_template_size' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'example_image_size' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'example_image_type' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'show_in_label_chooser' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'lft' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'rght' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'replace_tokens' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 2000, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'name_UNIQUE' => ['column' => 'name', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $printers = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'active' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'name' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'options' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'queue_name' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'set_as_default_on_these_actions' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 2000, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'name_UNIQUE' => ['column' => 'name', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $product_types = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'inventory_status_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'active' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'code_prefix' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'storage_temperature' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'location_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'code_regex' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'code_regex_description' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'next_serial_number' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'serial_number_format' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'enable_pick_app' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $production_lines = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'active' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'printer_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'name' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'product_type_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'name_UNIQUE' => ['column' => 'name', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $settings = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'key' => 'unique', 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'setting' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'comment' => ['type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
            'name' => ['column' => 'name', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $shifts = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'shift_minutes' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'comment' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'active' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'for_prod_dt' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'start_time' => ['type' => 'time', 'null' => false, 'default' => null],
        'stop_time' => ['type' => 'time', 'null' => false, 'default' => null],
        'product_type_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $shipments = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'operator_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'truck_registration_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'shipper' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'con_note' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'shipment_type' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'destination' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'pallet_count' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false],
        'shipped' => ['type' => 'boolean', 'null' => false, 'default' => null],
        'time_start' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'time_finish' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'time_total' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'truck_temp' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false],
        'dock_temp' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false],
        'product_temp' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'product_type_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];

    public $users = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'],
        'username' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'password' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'role' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'active' => ['type' => 'boolean', 'null' => true, 'default' => null],
        'full_name' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1],
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB'],
    ];
}
