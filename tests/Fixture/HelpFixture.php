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
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
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
                'controller_action' => 'Pallets::palletPrint',
                'markdown_document' => 'PALLET_PRINT.md',
            ],
            [
                'id' => 2,
                'controller_action' => 'Shipments::addShipment',
                'markdown_document' => 'ADD_APP.md',
            ],
            [
                'id' => 3,
                'controller_action' => 'Shipments::index',
                'markdown_document' => 'DISPATCH_INDEX.md',
            ],
            [
                'id' => 4,
                'controller_action' => 'Help::index',
                'markdown_document' => 'HELP_INDEX.md',
            ],
            [
                'id' => 6,
                'controller_action' => 'Pages::display',
                'markdown_document' => 'HOME.md',
            ],
            [
                'id' => 7,
                'controller_action' => 'Settings::index',
                'markdown_document' => 'SETTINGS.md',
            ],
            [
                'id' => 8,
                'controller_action' => 'Menus::index',
                'markdown_document' => 'MENUS.md',
            ],
        ];
        parent::init();
    }
}
