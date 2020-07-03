<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductTypesFixture
 */
class ProductTypesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'inventory_status_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'location_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'storage_temperature' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'code_regex' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'code_regex_description' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'next_serial_number' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'serial_number_format' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'enable_pick_app' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'wait_hrs' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Time in hours to wait before allowing shipment', 'precision' => null, 'autoIncrement' => null],
        'enable_wait_hrs' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'batch_format' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'inventory_status_id' => 1,
                'location_id' => null,
                'name' => 'Chilled',
                'storage_temperature' => 'Chilled',
                'code_regex' => '/^20\\d{3}$/',
                'code_regex_description' => 'This chilled product code must start with a 20 and be 5 digits long',
                'active' => false,
                'next_serial_number' => 1,
                'serial_number_format' => 'C-%06d',
                'enable_pick_app' => true,
                'wait_hrs' => null,
                'enable_wait_hrs' => null,
                'batch_format' => null,
            ],
            [
                'id' => 3,
                'inventory_status_id' => null,
                'location_id' => 1,
                'name' => 'Oil',
                'storage_temperature' => 'Ambient',
                'code_regex' => '/^(\\w{2}\\d{3})$/',
                'code_regex_description' => 'Product start with OO and then 3 numbers (e.g. OO116)',
                'active' => true,
                'next_serial_number' => 149,
                'serial_number_format' => 'A%08d',
                'enable_pick_app' => false,
                'wait_hrs' => null,
                'enable_wait_hrs' => null,
                'batch_format' => 'YDDD',
            ],
        ];
        parent::init();
    }
}
