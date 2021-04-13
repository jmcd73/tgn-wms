<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * ProductTypes seed.
 */
class ProductTypesSeed extends AbstractSeed
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
        $data = [
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
                'code_regex' => '/^(\\w{2,}\\d{2,})$/',
                'code_regex_description' => 'Product start with 2 or more letters and then 2 or more numbers (e.g. XU08, DUC123)',
                'active' => true,
                'next_serial_number' => 149,
                'serial_number_format' => 'A%08d',
                'enable_pick_app' => false,
                'wait_hrs' => null,
                'enable_wait_hrs' => null,
                'batch_format' => 'YDDD',
            ],
        ];

        $table = $this->table('product_types');

        $table->truncate();
        $table->insert($data)->save();
    }
}
