<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PalletsFixture
 */
class PalletsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'production_line_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'production_line' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'item' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'item_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bb_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'gtin14' => ['type' => 'string', 'length' => 14, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'qty_user_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qty' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qty_previous' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'qty_modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'pl_ref' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'sscc' => ['type' => 'string', 'length' => 18, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'batch' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'printer' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'printer_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'print_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'cooldown_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'min_days_life' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'location_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'shipment_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inventory_status_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inventory_status_note' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'inventory_status_datetime' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'ship_low_date' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'picked' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_type_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_type_serial' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'pallet_label_filename' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'item' => ['type' => 'index', 'columns' => ['item'], 'length' => []],
            'item_id' => ['type' => 'index', 'columns' => ['item_id'], 'length' => []],
            'description' => ['type' => 'index', 'columns' => ['description'], 'length' => []],
            'print_date' => ['type' => 'index', 'columns' => ['print_date', 'bb_date'], 'length' => []],
            'bb_date' => ['type' => 'index', 'columns' => ['bb_date'], 'length' => []],
            'batch' => ['type' => 'index', 'columns' => ['batch'], 'length' => []],
            'qty' => ['type' => 'index', 'columns' => ['qty'], 'length' => []],
            'item_id_desc' => ['type' => 'index', 'columns' => ['item_id'], 'length' => []],
            'print_date_desc' => ['type' => 'index', 'columns' => ['print_date'], 'length' => []],
            'qty_desc' => ['type' => 'index', 'columns' => ['qty'], 'length' => []],
            'bb_date_desc' => ['type' => 'index', 'columns' => ['bb_date'], 'length' => []],
            'location_id' => ['type' => 'index', 'columns' => ['location_id'], 'length' => []],
            'location_id_desc' => ['type' => 'index', 'columns' => ['location_id'], 'length' => []],
            'shipment_id' => ['type' => 'index', 'columns' => ['shipment_id'], 'length' => []],
            'shipment_id_desc' => ['type' => 'index', 'columns' => ['shipment_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'pl_ref' => ['type' => 'unique', 'columns' => ['pl_ref'], 'length' => []],
            'sscc' => ['type' => 'unique', 'columns' => ['sscc'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'production_line_id' => 3,
                'production_line' => 'Line 1',
                'item' => 'XZ3',
                'description' => 'Heavy Duty Copper Gloves',
                'item_id' => 9,
                'bb_date' => '2022-07-02 00:00:00',
                'gtin14' => '10263910665852',
                'qty_user_id' => 0,
                'qty' => 39,
                'qty_previous' => '0',
                'qty_modified' => null,
                'pl_ref' => 'A00000146',
                'sscc' => '193529380000001467',
                'batch' => '0183',
                'printer' => 'PDF Printer',
                'printer_id' => 6,
                'print_date' => '2020-07-02 17:55:57',
                'cooldown_date' => '2020-07-02 17:55:57',
                'min_days_life' => 200,
                'location_id' => 1,
                'shipment_id' => 0,
                'inventory_status_id' => 0,
                'inventory_status_note' => '',
                'inventory_status_datetime' => null,
                'created' => '2020-07-02 17:55:58',
                'modified' => '2020-07-02 17:55:58',
                'ship_low_date' => false,
                'picked' => false,
                'product_type_id' => 3,
                'product_type_serial' => '146',
                'pallet_label_filename' => 'A00000146-0183-XZ3.pdf',
            ],
            [
                'id' => 2,
                'production_line_id' => 3,
                'production_line' => 'Line 1',
                'item' => 'XZ3',
                'description' => 'Heavy Duty Copper Gloves',
                'item_id' => 9,
                'bb_date' => '2022-07-02 00:00:00',
                'gtin14' => '10263910665852',
                'qty_user_id' => 0,
                'qty' => 39,
                'qty_previous' => '0',
                'qty_modified' => null,
                'pl_ref' => 'A00000147',
                'sscc' => '193529380000001474',
                'batch' => '0183',
                'printer' => 'PDF Printer',
                'printer_id' => 6,
                'print_date' => '2020-07-02 17:56:02',
                'cooldown_date' => '2020-07-02 17:56:02',
                'min_days_life' => 200,
                'location_id' => 1,
                'shipment_id' => 0,
                'inventory_status_id' => 0,
                'inventory_status_note' => '',
                'inventory_status_datetime' => null,
                'created' => '2020-07-02 17:56:03',
                'modified' => '2020-07-02 17:56:03',
                'ship_low_date' => false,
                'picked' => false,
                'product_type_id' => 3,
                'product_type_serial' => '147',
                'pallet_label_filename' => 'A00000147-0183-XZ3.pdf',
            ],
            [
                'id' => 3,
                'production_line_id' => 3,
                'production_line' => 'Line 1',
                'item' => 'XZ3',
                'description' => 'Heavy Duty Copper Gloves',
                'item_id' => 9,
                'bb_date' => '2022-07-02 00:00:00',
                'gtin14' => '10263910665852',
                'qty_user_id' => 0,
                'qty' => 39,
                'qty_previous' => '0',
                'qty_modified' => null,
                'pl_ref' => 'A00000148',
                'sscc' => '193529380000001481',
                'batch' => '0183',
                'printer' => 'PDF Printer',
                'printer_id' => 6,
                'print_date' => '2020-07-02 17:58:38',
                'cooldown_date' => '2020-07-02 17:58:38',
                'min_days_life' => 200,
                'location_id' => 1,
                'shipment_id' => 0,
                'inventory_status_id' => 0,
                'inventory_status_note' => '',
                'inventory_status_datetime' => null,
                'created' => '2020-07-02 17:58:39',
                'modified' => '2020-07-02 17:58:39',
                'ship_low_date' => false,
                'picked' => false,
                'product_type_id' => 3,
                'product_type_serial' => '148',
                'pallet_label_filename' => 'A00000148-0183-XZ3.pdf',
            ],
        ];
        parent::init();
    }
}
