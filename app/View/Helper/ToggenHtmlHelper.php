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

App::uses('BootstrapHtmlHelper', 'Bootstrap3.View/Helper');

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

    public function printTemplateType($printTemplate)
    {
        $textTemplate = $printTemplate['PrintTemplate']['text_template'];
        $glabelsTemplate = $printTemplate['PrintTemplate']['file_template'];

        if (empty($textTemplate) && !empty($glabelsTemplate)) {
            return 'file-pdf';
        }

        if (empty($glabelsTemplate) && !empty($textTemplate)) {
            return 'file-code';
        }

        return false;
    }

    /**
     *
     * Create a Twitter Bootstrap icon.
     *
     * @param $icon The type of the icon (search, pencil, etc.)
     * @param $opcions Options for icon
     * @param $opcions['tag'] Tag use for the icon, "i" for default
     * @param $opcions['font'] Font of the icon:
     *                         "glyphicon" for default Twitter Bootstrap icon.
     *                         "fa" for Font Awesome icon.
     *
    **/
    public function icon($icon, array $options = [])
    {
        $tag = empty($options['tag']) ? 'i' : $options['tag'];
        $font = 'glyphicon glyphicon-';
        if (!empty($options['font']) && $options['font'] == 'fa') {
            $font = 'fas fa-';
        }
        unset($options['tag'], $options['font']);

        $options['class'] = empty($options['class']) ? ($font . $icon) : ($font . $icon . ' ' . $options['class']);

        return $this->tag($tag, '', $options);
    }
}