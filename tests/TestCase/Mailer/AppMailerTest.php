<?php
declare(strict_types=1);

namespace App\Test\TestCase\Mailer;

use App\Mailer\AppMailer;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\AppMailer Test Case
 */
class AppMailerTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Mailer\AppMailer
     */
    protected $AppMailer;

    /**
     * Test implementedEvents method
     *
     * @return void
     */
    public function testImplementedEvents(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendLabel method
     *
     * @return void
     */
    public function testSendLabel(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

       /**
     * Test sendLabel method
     *
     * @return void
     */
    public function testEmptyEmail(): void
    {
        
    }

    /**
     * Test addressParse method
     *
     * @return void
     */
    public function testAddressParse(): void
    {

        $input = [
            'James McDonald <james@toggen.com.au>',
            'Lisa McDonald <lisa@toggen.com.au>'
        ];

        $expected = [
            'james@toggen.com.au' => 'James McDonald' ,
            'lisa@toggen.com.au' => 'Lisa McDonald'
        ];
        
        $mailer = new AppMailer();
        
        $actual = $mailer->addressParse($input);

        $this->assertEquals($expected, $actual);

    }

    /**
     * Test getSettingsTable method
     *
     * @return void
     */
    public function testGetSettingsTable(): void
    {

        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSetting method
     *
     * @return void
     */
    public function testGetSetting(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSettingFormatted method
     *
     * @return void
     */
    public function testGetSettingFormatted(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
