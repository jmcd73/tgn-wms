<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PackSizesFixture
 */
class PackSizesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'pack_size' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
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
        parent::init();
    }
}
