<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * InventoryStatuses seed.
 */
class InventoryStatusesSeed extends AbstractSeed
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
                'id' => 1,
                'perms' => 13,
                'name' => 'WAIT',
                'comment' => 'Stops shipment and allows time for QA processes',
                'allow_bulk_status_change' => true,
            ],
            [
                'id' => 2,
                'perms' => 13,
                'name' => 'HOLD',
                'comment' => 'Status applied if QA finds a problem or needs to delay shipment',
                'allow_bulk_status_change' => false,
            ],
            [
                'id' => 3,
                'perms' => 12,
                'name' => 'RETIPPED',
                'comment' => 'Product produced but not useable, To be recycled or sent to waste',
                'allow_bulk_status_change' => false,
            ],
        ];

        $table = $this->table('inventory_statuses');

        $table->truncate();
        
        $table->insert($data)->save();
    }
}
