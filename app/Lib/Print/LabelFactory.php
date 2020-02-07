<?php

App::uses('MissingConfigurationException', 'Lib/Exception');
App::uses('GlabelSample', 'Lib/Print/Glabel');
App::uses('CustomLabel', 'Lib/Print/Glabel');
App::uses('ShippingLabel', 'Lib/Print/Glabel');
App::uses('CrossdockLabel', 'Lib/Print/Glabel');
App::uses('ShippingLabelGeneric', 'Lib/Print/Glabel');
App::uses('SampleLabel', 'Lib/Print/Glabel');
App::uses('SsccLabel', 'Lib/Print/Glabel');
App::uses('TextLabel', 'Lib/Print/Zebra');
App::uses('CartonLabel', 'Lib/Print/CabLabel');
App::uses('PalletPrint', 'Lib/Print/CabLabel');

class LabelFactory
{
    public static $actionToClassMap = [
        'glabelSampleLabels' => 'GlabelSample',
        'keepRefrigerated' => 'CustomLabel',
        'customPrint' => 'CustomLabel',
        'shippingLabels' => 'ShippingLabel',
        'crossdockLabels' => 'CrossdockLabel',
        'shippingLabelsGeneric' => 'ShippingLabelGeneric',
        'bigNumber' => 'TextLabel',
        'printCartonLabels' => 'CartonLabel',
        'sampleLabels' => 'SampleLabel',
        'palletPrint' => 'PalletPrint',
        'palletReprint' => 'PalletPrint',
        'ssccLabel' => 'SsccLabel',
    ];

    /**
     * Method create
     * @param string $action Action Name in controller
     *
     */
    public static function create(string $action)
    {
        /**
         * assumes the use of an autoloader
         *
        */
        if (isset(self::$actionToClassMap[$action]) && class_exists(self::$actionToClassMap[$action])) {
            return new self::$actionToClassMap[$action]($action);
        } else {
            throw new MissingConfigurationException('Cannot find Lib/Print class for ' . $action);
        }
    }
}