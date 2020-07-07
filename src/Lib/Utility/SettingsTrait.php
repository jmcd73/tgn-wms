<?php

declare(strict_types=1);

namespace App\Lib\Utility;

use App\Lib\Exception\MissingConfigurationException;
use Cake\ORM\TableRegistry;

trait SettingsTrait
{


    public function getSettingsTable($tableName = 'Settings')
    {
        return TableRegistry::getTableLocator()->get($tableName);
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

        return $this->getSettingFormatted($setting);
    }

    /**
     * 
     * @param mixed $setting 
     * @return mixed 
     */
    public function getSettingFormatted($setting)
    {

        if ($setting->setting_in_comment) {
            $setting = explode(PHP_EOL, $setting->comment);
            $setting = array_values(array_filter($setting, function ($line) {
                return !preg_match('/(^\s*#|^$)/', $line);
            }));
        } else {
            $setting = $setting->setting;
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
    public function addressParse(array $addresses): array
    {

        $add = [];
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
