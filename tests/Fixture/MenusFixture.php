<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MenusFixture
 */
class MenusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    //public $table = 'menus';
    
    public $import = ['table' => 'settings'];

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
                'active' => 1,
                'divider' => 1,
                'header' => 1,
                'admin_menu' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'options' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'parent_id' => 1,
                'lft' => 1,
                'rght' => 1,
                'modified' => '2020-03-31 12:07:28',
                'created' => '2020-03-31 12:07:28',
                'bs_url' => 'Lorem ipsum dolor sit amet',
                'extra_args' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
