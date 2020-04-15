<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\I18n\FrozenDate;
use Cake\I18n\Time;
use Cake\Log\LogTrait;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use DateTime;

/**
 * TgnUtils behavior
 */
class TgnUtilsBehavior extends Behavior
{
    use LogTrait;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     *  return array of batch numbers formatted for cakephp select options
     * $batch_nos = [
     *      601201 => '6012 - 01',
     *      601202 => '6012 - 02'
     *  ]
     * @return array Array of batch numbers
     */
    public function getBatchNumbers()
    {
        $now = Time::now();

        $batch_prefix = substr((string) $now->year, 3) . sprintf('%03d', $now->dayOfYear);

        for ($i = 1; $i <= 99; $i++) {
            $batch_nos[$batch_prefix . sprintf('%02d', $i)] = $batch_prefix . ' - ' . sprintf('%02d', $i);
        }

        return $batch_nos;
    }

    public function getSettingsTable($tableName = 'Settings')
    {
        return TableRegistry::getTableLocator()->get($tableName);
    }

    /**
     *
     * @param  string $settingname the name of the setting in the settings.setting field of the db
     * @param  bool   $inComment   some settings are stored in the comment field as they have CR or JSON
     * @return string
     */
    public function getSetting($settingname, bool $inComment = false)
    {
        $setting = $this->getSettingsTable()->find()->where(['name' => $settingname])->firstOrFail();

        $setting = $setting->toArray();

        $this->settingId = $setting['id'];

        $slug = $inComment ? 'comment' : 'setting';

        // if it's an array then return the setting otherwise empty string

        return is_array($setting) ? $setting[$slug] : '';
    }

    /**
     * Generate an SSCC number with check digit
     *
     * @return string
     *
     * phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
     */
    public function generateSSCCWithCheckDigit()
    {
        $sscc = $this->generateSSCC();

        return $sscc . $this->generateCheckDigit($sscc);
    }

    /**
     * @return mixed
     */
    public function generateSSCC()
    {
        $ssccExtensionDigit = $this->getSetting(Configure::read('SSCC_EXTENSION_DIGIT'));

        $ssccCompanyPrefix = $this->getCompanyPrefix();

        $ssccReferenceNumber = $this->getReferenceNumber(Configure::read('SSCC_REF'), $ssccCompanyPrefix);

        return $ssccExtensionDigit . $ssccCompanyPrefix . $ssccReferenceNumber;
    }

    //phpcs:enable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps

    /**
     * when fed a barcode number returns the GS1 checkdigit number
     * @param  string $number barcode number
     * @return string barcode number
     */
    public function generateCheckDigit($number)
    {
        $sum = 0;
        $index = 0;
        $cd = 0;
        for ($i = strlen($number); $i > 0; $i--) {
            $digit = substr($number, $i - 1, 1);
            $index++;

            $ret = $index % 2;
            if ($ret == 0) {
                $sum += $digit * 1;
            } else {
                $sum += $digit * 3;
            }
        }
        $mod_sum = $sum % 10;
        // if it exactly divide the checksum is 0
        if ($mod_sum == 0) {
            $cd = 0;
        } else {
            // go to the next multiple of 10 above and subtract
            $cd = ((10 - $mod_sum) + $sum) - $sum;
        }

        return $cd;
    }

    /**
     * @param string $settingName   setting name
     * @param int    $companyPrefix the GS1 company prefix
     *
     * @return string a number with leading zeros
     */
    public function getReferenceNumber($settingName, $companyPrefix)
    {
        $next_val = $this->getSetting($settingName) + 1;

        $companyPrefixLength = strlen($companyPrefix);

        $fmt = '%0' . (16 - $companyPrefixLength) . 'd';

        $saveThis = [
            'id' => $this->settingId,
            'setting' => $next_val,
        ];

        $settingsTable = $this->getSettingsTable();

        $settingRecord = $settingsTable->get($this->settingId);

        $settingRecord->setting = $next_val;

        $settingsTable->save($settingRecord);

        return sprintf($fmt, $next_val);
    }

    public function getCompanyPrefix()
    {
        return $this->getSetting(Configure::read('SSCC_COMPANY_PREFIX'));
    }

    /**
     * createPalletRef queriesy product_types table to find last value and adds 1 to it
     *
     * @param  int    $productTypeId product_type_id of current product
     * @return string
     */
    public function createPalletRef($productTypeId)
    {
        $productTypeModel = $this->getSettingsTable('ProductTypes');

        $productType = $productTypeModel->get($productTypeId);

        $productTypeArray = $productType->toArray();

        // $this->log(print_r($productTypeArray, true));

        $serialNumberFormat = $productTypeArray['serial_number_format'];

        $serialNumber = $productType['next_serial_number'];

        $productType->next_serial_number = ++$serialNumber;

        if (!$productTypeModel->save($productType)) {
            throw new Exception('Failed to save the serial number for ' . $productTypeArray['name']);
        }

        return sprintf($serialNumberFormat, $serialNumber);
    }

