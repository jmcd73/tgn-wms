<?php

declare(strict_types=1);

namespace App\Model\Behavior;

use App\Lib\Exception\MissingConfigurationException;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\I18n\FrozenDate;
use \Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\Log\LogTrait;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use App\Lib\Utility\SettingsTrait;
use App\Lib\Utility\FormatDateTrait;

/**
 * TgnUtils behavior
 */
class TgnUtilsBehavior extends Behavior
{
    use LogTrait;
    use SettingsTrait;
    use FormatDateTrait;
    
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'labelDateFormats' =>   [
            'bb_date' => 'Y-m-d',
            'bb_bc' => 'ymd',
            'bb_hr' => 'd/m/y',
        ]
    ];

    /**
     * Returns the current reference number stored in settings table record
     * and increments and saves the number in the table record
     * 
     * @param  string $settingName   setting name
     * @param  int    $companyPrefix the GS1 company prefix
     * @return string a number formatted with appropriate number of leading zeros depending on companyPrefix length
     * 
     */
    public function getReferenceNumber($settingName)
    {
        return $this->getSetting($settingName);
    }

    public function getCompanyPrefix()
    {
        return $this->getSetting('SSCC_COMPANY_PREFIX');
    }

    /**
     * createPalletRef queriesy product_types table to find last value and adds 1 to it
     *
     * @param  int    $productTypeId product_type_id of current product
     * @return string
     */
    public function createPalletRef($productTypeId, $serialNumber)
    {
        $productTypeModel = $this->getSettingsTable('ProductTypes');

        $productType = $productTypeModel->get($productTypeId);

        $serialNumberFormat = $productType->serial_number_format;

        return sprintf($serialNumberFormat, $serialNumber);
    }

    /**
     * getPageHelp
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
     * @return string|false
     */
    public function getDateTimeStamp()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * formats date as YYmmdd
     *
     * @param  string $date   Date string
     * @param  string $format PHP date format
     * @return string
     */
    public function formatYymmdd($date, $format = 'ymd'): string
    {
        return (new FrozenDate($date))->format($format);
    }

    /**
     * @param  \DateTime $date_time Y-m-d H:i:s
     * @param  int       $minutes   minutes to add
     * @return string
     */
    public function addMinutesToDateTime($date_time, $minutes): string
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
    public function getLabelPrinters($controllerAction)
    {
        $printerModel = TableRegistry::get('Printers');

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

        return $printerModel->get($printerId);
    }

    /**
     * Function formatValidationErrors takes the
     * validationError array and makes it into a string
     *
     * @param  array  $validationErrors The validation array
     * @param  string $errorMessage     All errors concatenated into a string
     * @return mixed
     */
    public function formatValidationErrors(array $validationErrors = [], $errorMessage = []): string
    {
        // get Validation errors and append them into a string

        foreach ($validationErrors as $key => $value) {
            $parent = $key;
            if (is_array($value)) {
                $errorMessage[] = $this->formatValidationErrors($value, $errorMessage);
            } else {
                $errorMessage[] = $parent . ': ' . $value;
            }
        }

        return join('. ', array_unique($errorMessage));
    }
    /**
     * @param array $validationErrors The Validation Errors from an entity
     * @return string
     */
    public function flattenAndFormatValidationErrors(array $validationErrors = []): string
    {
        // get Validation errors and append them into a string

       $flattened = Hash::flatten($validationErrors);
       $msg = [];
        foreach ($flattened as $key => $error) {
            [$field, $rule] = explode(".", $key);
           $currentMessage = sprintf(
               'Validation for <strong>%s</strong> field has failed in rule <strong>%s</strong> with error: <strong>%s</strong>',
                $field, 
                $rule, 
                $error
            );
           $msg[] = $currentMessage;
       }
       
       return join(" ", $msg);
    }
    

     /**
     * @param array $validationErrors The Validation Errors from an entity
     * @return string
     */
    public function formatForSetErrors(array $validationErrors = []): array
    {
        // get Validation errors and append them into a string

       $flattened = Hash::flatten($validationErrors);
       $errors = [];
        foreach ($flattened as $key => $error) {
            [$field, $rule] = explode(".", $key);
            $errors[$field] = $error;
       }
       
       return $errors;
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
