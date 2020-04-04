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
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'production_line_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'item' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'best_before' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'bb_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'gtin14' => ['type' => 'string', 'length' => 14, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'qty_user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qty' => ['type' => 'integer', 'length' => 5, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qty_previous' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'qty_modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'pl_ref' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'sscc' => ['type' => 'string', 'length' => 18, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'batch' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'printer' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'printer_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'print_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'cooldown_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'min_days_life' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'production_line' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'location_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'shipment_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inventory_status_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inventory_status_note' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'inventory_status_datetime' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'ship_low_date' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'picked' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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
                'production_line_id' => 1,
                'item' => 'Lorem ip',
                'description' => 'Lorem ipsum dolor sit amet',
                'item_id' => 1,
                'best_before' => 'Lorem ip',
                'bb_date' => '2020-03-31',
                'gtin14' => 'Lorem ipsum ',
                'qty_user_id' => 1,
                'qty' => 1,
                'qty_previous' => 'Lorem ipsum dolor sit amet',
                'qty_modified' => '2020-03-31 12:07:31',
                'pl_ref' => 'Lorem ip',
                'sscc' => 'Lorem ipsum dolo',
                'batch' => 'Lore',
                'printer' => 'Lorem ipsum dolor sit amet',
                'printer_id' => 1,
                'print_date' => '2020-03-31 12:07:31',
                'cooldown_date' => '2020-03-31 12:07:31',
                'min_days_life' => 1,
                'production_line' => 'Lorem ipsum dolor sit amet',
                'location_id' => 1,
                'shipment_id' => 1,
                'inventory_status_id' => 1,
                'inventory_status_note' => 'Lorem ipsum dolor sit amet',
                'inventory_status_datetime' => '2020-03-31 12:07:31',
                'created' => '2020-03-31 12:07:31',
                'modified' => '2020-03-31 12:07:31',
                'ship_low_date' => 1,
                'picked' => 1,
                'product_type_id' => 1,
            ],
        ];
        parent::init();
    }
}
