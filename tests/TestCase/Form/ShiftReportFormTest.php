<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\ShiftReportForm;

use Cake\TestSuite\TestCase;

/**
 * App\Form\ShiftReportForm Test Case
 */
class ShiftReportFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\ShiftReportForm
     */
    protected $ShiftReport;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->ShiftReport = new ShiftReportForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ShiftReport);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
