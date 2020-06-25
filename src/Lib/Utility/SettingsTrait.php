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
     * @param  bool   $inComment   some settings are stored in the comment field as they have CR or JSON
     * @return string string 
     */
    public function getSetting($settingName, bool $inComment = false): string
    {
        try {
            $setting = $this->getSettingsTable()->find()->where(['name' => $settingName])->firstOrFail();
        } catch (\Throwable $th) {
            throw new MissingConfigurationException('Setting missing ' . $settingName );
        }
        

        $setting = $setting->toArray();

        $this->settingId = $setting['id'];

        $slug = $inComment ? 'comment' : 'setting';

        // if it's an array then return the setting otherwise empty string

        return is_array($setting) ? $setting[$slug] : '';
    }


}