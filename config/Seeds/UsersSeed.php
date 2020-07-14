<?php

declare(strict_types=1);

use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
        // set passwords for the individual dev users in 
        // config/app_local.php
        // 
        // 'devPasswords' => [
        //     '<role>' => '<password>',
        // ]
        // 
        // .e.g. 
        // 
        // 'devPasswords' => [
        //     'admin' => 'pw1',
        //     'user' => 'pw2',
        //     'qa' => 'pw3',
        //     'qty_editor' => 'pw4'
        // ],
        // 
        $devPasswords = Configure::read('devPasswords');

        $data = [
            [
                'username' => 'admin@example.com',
                'active' => 1,
                'timezone' => 'Australia/Melbourne',
                'role' => 'admin',
                'password' => 'admin',
                'full_name' => "Example Admin",
                'is_superuser' => 1,
            ],
            [
                'username' => 'user@example.com',
                'active' => 1,
                'timezone' => 'Australia/Melbourne',
                'role' => 'user',
                'password' => 'user',
                'full_name' => "Example User"
            ],
            [
                'username' => 'qa@example.com',
                'active' => 1,
                'timezone' => 'Australia/Melbourne',
                'role' => 'qa',
                'password' => 'qa',
                'full_name' => "Example QA"
            ],
            [
                'username' => 'qty_editor@example.com',
                'active' => 1,
                'timezone' => 'Australia/Melbourne',
                'role' => 'qty_editor',
                'password' => 'qty_editor',
                'full_name' => "Example Qty Editor"
            ]
        ];

        foreach($data as $k => $d) {
            $data[$k]['password'] =  (new DefaultPasswordHasher())->hash($devPasswords[$d['role']]);
            $data[$k]['created'] = FrozenTime::now()->toDateTimeString();
            $data[$k]['modified'] = FrozenTime::now()->toDateTimeString();
        }

        $table = $this->table('users');
        $table->truncate();
        $table->insert($data)->save();
    }
}
