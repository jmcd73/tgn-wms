<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PalletsController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Routing\Router;
use App\Test\TestCase\Lib\Framework\TestFrameworkTrait;

/**
 * App\Controller\PalletsController Test Case
 *
 * @uses \App\Controller\PalletsController
 */
class PalletsControllerTest extends TestCase
{
    use IntegrationTestTrait, TestFrameworkTrait;

    public function setUp(): void
    {
        $this->setOutPutDir();
        $this->cleanUpOutputDir();
    }
    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Pallets',
        'app.ProductionLines',
        'app.PrintTemplates',
        'app.Items',
        'app.Printers',
        'app.Locations',
        'app.Shipments',
        'app.InventoryStatuses',
        'app.ProductTypes',
        'app.Cartons',
        'app.Settings',
        'app.Help',
        'app.Users',
        'app.Shifts'
    ];

    public function authMe($userId = 1)
    {

        $users = TableRegistry::get('Users');

        $user = $users->get($userId);

        $this->session(['Auth' => $user]);
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

    public function testIndexAuthenticated(): void
    {
        // Set session data
        $this->authMe();
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
        $this->authMe();
        $this->get(['controller' => "Pallets", 'action' => 'add']);
        $this->assertResponseOk();
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
    public function testAuthedPalletPrintWithNoProductTypeID(): void
    {
        $this->authMe();

        $this->get(['controller' => 'Pallets', 'action' => 'palletPrint']);

        $this->assertResponseOk();

        $this->assertStringContainsString('Select a product type from the actions on the left', (string) $this->_response->getBody());
        $v = $this->viewVariable('viewVar');
    }


    public function testPalletPrint(): void
    {

        $settings = TableRegistry::getTableLocator()->get('Settings');

        $items = TableRegistry::getTableLocator()->get('Items');

        $itemId = 9;

        $setting = $settings->find()->where(['name' => 'SSCC_REF'])->first();
        $item = $items->get($itemId);

        $this->authMe();

        $this->enableCsrfToken();

        $this->post(
            ['controller' => 'Pallets', 'action' => 'palletPrint', 3],
            [
                'left-refer' => '/pallets/pallet-print/3',
                'formName' => 'left',
                'left-item' => $itemId,
                'left-production_line' => 3,
                'left-productType' => 3,
                'left-part_pallet-left' => 0,
                'left-batch_no' => '0183'
            ]
        );



        $this->assertResponseOk();
        $body = (string) $this->_response->getBody();

        # has created label
        $this->assertStringContainsString('Pallet labels for', $body);

        # correct ref
        $this->assertStringContainsString($setting->setting, $body);

        $fileName = $this->checkForPdfPrintOutput($this->outputDir, '.*\.pdf');
        $contents = $this->getContents($fileName);

        $this->assertContains($item->variant, $contents);
        $this->assertContains($item->code, $contents);
        $this->assertContains($item->brand, $contents);
        $this->assertContains($item->batch, $contents);
    }


    /**
     * Test add method
     *
     * @return void
     */
    public function testAuthenticatedPalletPrintWithProductType(): void
    {
        $this->authMe();
        $this->get(['controller' => 'Pallets', 'action' => 'palletPrint', 3]);

        $this->assertResponseOk();
        $this->assertStringContainsString('Print Oil Pallet Labels', (string) $this->_response->getBody());
    }

    public function testLookupLimit()
    {
        $this->authMe(1);
        $this->get([
            'controller' => 'Pallets', 'action' => 'Lookup',

            '?' => [
                'limit' => 5
            ]
        ]);

        $this->assertStringContainsString('showing 5 record(s)', (string) $this->_getBodyAsString());
    }


    public function testShiftReportNullSubmit()
    {
        $this->authMe(1);
        $this->enableCsrfToken();
        $this->post(
            ['controller' => 'Pallets', 'action' => 'shiftReport'],
            [
                'start_date' => null
            ]
        );

        $this->assertResponseOk();
    }
}
