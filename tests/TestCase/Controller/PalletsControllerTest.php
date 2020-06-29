<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PalletsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Routing\Router;

/**
 * App\Controller\PalletsController Test Case
 *
 * @uses \App\Controller\PalletsController
 */
class PalletsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Pallets',
        'app.ProductionLines',
        'app.Items',
        'app.Printers',
        'app.Locations',
        'app.Shipments',
        'app.InventoryStatuses',
        'app.ProductTypes',
        'app.Cartons',
        'app.Settings'
    ];

    public function authMe() {
          // Set session data
          $this->session([
            'Auth' => [
                'User' => [
                    'id' => 6,
                    'username' => 'admin@example.com',
                    // must be admin
                    // other keys.
                ]
            ]
        ]);
    }
    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testAddUnauthenticatedFails(): void
    {
        // No session data set.
        $this->get('/pallets/index');
        //debug(Router::url(null, true));
        $this->assertRedirectEquals(['controller' => 'Users', 'action' => 'login', '?' => [
            "redirect" => '/pallets/index'
        ]]);
    }

    public function testAddAuthenticated(): void
    {
        // Set session data
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 6,
                    'username' => 'admin@example.com',
                    // must be admin
                    // other keys.
                ]
            ]
        ]);
        $this->get('/pallets/index');

        $this->assertResponseOk();
        // Other assertions.
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
        $this->markTestIncomplete('Not implemented yet.');
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


     /**
     * Test add method
     *
     * @return void
     */
    public function testUnAuthenticatedPalletPrint(): void
    {
        $this->get(['controller' => 'Pallets', 'action' => 'palletPrint']);
        $this->assertRedirectEquals(['controller' => 'Users', 'action' => 'login', '?' => [
            "redirect" => '/pallets/pallet-print'
        ]]);
    }


     /**
     * Test add method
     *
     * @return void
     */
    public function testAuthenticatedPalletPrintWithNoProductType(): void
    {
        $this->authMe();
        $this->get(['controller' => 'Pallets', 'action' => 'palletPrint']);
        
        $this->assertResponseOk();
        $this->assertStringContainsString('Select a product type from the actions on the left', (string)$this->_response->getBody());
    }



     /**
     * Test add method
     *
     * @return void
     */
    public function testAuthenticatedPalletPrintWithProductType(): void
    {
        $this->authMe();
        $this->get(['controller' => 'Pallets', 'action' => 'palletPrint',3 ]);
        
        $this->assertResponseOk();
        $this->assertStringContainsString('Print Oil Pallet Labels', (string)$this->_response->getBody());
    }


}
