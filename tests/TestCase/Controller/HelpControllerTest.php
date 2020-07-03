<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\HelpController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Application;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\HelpController Test Case
 *
 * @uses \App\Controller\HelpController
 */
class HelpControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function authMe($userId)
    {
        $users = TableRegistry::get('Users');
        $user = $users->get($userId);
        $this->session(['Auth' => $user]);
    }



    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Help',
        'app.Users',
        'app.Settings'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->authMe(2);
        $this->get(['controller' => 'Help', 'action' => 'index']);
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->authMe(2);
        $this->get(['controller' => 'Help', 'action' => 'view', 7]);
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdminUserAddOK(): void
    {
        $this->authMe(1);
        $this->enableCsrfToken();
        //$this->disableErrorHandlerMiddleware();
        $this->get(['controller' => 'Help', 'action' => 'add']);
        $this->assertResponseOk(); // 302 to auth
    }


    /**
     * Test add method
     *
     * @return void
     */
    public function testUserAdd(): void
    {
        $this->authMe(2);
        $this->enableCsrfToken();
        //$this->disableErrorHandlerMiddleware();
        $this->get(['controller' => 'Help', 'action' => 'add']);
        $this->assertRedirectEquals([
            'controller' => 'Users',
            'action' => 'access-denied',
            '?' => [
                'redirect' => '/help/add'
            ]
        ]);
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->authMe(2);

        $this->get(['controller' => 'Help', 'action' => 'edit', 7]);

        $this->assertRedirectEquals([
            'controller' => 'Users',
            'action' => 'access-denied',
            '?' => [
                'redirect' => '/help/edit/7'
            ]
        ]);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
