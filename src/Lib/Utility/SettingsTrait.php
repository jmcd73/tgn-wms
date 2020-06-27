<?php
declare(strict_types=1);

namespace App\Lib\Utility;

use App\Lib\Exception\MissingConfigurationException;
use Cake\ORM\TableRegistry;

trait SettingsTrait {


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
            throw new MissingConfigurationException('Setting missing ' . $settingName );
        }
        
        $this->settingId = $setting->id;

        return $this->getSettingFormatted($setting);
    }

    /**
     * 
     * @param mixed $setting 
     * @return mixed 
     */
    public function getSettingFormatted($setting) {

        if($setting->setting_in_comment) {
            $setting = explode("\r\n", $setting->comment);
            $setting = array_values(array_filter($setting, function($line) {
                return ! preg_match('/^\s*#/', $line);
            }));

        } else { 
            $setting = $setting->setting;
        }
        return $setting;
    }


}