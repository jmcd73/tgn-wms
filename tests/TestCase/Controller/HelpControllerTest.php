<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\HelpController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

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

    public function authMe()
    {
        // Set session data
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'admin@example.com',
                    // must be admin
                    // other keys.
                ]
            ]
        ]);
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
        $this->authMe();
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
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->authMe();
        $this->enableCsrfToken();
        //$this->disableErrorHandlerMiddleware();

        $this->get(['controller' => 'Help', 'action' => 'add']);
       // $this->assertResponseOk(); 302 to auth
       $this->assertRedirectContains('/hi/james');
     
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
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
