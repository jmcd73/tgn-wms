<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Shifts seed.
 */
class ShiftsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data =  [
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
        $table = $this->table('shifts');

        $table->truncate();
        
        $table->insert($data)->save();
    }
}
