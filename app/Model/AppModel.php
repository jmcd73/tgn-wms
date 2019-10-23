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

    /**
     * @param $id
     * @param false $table
     * @param null $ds
     */
    public function __construct($id = false, $table = null, $ds = null)
    {

        $env = getenv('ENVIRONMENT') ?: 'HOME';

        $db_connections = Configure::read('datasources');
        $db_connection = $db_connections[$env];

        if ($db_connection) {
            $this->useDbConfig = $db_connection;
        }
        parent::__construct($id, $table, $ds);
    }

    /**
     * @param $printerId
     * @return mixed
     */
    public function getLabelPrinterById($printerId)
    {
        $printerModel = ClassRegistry::init('Printer');
        $printer = $printerModel->find(
            'first', [
                'conditions' => [
                    'Printer.id' => $printerId
                ]
            ]
        );
        return $printer;
    }
    /**
     * get Label Printers JSON from Settings Table
     * @param string $action the action as derived from $this->request->action
     * @return array
     */
    public function getLabelPrinters($controller = null, $action = null)
    {
        $printerModel = ClassRegistry::init('Printer');
        $controllerAction = $controller . 'Controller::' . $action;

        $labelPrinters = $printerModel->find(
            'all', [
                'conditions' => [
                    'Printer.active' => 1
                ]
            ]
        );

        $default = [];

        $label_printer_list = [];

        foreach ($labelPrinters as $printer) {

            $label_printer_list[$printer['Printer']['id']] = $printer['Printer']['name'];
            if (
                isset($printer['Printer']['set_as_default_on_these_actions']) &&
                !empty($printer['Printer']['set_as_default_on_these_actions'])
            ) {

                $controllerActionDefaults = $printer['Printer']['set_as_default_on_these_actions'];

                if (in_array($controllerAction, $controllerActionDefaults)) {
                    $default = $printer['Printer']['id'];
                }
            }
        }

        $printers['printers'] = $label_printer_list;
        $printers['default'] = $default;

        return $printers;
    }

    /**
     *
     * @param string $settingname
     * @param bool $settingInCommentField
     * @return type
     */
    public function getSetting(String $settingname, bool $inComment = false)
    {
        $settingModel = ClassRegistry::init('Setting');
        $setting = $settingModel->find(
            'first',
            [
                'conditions' => [
                    'name' => $settingname
                ]
            ]
        );

        if (empty($setting)) {
            throw new NotFoundException('Could not find setting in Settings table named ' . $settingname);
        }

        $slug = !$inComment ? 'setting' : 'comment';

        # if it's an array then return the setting otherwise empty string

        return is_array($setting) ? $setting['Setting'][$slug] : '';
    }

    /* returns the perm number when given the text
     * make globally available to all models
     *
     */

    /**
     * @param $perm
     * @return mixed
     */
    public function getViewPermNumber($perm = null)
    {
        $perms = Configure::read('StockViewPerms');
        $key = array_search($perm, array_column($perms, 'slug'));
        return $perms[$key]['value'];
    }

    public function db_config()
    {

        $dataSource = ConnectionManager::getDataSource($this->useDbConfig);
        return [
            'database' => $dataSource->config['database'],
            'config' => $this->useDbConfig,
            'host' => $dataSource->config['host']
        ];
    }

    /**
     * @param $kgs
     * @param $hrs
     * @return int
     */
    public function divide_values($kgs, $hrs)
    {

        if ($kgs == 0.0 || $hrs == 0.0) {
            return 0;
        } else {
            return round(($kgs / $hrs), 4);
        }

    }

    /**
     * @param array $date
     * @return mixed
     */
    public function arrayToMysqlDate($date = [])
    {
        if (is_array($date)) {
            $return_date = $date['year'] . '-' . $date['month'] . '-' . $date['day'];
        } else {
            $return_date = $date;
        }

        $ret = new DateTime($return_date);

        return $ret->format('Y-m-d');
    }

    /**
     * @param $start
     * @param $end
     */
    public function getDateTimeDiff($start, $end)
    {
        $start_date = new \DateTime($start);
        $end_date = new \DateTime($end);

        $date_interval = $start_date->diff($end_date);

        return sprintf('%sh %dm %2ds', $date_interval->h, $date_interval->i, $date_interval->s);

    }

    /**
     * Function formatValidationErrors takes the
     * validationError array and makes it into a string
     *
     * @param array $validationErrors The validation array
     *
     * @return mixed
     */
    public function formatValidationErrors($validationErrors = [])
    {

        $errorMessage = null;
        // get Validation errors and append them into a string

        foreach ($validationErrors as $key => $value) {

            if ($errorMessage) {
                $errorMessage .= sprintf(". <strong>%s: </strong>", $key);
            } else {
                $errorMessage = sprintf("<strong>%s: </strong>", $key);
            }

            foreach ($value as $i => $j) {
                $errorMessage .= $j;
            }
        };

        return $errorMessage;
    }

    /**
     * @param $date_time
     * @param $minutes
     * @return mixed
     */
    public function addMinutesToDateTime($date_time, $minutes)
    {
        $dateTime = new \DateTime($date_time);
        $add_minutes = '+' . $minutes . ' minutes';
        $dateTime->modify($add_minutes);
        return $dateTime->format('Y-m-d H:i:s');
    }
    /**
     * @param $cartons
     * @param $qty_per_pallet
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

    /*
     * returns a 2017-02-21 06:43:00 date time stamp
     *
     */

    public function getDateTimeStamp()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * @param $format
     * @param $date_string
     */
    public function formatLabelDates($format, $date_string)
    {
        return date($format, $date_string);
    }

    /**
     *  return array of batch numbers formatted for cakephp select options
     * $batch_nos = [
     *      601201 => '6012 - 01',
     *      601202 => '6012 - 02'
     *  ]
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
     * @returns bool
     *
     * */
    public function checkBatchNum($batch_no, $context)
    {
        //$this->log(['cbn' => $batch_no, 'cntxt' => $context]);
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
     * @param $productTypeId
     */
    public function createPalletRef($productTypeId)
    {
        $productTypeModel = ClassRegistry::init('ProductType');
        $productType = $productTypeModel->find(
            'first',
            [
                'conditions' => [
                    'ProductType.id' => $productTypeId
                ]
            ]
        );

        $serialNumberFormat = $productType['ProductType']['serial_number_format'];
        $serialNumber = $productType['ProductType']['next_serial_number'];
        if (!$productTypeModel->save(
            [
                'id' => $productTypeId,
                'next_serial_number' => ++$serialNumber
            ]
        )
        ) {
            throw new CakeException('Could not update the next_serial_number');
        };

        return sprintf($serialNumberFormat, $serialNumber);
    }

    /**
     * @param $controllerAction
     */
    public function getHelpPage($controllerAction = null)
    {
        $helpModel = ClassRegistry::init('Help');
        $helpPage = $helpModel->find(
            'first', [
                'conditions' => [
                    'controller_action' => $controllerAction
                ]
            ]
        );
        return $helpPage;
    }
}
