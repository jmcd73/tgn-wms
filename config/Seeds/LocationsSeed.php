<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Locations seed.
 */
class LocationsSeed extends AbstractSeed
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
                'location' => 'B-1',
                'pallet_capacity' => 99999999,
                'is_hidden' => false,
                'description' => 'Bottling',
                'created' => '2020-06-19 16:38:54',
                'modified' => '2020-06-22 19:17:10',
                'product_type_id' => 3,
            ],
        ];

        $table = $this->table('locations');

        $table->truncate();

        $table->insert($data)->save();
    }
}
