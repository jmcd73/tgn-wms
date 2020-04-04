<?php

namespace App\Lib\PrintLabels;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\CabLabel\CartonLabel;
use App\Lib\PrintLabels\CabLabel\PalletPrint;
use App\Lib\PrintLabels\Glabel\CrossdockLabel;
use App\Lib\PrintLabels\Glabel\CustomLabel;
use App\Lib\PrintLabels\Glabel\GlabelSample;
use App\Lib\PrintLabels\Glabel\SampleLabel;
use App\Lib\PrintLabels\Glabel\ShippingLabel;
use App\Lib\PrintLabels\Glabel\ShippingLabelGeneric;
use App\Lib\PrintLabels\Glabel\SsccLabel;
use App\Lib\PrintLabels\Zebra\TextLabel;
use Cake\Log\LogTrait;

class LabelFactory
{
    use LogTrait;

    public static $actionToClassMap = [
        'glabelSampleLabels' => 'App\Lib\PrintLabels\Glabel\GlabelSample',
        'keepRefrigerated' => 'App\Lib\PrintLabels\Glabel\CustomLabel',
        'customPrint' => 'App\Lib\PrintLabels\Glabel\CustomLabel',
        'shippingLabels' => 'App\Lib\PrintLabels\Glabel\ShippingLabel',
        'crossdockLabels' => 'App\Lib\PrintLabels\Glabel\CrossdockLabel',
        'shippingLabelsGeneric' => 'App\Lib\PrintLabels\Glabel\ShippingLabelGeneric',
        'bigNumber' => 'App\Lib\PrintLabels\Zebra\TextLabel',
        'printCartonLabels' => 'App\Lib\PrintLabels\CabLabel\CartonLabel',
        'sampleLabels' => 'App\Lib\PrintLabels\Glabel\SampleLabel',
        'palletPrint' => 'App\Lib\PrintLabels\CabLabel\PalletPrint',
        'palletReprint' => 'App\Lib\PrintLabels\CabLabel\PalletPrint',
        'ssccLabel' => 'App\Lib\PrintLabels\Glabel\SsccLabel',
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