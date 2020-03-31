<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');
App::uses('ConnectionManager', 'Model');

/* globally include settings because we might use them in any model */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model
{
    /**
     * @var array
     */
    public $actsAs = ['Containable'];
    public $settingId = null;

    /**
     * @param bool $id ID
     * @param false $table Table
     * @param null $ds DS not sure
     */
    public function __construct($id = false, $table = null, $ds = null)
    {
        $env = getenv('ENVIRONMENT') ?: 'TEST';

        $db_connections = Configure::read('datasources');

        $db_connection = $db_connections[$env];

        if ($db_connection) {
            $this->useDbConfig = $db_connection;
        }

        parent::__construct($id, $table, $ds);
    }

    /**
     * getLabelPrinterById
     *
     * @param int $printerId Printer ID
     * @return mixed
     */
    public function getLabelPrinterById($printerId)
    {
        $printerModel = ClassRegistry::init('Printer');

        $printer = $printerModel->find(
            'first',
            [
                'conditions' => [
                    'Printer.id' => $printerId,
                ],
            ]
        );

        return $printer;
    }

    /**
     * get Label Printers from printers table each controller/view can have
     *
     * @param string $controller the controller
     * @param string $action the controller action as derived from $this->request->action
     * @return array
     */
    public function getLabelPrinters($controller = null, $action = null)
    {
        $printerModel = ClassRegistry::init('Printer');

        $controllerAction = Inflector::camelize($controller . '_Controller::') . $action;

        $labelPrinters = $printerModel->find(
            'all',
            [
                'conditions' => [
                    'Printer.active' => 1,
                ],
            ]
        );

        $default = array_reduce(
            $labelPrinters,
            function ($carry, $printer) use ($controllerAction) {
                if (
                    $printer['Printer']['set_as_default_on_these_actions'] !== null &&
                    in_array(
                        $controllerAction,
                        $printer['Printer']['set_as_default_on_these_actions']
                    )
                ) {
                    $carry = $printer['Printer']['id'];
                };

                return $carry;
            },
            null
        );

        $printers['printers'] = Hash::combine(
            $labelPrinters,
            '{n}.Printer.id',
            '{n}.Printer.name'
        );

        $printers['default'] = $default;

        return $printers;
    }

    /**
     *
     * @param string $settingname the name of the setting in the settings.setting field of the db
     * @param bool $inComment some settings are stored in the comment field as they have CR or JSON
     * @return string
     */
    public function getSetting($settingname, bool $inComment = false)
    {
        $settingModel = ClassRegistry::init('Setting');
        $setting = $settingModel->find(
            'first',
            [
                'conditions' => [
                    'name' => $settingname,
                ],
            ]
        );

        if (empty($setting)) {
            throw new MissingConfigurationException(
                [
                    'message' => __(
                        'Could not find setting in settings table named <strong>%s</strong>',
                        $settingname
                    ),
                ],
                '500'
            );
        }

        $this->settingId = $setting['Setting']['id'];

        $slug = $inComment ? 'comment' : 'setting';

        // if it's an array then return the setting otherwise empty string

        return is_array($setting) ? $setting['Setting'][$slug] : '';
    }

    /**
     * getViewPermNumber returns the perm number when given the text
     * make globally available to all models
     * @param array $perm Perm
     * @return mixed
     */
    public function getViewPermNumber($perm = null)
    {
        $perms = Configure::read('StockViewPerms');
        $key = array_search($perm, array_column($perms, 'slug'));

        return $perms[$key]['value'];
    }

    /**
     * This dbConfig allows dynamic configuration of the database by an environment variable
     * passed in from Apache .htaccess
     *
     * @return array
     */
    public function dbConfig()
    {
        $dataSource = ConnectionManager::getDataSource($this->useDbConfig);

        return [
            'database' => $dataSource->config['database'],
            'config' => $this->useDbConfig,
            'host' => $dataSource->config['host'],
        ];
    }

    /**
     * @param int $kgs KGs
     * @param int $hrs Hrs
     * @return int
     *
     */
    public function divideValues($kgs, $hrs)
    {
        if ($kgs == 0.0 || $hrs == 0.0) {
            return 0;
        } else {
            return round(($kgs / $hrs), 4);
        }
    }

    /**
     * @param array $date Cakephp date array
     * @return string "Y-m-d"
     */
    public function arrayToMysqlDate($date = [])
    {
        $return_date = is_array($date) ? $date['year'] . '-' . $date['month'] . '-' . $date['day'] : $date;

        $ret = new DateTime($return_date);

        return $ret->format('Y-m-d');
    }

    /**
     * @param string $start Start date time
     * @param string $end End date time
     * @return string
     */
    public function getDateTimeDiff($start, $end)
    {
        $start_date = new \DateTime($start);
        $end_date = new \DateTime($end);

        $date_interval = $start_date->diff($end_date);

        return sprintf(
            '%sh %dm %2ds',
            $date_interval->h,
            $date_interval->i,
            $date_interval->s
        );
    }

    /**
     * Function formatValidationErrors takes the
     * validationError array and makes it into a string
     *
     * @param array $validationErrors The validation array
     * @param string $errorMessage All errors concatenated into a string
     * @return mixed
     */
    public function formatValidationErrors($validationErrors = [], $errorMessage = null)
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
     * @param datetime $date_time Y-m-d H:i:s
     * @param int $minutes minutes to add
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
     * This returns a if given a carton count it will divide the
     * carton count by the quantity per pallet to get cartons
     * and then also get the left over
     * e.g.
     * given 100 cartons and a qty_per_pallet of 40
     * returns 2.20
     *
     * @param int $cartons Count of cartons
     * @param int $qty_per_pallet the quantity per pallet for that item
     *
     * @return mixed
     */
    public function palletsDotCartons($cartons, $qty_per_pallet)
    {
        $pallets = $cartons / $qty_per_pallet;

        $mod = $cartons % $qty_per_pallet;
        if ($mod !== 0) {
            $pallets = intval($pallets) . '.' . $mod;
        }

        return $pallets;
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
     * @param string $dateString The date as a string
     * @param array $dateFormats As above example
     * @return array of date strings
     */
    public function formatLabelDates($dateString, $dateFormats)
    {
        $dates = [];
        foreach ($dateFormats as $k => $v) {
            $dates[$k] = date($v, $dateString);
        }

        return $dates;
    }

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
        $batch_prefix = substr(CakeTime::format(time(), '%Y%j'), 3);

        for ($i = 1; $i <= 99; $i++) {
            $batch_nos[$batch_prefix . sprintf('%02d', $i)] = $batch_prefix . ' - ' . sprintf('%02d', $i);
        };

        return $batch_nos;
    }

    /**
     * checks if batch number matches todays date
     *  returns true if it does
     * @param string $batch_no Batch number
     * @param array $context data array
     * @return bool
     *
     */
    public function checkBatchNum($batch_no, $context)
    {
        $match = false;

        $batch_nos = $this->getBatchNumbers();

        foreach ($batch_nos as $key => $value) {
            if ($batch_no['batch_no'] == $key) {
                $match = true;
            }
        }

        return $match;
    }

    /**
     * createPalletRef queriesy product_types table to find last value and adds 1 to it
     *
     * @param int $productTypeId product_type_id of current product
     * @return string
     */
    public function createPalletRef($productTypeId)
    {
        $productTypeModel = ClassRegistry::init('ProductType');
        $productType = $productTypeModel->find(
            'first',
            [
                'conditions' => [
                    'ProductType.id' => $productTypeId,
                ],
            ]
        );

        $serialNumberFormat = $productType['ProductType']['serial_number_format'];

        $serialNumber = $productType['ProductType']['next_serial_number'];

        if (
            !$productTypeModel->save(
                [
                    'id' => $productTypeId,
                    'next_serial_number' => ++$serialNumber,
                ]
            )
        ) {
            throw new CakeException('Could not update the next_serial_number');
        };

        return sprintf($serialNumberFormat, $serialNumber);
    }

    /**
     *
     * @param string $controllerAction controller action method name
     * @return array Help page record array or empty array
     */
    public function getHelpPage($controllerAction = null)
    {
        $helpModel = ClassRegistry::init('Help');
        $helpPage = $helpModel->find(
            'first',
            [
                'conditions' => [
                    'Help.controller_action' => $controllerAction,
                ],
            ]
        );

        return $helpPage;
    }
}