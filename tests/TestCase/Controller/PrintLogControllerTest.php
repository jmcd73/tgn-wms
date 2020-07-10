<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PrintLogController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Test\TestCase\Lib\Framework\TestFrameworkTrait;

/**
 * App\Controller\PrintLogController Test Case
 *
 * @uses \App\Controller\PrintLogController
 */
class PrintLogControllerTest extends TestCase
{
    use IntegrationTestTrait, TestFrameworkTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Settings',
        'app.Users',
        'app.PrintTemplates',
        'app.Printers',
        'app.PrintLog'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
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
     * Test dayOfYear method
     *
     * @return void
     */
    public function testDayOfYear(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test labelChooser method
     *
     * @return void
     */
    public function testLabelChooser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test completed method
     *
     * @return void
     */
    public function testCompleted(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test printCartonLabels method
     *
     * @return void
     */
    public function testPrintCartonLabels(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test cartonPrint method
     *
     * @return void
     */
    public function testCartonPrint(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test crossdockLabels method
     *
     * @return void
     */
    public function testCrossdockLabels(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test shippingLabels method
     *
     * @return void
     */
    public function testShippingLabels(): void
    {
        $this->AuthMe();
        $this->enableCsrfToken();

        $data = [
            'printer' => 6,
            'copies' => 1,
            'sequence-start' => 1,
            'sequence-end' => 10,
            'state' => 'VICTORIA',
            'address' => 'U 2  38 EASTFIELD RD',
            'reference' => 'SO-12345890'
        ];

        $this->post(
            [
                'controller' => 'PrintLog',
                'action' => 'shippingLabels'
            ],
            $data
        );

        $this->assertRedirectContains('/print-labels/completed');
    }

    /**
     * Test shippingLabelsGeneric method
     *
     * @return void
     */
    public function testShippingLabelsGeneric(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test keepRefrigerated method
     *
     * @return void
     */
    public function testKeepRefrigerated(): void
    {
        $this->authMe();
        $this->enableCsrfToken();
        $data = [
            'printer' => 6,
            'copies' => 4
        ];

        $this->post(array('controller' => 'PrintLog', 'action' => 'keepRefrigerated'), $data);
        //$this->assertResponseOk();
        $this->assertRedirectContains('/print-labels/completed');
    }

    /**
     * Test glabelSampleLabels method
     *
     * @return void
     */
    public function testGlabelSampleLabels(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test bigNumber method
     *
     * @return void
     */
    public function testBigNumber(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test customPrint method
     *
     * @return void
     */
    public function testCustomPrint(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sampleLabels method
     *
     * @return void
     */
    public function testSampleLabels(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test ssccLabel method
     *
     * @return void
     */
    public function testSsccLabel(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test palletLabelReprint method
     *
     * @return void
     */
    public function testPalletLabelReprint(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