    /**
     *
     * @param  string $controllerAction controller action method name
     * @return array  Help page record array or empty array
     */
    public function getHelpPage($controllerAction = null)
    {
        $helpModel = $this->getSettingsTable('Help');

        $helpPage = $helpModel->find()->where([
            'controller_action' => $controllerAction,
        ])->first();

        return $helpPage;
    }

    /**
     * returns a 2017-02-21 06:43:00 date time stamp
     *
     * @return date
     */
    public function getDateTimeStamp()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * FormatLabelDates given a dateString and an array of dateFormats as follows
     *
     * [
     *     'bb_date' => 'dd/mm/yy',
     *     'mysl_date' => 'yyyy-MM-dd'
     * ]
     *
     * returns the dates with the Initial keys e.g.
     * [
     *     'bb_date' => '31/01/73',
     *     'mysql_date' => '1973-01-31'
     * ]
     * @param  \Cake\I18n\FrozenTime $dateObject  The date as a string
     * @param  array                 $dateFormats As above example
     * @return array                 of date strings
     */
    public function formatLabelDates($dateObject, $dateFormats)
    {
        //tog([$dateString, $dateFormats]);

        $dates = [];
        foreach ($dateFormats as $k => $v) {
            $dates[$k] = $dateObject->format($v);
        }

        return $dates;
    }

    /**
     * formats date as YYmmdd
     * @param  string $date   Date string
     * @param  string $format PHP date format
     * @return date
     */
    public function formatYymmdd($date, $format = 'ymd')
    {
        $date = new FrozenDate($date);
        return $date->format($format);
    }

    /**
     * @param  datetime $date_time Y-m-d H:i:s
     * @param  int      $minutes   minutes to add
     * @return string
     */
    public function addMinutesToDateTime($date_time, $minutes)
    {
        $dateTime = new \DateTime($date_time);
        $add_minutes = '+ ' . $minutes . ' minutes';
        $dateTime->modify($add_minutes);

        return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * @param  string $start Start date time
     * @param  string $end   End date time
     * @return string
     */
    public function getDateTimeDiff($start, $end)
    {
        if (is_string($start) && is_string($end)) {
            $start = new \DateTime($start);
            $end = new \DateTime($end);
        }

        $date_interval = $start->diff($end);

        return sprintf(
            '%sh %dm %2ds',
            $date_interval->h,
            $date_interval->i,
            $date_interval->s
        );
    }

    /**
     * get Label Printers from printers table each controller/view can have
     *
     * @param  string $controller the controller
     * @param  string $action     the controller action as derived from $this->request->action
     * @return array
     */
    public function getLabelPrinters($controller = null, $action = null)
    {
        $printerModel = TableRegistry::get('Printers');

        $controllerAction = Inflector::camelize($controller . '::') . $action;

        $labelPrinters = $printerModel->find(
            'all',
            [
                'conditions' => [
                    'Printers.active' => 1,
                ],
            ]
        )->toArray();

        $default = array_reduce(
            $labelPrinters,
            function ($carry, $printer) use ($controllerAction) {
                if (
                    $printer['array_of_actions'] !== null &&
                    in_array(
                        $controllerAction,
                        $printer['array_of_actions']
                    )
                ) {
                    $carry = $printer['id'];
                };

                return $carry;
            },
            null
        );

        $printers['printers'] = Hash::combine(
            $labelPrinters,
            '{n}.id',
            '{n}.name'
        );

        $printers['default'] = $default;

        return $printers;
    }

    /**
     * getLabelPrinterById
     *
     * @param  int   $printerId Printer ID
     * @return mixed
     */
    public function getLabelPrinterById($printerId)
    {
        $printerModel = TableRegistry::get('Printers');

        $printer = $printerModel->get($printerId);

        return $printer->toArray();
    }

    /**
     * Function formatValidationErrors takes the
     * validationError array and makes it into a string
     *
     * @param  array  $validationErrors The validation array
     * @param  string $errorMessage     All errors concatenated into a string
     * @return mixed
     */
    public function formatValidationErrors(array $validationErrors = [], $errorMessage = null): string
    {
        // get Validation errors and append them into a string

        foreach ($validationErrors as $key => $value) {
            if (is_array($value)) {
                $errorMessage = $this->formatValidationErrors($value, $errorMessage);
            } else {
                if ($errorMessage) {
                    $errorMessage .= sprintf('. %s: ', $value);
                } else {
                    $errorMessage = sprintf('%s', $value);
                }
            }
        }

        return $errorMessage;
    }

    /**
     * getViewPermNumber returns the perm number when given the text
     * make globally available to all models
     * @param  array $perm Perm
     * @return mixed
     */
    public function getViewPermNumber($perm = null)
    {
        $perms = Configure::read('StockViewPerms');
        $key = array_search($perm, array_column($perms, 'slug'));

        return $perms[$key]['value'];
    }
}