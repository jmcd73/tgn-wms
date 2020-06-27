<?php

use PHPUnit\Framework\TestCase;
use App\Lib\Utility\SettingsTrait;

class SettingsTraitTest extends TestCase
{
    use SettingsTrait;

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
}
