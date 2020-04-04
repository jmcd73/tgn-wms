<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HelpFixture
 */
class HelpFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'help';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'controller_action' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'markdown_document' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'tgn-UQ' => ['type' => 'index', 'columns' => ['controller_action'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controller_action_UNIQUE' => ['type' => 'unique', 'columns' => ['controller_action'], 'length' => []],
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
                'controller_action' => 'Lorem ipsum dolor sit amet',
                'markdown_document' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
