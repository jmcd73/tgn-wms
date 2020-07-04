<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Help seed.
 */
class HelpSeed extends AbstractSeed
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

        $table = $this->table('help');

        $table->truncate();
        
        $table->insert($data)->save();
    }
}
