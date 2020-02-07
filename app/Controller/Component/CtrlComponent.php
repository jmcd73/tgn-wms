<?php

//
//File: application/Controller/Component/CtrlComponent.php
// Component rewritten, original from : http://cakebaker.42dh.com/2006/07/21/how-to-list-all-controllers/
//
class CtrlComponent extends Component
{
    protected $hasPrintActions = [
        'PalletsController',
        'PrintLabelsController',
    ];

    /**
     * Return an array of user Controllers and their methods.
     * The function will exclude ApplicationController methods
     * @param bool $showSelected show the controller based on
     * @return array
     */
    public function get($showSelected = false)
    {
        $aCtrlClasses = App::objects('controller');
        $controllers = [];

        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller

                App::import('Controller', str_replace('Controller', '', $controller));

                if ($showSelected && !in_array(get_class(new $controller()), $this->hasPrintActions)) {
                    continue;
                }

                // Load its methods / actions
                $aMethods = get_class_methods($controller);

                foreach ($aMethods as $idx => $method) {
                    if ($method{0} == '_') {
                        unset($aMethods[$idx]);
                    }
                }

                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');

                $controllers[$controller] = array_diff($aMethods, $parentActions);
            }
        }

        return $controllers;
    }

    /**
     * Re-Format Array of Controllers for use in
     * @param bool $printClassesOnly Whether to include only those classes
     * listed in $this->hasPrintActions
     *
     * @return array
     */
    public function formatArray($printClassesOnly = true)
    {
        $classList = $this->get($printClassesOnly);
        foreach ($classList as $key => $value) {
            $controller = str_replace('Controller', '', $key);
            foreach ($value as $k => $v) {
                $ret[$key][$controller . '::' . $v] = $controller . '::' . $v;
            }
        }

        return $ret;
    }

    /**
     * @param bool $showSelected show
     * @return mixed
     */
    public function formatForPrinterViews($showSelected = false)
    {
        $array = $this->get($showSelected);
        $ret = [];
        foreach ($array as $key => $value) {
            //$controller = str_replace('Controller', '', $key);
            foreach ($value as $k => $v) {
                $ret[$key][$key . '::' . $v] = $v;
            }
        }

        return $ret;
    }

    /**
     * Format Controller with Actions Only List
     * @param array $array an array of controller names
     * @return array
     */
    public function formatControllersWithActionOnlyList($array)
    {
        foreach ($array as $key => $value) {
            $controller = str_replace('Controller', '', $key);
            foreach ($value as $k => $v) {
                $ret[$key][$v] = $controller . '::' . $v;
            }
        }

        return $ret;
    }
}