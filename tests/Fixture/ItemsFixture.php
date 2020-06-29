<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemsFixture
 */
class ItemsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'code' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'quantity' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'trade_unit' => ['type' => 'string', 'length' => 14, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'pack_size_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_type_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'consumer_unit' => ['type' => 'string', 'length' => 14, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'brand' => ['type' => 'string', 'length' => 32, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'variant' => ['type' => 'string', 'length' => 32, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'unit_net_contents' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unit_of_measure' => ['type' => 'string', 'length' => 4, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'days_life' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'min_days_life' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'item_comment' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'pallet_template_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'carton_template_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pallet_label_copies' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'item_wait_hrs' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Wait hours is set at product type level but can be set to individual time per item or disabled with item_wait_hrs 0', 'precision' => null, 'autoIncrement' => null],
        'quantity_description' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'batch_format' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'code' => ['type' => 'unique', 'columns' => ['code'], 'length' => []],
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
                'id' => 2,
                'active' => true,
                'code' => 'OO116',
                'description' => '6x750ML The All Rounder EVOO',
                'quantity' => 168,
                'trade_unit' => '19310175701106',
                'pack_size_id' => 2,
                'product_type_id' => 3,
                'consumer_unit' => '9310175701109',
                'brand' => 'Squeaky Gate',
                'variant' => 'The All Rounder EVOO',
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => 'Squeaky Gate first product',
                'pallet_template_id' => 73,
                'carton_template_id' => 5,
                'pallet_label_copies' => 1,
                'created' => '2020-06-21 18:14:48',
                'modified' => '2020-06-25 15:17:41',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 750ml',
                'batch_format' => 'YDDD',
            ],
            [
                'id' => 3,
                'active' => true,
                'code' => 'OO123',
                'description' => '6x375ML The All Rounder EVOO',
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 3,
                'product_type_id' => 3,
                'consumer_unit' => '',
                'brand' => 'Sneaky Gate',
                'variant' => 'The All Rounder EVOO',
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 73,
                'carton_template_id' => 5,
                'pallet_label_copies' => 1,
                'created' => '2020-06-21 18:20:26',
                'modified' => '2020-06-28 13:53:03',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 375ml',
                'batch_format' => 'YDDD',
            ],
            [
                'id' => 4,
                'active' => true,
                'code' => 'OO115',
                'description' => '6x750ML The Strong One EVOO',
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 2,
                'product_type_id' => 3,
                'consumer_unit' => '',
                'brand' => 'Squeaky Gate',
                'variant' => 'The Strong One EVOO',
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 2,
                'carton_template_id' => 5,
                'pallet_label_copies' => 1,
                'created' => '2020-06-21 22:56:38',
                'modified' => '2020-06-24 19:23:07',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 750ml',
                'batch_format' => 'YDDD',
            ],
            [
                'id' => 6,
                'active' => false,
                'code' => 'OO345',
                'description' => 'A descriptions to match',
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 3,
                'product_type_id' => 3,
                'consumer_unit' => '',
                'brand' => 'Sneaky Gate',
                'variant' => 'The All Rounder EVOO',
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 73,
                'carton_template_id' => 5,
                'pallet_label_copies' => 0,
                'created' => '2020-06-25 12:26:14',
                'modified' => '2020-06-25 15:18:57',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 375ml',
                'batch_format' => '',
            ],
            [
                'id' => 7,
                'active' => true,
                'code' => 'OO145',
                'description' => 'A better description',
                'quantity' => 168,
                'trade_unit' => '00000000000000',
                'pack_size_id' => 3,
                'product_type_id' => 3,
                'consumer_unit' => '0000000000000',
                'brand' => 'Sneaky Gate',
                'variant' => 'The All Rounder EVOO',
                'unit_net_contents' => 750,
                'unit_of_measure' => 'ML',
                'days_life' => 730,
                'min_days_life' => 200,
                'item_comment' => '',
                'pallet_template_id' => 61,
                'carton_template_id' => 5,
                'pallet_label_copies' => 0,
                'created' => '2020-06-29 11:47:10',
                'modified' => '2020-06-29 18:17:46',
                'item_wait_hrs' => null,
                'quantity_description' => '6 x 375ml',
                'batch_format' => '',
            ],
        ];
        parent::init();
    }
}
