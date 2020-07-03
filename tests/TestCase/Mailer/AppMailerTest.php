<?php
declare(strict_types=1);

namespace App\Test\TestCase\Mailer;

use App\Mailer\AppMailer;
use Cake\TestSuite\TestCase;
use Cake\TestSuite\EmailTrait;
use Cake\ORM\TableRegistry;
use App\Lib\PrintLabels\Label;
use Cake\Event\Event;

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

    protected $fixtures = [
        'app.Pallets',
        'app.Settings'
    ];

    // in our WelcomeMailerTestCase class.
public function testSendMail()
{
    $appMailer = new AppMailer();

    $label = $this->createStub(Label::class);
    
    $label->method('getPdfOutFile')->willReturn(__DIR__ .  DS . '20200703151125-palletPrint.pdf');

    $label->method('getJobId')->willReturn("202007031510-testJobId");

    $attachment = $label->getJobId() . '.pdf';

    $toAddresses = [
        'james@toggen.com.au' => 'James McDonald'
    ];

    $emailBody = 'the body of an email';

    $subject = sprintf('Label - %s', $label->getJobId());

    $appMailer->send('sendLabelPdfAttachment', [ $label, $toAddresses, $emailBody ]);

    $this->assertMailSentTo(array_keys($toAddresses)[0]);

    $this->assertMailContainsHtml($emailBody);

    $this->assertMailContainsAttachment($attachment);

    $this->assertMailSentWith($subject, 'subject');
    
    $this->assertMailCount(1);

    $this->assertInstanceOf(Label::class, $label);
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
