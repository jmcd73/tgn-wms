<?php

/**
 * Bootstrap Form Helper
 *
 *
 * PHP 5
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *
 * @copyright Copyright (c) Mikaël Capelle (http://mikael-capelle.fr)
 * @link http://mikael-capelle.fr
 * @package app.View.Helper
 * @since Apache v2
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

//App::uses('ModdedFormHelper', 'View/Helper') ;
App::uses('BootstrapHtmlHelper', 'Bootstrap3.View/Helper');
//App::import('Helper', 'Form') ;

class ToggenHtmlHelper extends BootstrapHtmlHelper
{
    /**
     * buildClass takes an array or string of classes and returns
     * class="class1 class2 class4"
     * @param mixed $classes array or string
     * @return string
     */
    public function buildClass($classes)
    {
        if (!is_array($classes)) {
            $classes = [$classes];
        }

        return 'class="' . trim(implode(' ', $classes)) . '"';
    }
}
