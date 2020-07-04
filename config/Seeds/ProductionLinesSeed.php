<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * ProductionLines seed.
 */
class ProductionLinesSeed extends AbstractSeed
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
                'id' => 3,
                'active' => true,
                'printer_id' => 6,
                'name' => 'Line 1',
                'product_type_id' => 3,
            ],
        ];
        $table = $this->table('production_lines');
        
        $table->truncate();

        $table->insert($data)->save();
    }
}
