<?php

use PHPUnit\Framework\TestCase;
use App\Lib\Utility\SettingsTrait;

class SettingsTraitTest extends TestCase
{
    use SettingsTrait;

    protected $fixtures = ['app.Settings'];

    public function testGetCommentSetting()
    {
        $expected = [
            'James McDonald <james@toggen.com.au>',
            'Lisa McDonald <lisa@toggen.com.au>'
        ];
        $setting = $this->getSetting('EMAIL_PALLET_LABEL_TO');
      
        $this->assertEquals($expected, $setting, "Should return an array");
    }

    public function testGetSetting()
    {
        $expected = 'files/templates-glabels-3';

        $setting = $this->getSetting('TEMPLATE_ROOT');

        $this->assertEquals($expected, $setting, "Should return " . $expected);
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
        
        
        $actual = $this->addressParse($input);

        $this->assertEquals($expected, $actual);

    }


       /**
     * Test sendLabel method
     *
     * @return void
     */
    public function testEmptyEmail(): void
    {
        $input = [ '# bogus no email address' , 'anothernotanemail' ];
        $expected = [];

        $actual = $this->addressParse($input);

        $this->assertEquals($expected, $actual);

    }
}
