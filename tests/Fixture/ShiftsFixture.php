<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShiftsFixture
 */
class ShiftsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'shift_minutes' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'comment' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'for_prod_dt' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'start_time' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'stop_time' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'product_type_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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
                'id' => 1,
                'name' => 'Oil Day Shift',
                'shift_minutes' => 480,
                'comment' => 'Oil Day Shift',
                'created' => '2019-10-23 13:59:58',
                'modified' => '2020-06-22 14:50:45',
                'active' => true,
                'for_prod_dt' => false,
                'start_time' => '06:00:00',
                'stop_time' => '14:00:00',
                'product_type_id' => 3,
            ],
            [
                'id' => 2,
                'name' => 'Oil Afternoon Shift',
                'shift_minutes' => 480,
                'comment' => 'Oil Afternoon Shift',
                'created' => '2019-10-23 14:00:22',
                'modified' => '2020-06-22 14:50:49',
                'active' => true,
                'for_prod_dt' => false,
                'start_time' => '14:00:00',
                'stop_time' => '23:00:00',
                'product_type_id' => 3,
            ],
            [
                'id' => 3,
                'name' => 'Oil Night Shift',
                'shift_minutes' => 480,
                'comment' => 'Oil Night Shift',
                'created' => '2019-10-23 14:00:41',
                'modified' => '2020-06-22 14:50:55',
                'active' => true,
                'for_prod_dt' => false,
                'start_time' => '23:00:00',
                'stop_time' => '06:00:00',
                'product_type_id' => 3,
            ],
            [
                'id' => 4,
                'name' => 'Chilled Day Shift',
                'shift_minutes' => 720,
                'comment' => 'Chilled Day Shift',
                'created' => '2019-10-23 14:01:03',
                'modified' => '2020-06-19 16:43:32',
                'active' => false,
                'for_prod_dt' => false,
                'start_time' => '06:00:00',
                'stop_time' => '18:00:00',
                'product_type_id' => 2,
            ],
            [
                'id' => 5,
                'name' => 'Chilled Night Shift',
                'shift_minutes' => 720,
                'comment' => 'Chilled Night Shift',
                'created' => '2019-10-23 14:01:34',
                'modified' => '2020-06-19 16:43:37',
                'active' => false,
                'for_prod_dt' => false,
                'start_time' => '18:00:00',
                'stop_time' => '06:00:00',
                'product_type_id' => 2,
            ],
        ];
        parent::init();
    }
}
