<?php
declare(strict_types=1);

namespace App\Test\TestCase\Mailer;

use App\Mailer\AppMailer;
use Cake\TestSuite\TestCase;
use Cake\TestSuite\EmailTrait;

/**
 * App\Mailer\AppMailer Test Case
 */
class AppMailerTest extends TestCase
{
 
    use EmailTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->loadRoutes();
    }


    // in our WelcomeMailerTestCase class.
public function testSendMail()
{
    $user = new User([
        'name' => 'Alice Alittea',
        'email' => 'alice@example.org',
    ]);
    $mailer = new WelcomeMailer();
    $mailer->send('welcome', [$user]);

    $this->assertMailSentTo($user->email);
    $this->assertMailContainsText('Hi ' . $user->name);
    $this->assertMailContainsText('Welcome to CakePHP!');
}

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
     * Test getTable method
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
