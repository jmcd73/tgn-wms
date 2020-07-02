<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InventoryStatusesFixture
 */
class InventoryStatusesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'perms' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'allow_bulk_status_change' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
        parent::init();
    }
}
