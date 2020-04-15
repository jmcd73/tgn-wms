<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use App\Lib\Exception\MissingConfigurationException;
use Cake\Core\Configure;

class LabelFactory
{
    /**
     * Method create
     *
     * @param  string                                           $action Action Name in controller
     * @throws \App\Lib\Exception\MissingConfigurationException
     */
    public static function create(string $action)
    {
        $actionToClassMap = Configure::read('PrintLabels');

        /**
         * Autoloader for PrintClasses
         */
        if (isset($actionToClassMap[$action]) && class_exists($actionToClassMap[$action])) {
            return new $actionToClassMap[$action]($action);
        } else {
            throw new MissingConfigurationException('Cannot find Lib/Print class for ' . $action);
        }
    }
}