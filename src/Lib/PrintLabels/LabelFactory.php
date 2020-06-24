<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use App\Lib\Exception\MissingConfigurationException;

class LabelFactory
{
    /**
     * Method create
     * @param $string $printClass Print class e.g. \App\Lib\PrintLabels\Glabels\Sscc
     * @param  string  $action Action Name in controller
     * @throws \App\Lib\Exception\MissingConfigurationException
     */
    public static function create(string $printClass, $action)
    {
        /**
         * Autoloader for PrintClasses
         */
        if (class_exists($printClass)) {
            return new $printClass($action);
        } else {
            throw new MissingConfigurationException('Cannot find ' . $printClass);
        }
    }
}