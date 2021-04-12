<?php

declare(strict_types=1);

namespace App\Lib\Utility;

use App\Lib\Exception\MissingConfigurationException;
use Cake\Log\LogTrait;
use Cake\ORM\Locator\LocatorAwareTrait;


trait SettingsTrait
{
    use LocatorAwareTrait, LogTrait;

    public function getSettingsTable($tableName = 'Settings')
    {
        return $this->getTableLocator()->get($tableName);
    }

    /**
     * @param  string $settingName the name of the setting in the settings.setting field of the db
     * @return mixed string 
     */
    public function getSetting($settingName)
    {
       try {
            $setting = $this->getSettingsTable()->find()->where(['name' => $settingName])->firstOrFail();
       } catch (\Throwable $th) {
           throw new MissingConfigurationException('Setting missing ' . $settingName);
       }

        $this->settingId = $setting->id;

        return $this->stripCommentsFromSetting($setting);
    }

  
    /**
     * stripCommentsFromSetting
     *
     * @param  mixed $setting
     * @return void
     */
    public function stripCommentsFromSetting($setting)
    {
        $setting = $setting->setting;
        tog($setting);
         if (strstr($setting, PHP_EOL) !== false) {

            $setting = explode(PHP_EOL, $setting);
            $setting = array_values(array_filter($setting, function ($line) {
                return !preg_match('/(^\s*#|^$)/', $line);
            }));

            $setting = implode("\n", $setting);
        }

        return $setting;
    }

    /**
     * addressParse returns either an empty array or email addresses formatted
     * for the Mailer::setTo()
     * e.g. [ 'james@toggen.com.au' => "James McDonald" , 'example@example.com' => "Example Email" ]
     * 
     * @param array $addresses 
     * @return array 
     */
    public function addressParse($addresses): array
    {

        $add = [];
        $addresses = explode("\n", $addresses);
        
        foreach ($addresses as $addressLine) {
            $add = array_merge($add, mailparse_rfc822_parse_addresses($addressLine));
        }

        $formatted = [];

        foreach ($add as $a) {
            if (filter_var($a['address'], FILTER_VALIDATE_EMAIL)) {
                $formatted[$a['address']] = $a['display'];
            }
        }

        return $formatted;
    }
}
