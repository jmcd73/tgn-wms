<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * PackSizes seed.
 */
class PackSizesSeed extends AbstractSeed
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
                'pack_size' => '2L',
                'comment' => '2 Litre',
                'created' => '2020-06-19 16:51:56',
                'modified' => '2020-06-19 16:51:56',
            ],
            [
                'id' => 2,
                'pack_size' => '750ML',
                'comment' => '750 ML',
                'created' => '2020-06-21 18:16:50',
                'modified' => '2020-06-21 18:17:52',
            ],
            [
                'id' => 3,
                'pack_size' => '375ML',
                'comment' => '375 ML',
                'created' => '2020-06-21 18:17:02',
                'modified' => '2020-06-21 18:17:57',
            ],
            [
                'id' => 4,
                'pack_size' => '4L',
                'comment' => '4 Litre',
                'created' => '2020-06-21 18:17:11',
                'modified' => '2020-06-21 18:17:11',
            ],
            [
                'id' => 5,
                'pack_size' => '1L',
                'comment' => '1 Litre',
                'created' => '2020-06-21 18:18:21',
                'modified' => '2020-06-21 18:18:21',
            ],
        ];

        $table = $this->table('pack_sizes');
        $table->truncate();
        $table->insert($data)->save();
    }
}
