<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'username' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'role' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'full_name' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'timezone' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'is_superuser' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
                'active' => true,
                'username' => 'admin@example.com',
                'password' => '$2y$10$0LTVyQjuSHxcnjRcddsXDOUvToKeXbVR3BsxVhXio8o9IsCpqRlOa',
                'role' => 'admin',
                'created' => null,
                'modified' => null,
                'full_name' => 'Example Admin',
                'timezone' => 'Australia/Melbourne',
                'is_superuser' => null,
            ],
            [
                'id' => 2,
                'active' => true,
                'username' => 'user@example.com',
                'password' => '$2y$10$K224qsnNHCoolaXVEkZU/.uPzX/YF3rmL2YG2RWrk2x1vC80LiwsK',
                'role' => 'user',
                'created' => null,
                'modified' => null,
                'full_name' => 'Example User',
                'timezone' => 'Australia/Melbourne',
                'is_superuser' => null,
            ],
            [
                'id' => 3,
                'active' => true,
                'username' => 'qa@example.com',
                'password' => '$2y$10$Jfo4mQBWINe35ZyzPCl/Be4KZrSzh.F5j02h3mRZuBkZiQ9a32tdy',
                'role' => 'qa',
                'created' => null,
                'modified' => null,
                'full_name' => 'Example QA',
                'timezone' => 'Australia/Melbourne',
                'is_superuser' => null,
            ],
            [
                'id' => 4,
                'active' => true,
                'username' => 'qty_editor@example.com',
                'password' => '$2y$10$42ZXuk5O34w84xL7GeKCq.RwjlYKMNgjby7pLmzYc3N8CWiHxmYJu',
                'role' => 'qty_editor',
                'created' => null,
                'modified' => null,
                'full_name' => 'Example Qty Editor',
                'timezone' => 'Australia/Melbourne',
                'is_superuser' => null,
            ],
        ];
        parent::init();
    }
}
