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
App::uses('BootstrapFormHelper', 'Bootstrap3.View/Helper');
//App::import('Helper', 'Form') ;

class ToggenFormHelper extends BootstrapFormHelper
{
    /**
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * @var mixed
     */
    public $horizontal = false;
    /**
     * @var mixed
     */
    public $inline = false;
    /**
     * @var mixed
     */
    public $search = false;

    /**
     * @var mixed
     */
    protected $colSize;

    /**
     * @var array
     */
    protected $_buttonTypes = ['primary', 'info', 'success', 'warning', 'danger', 'inverse', 'link'];
    /**
     * @var array
     */
    protected $_buttonSizes = ['sm', 'md', 'lg'];

    /**
     * @var mixed
     */
    protected $_currentInputType = null;

    /**
     *
     * Add classes to options according to values of bootstrap-type and bootstrap-size for button.
     *
     * @param array $options The initial options with bootstrap-type and/or bootstrat-size values
     *
     * @return The new options with class values (btn, and btn-* according to initial options)
     *
     **/
    protected function _addButtonClasses($options)
    {
        $options = $this->addClass($options, 'btn');

        if (isset($options['bootstrap-type']) && in_array($options['bootstrap-type'], $this->_buttonTypes)) {
            $options = $this->addClass($options, 'btn-' . $options['bootstrap-type']);
        } else {
            $options = $this->addClass($options, 'btn-primary');
        }

        if (isset($options['bootstrap-size']) && in_array($options['bootstrap-size'], $this->_buttonSizes)) {
            $options = $this->addClass($options, 'btn-' . $options['bootstrap-size']);
        }

        unset($options['bootstrap-size'], $options['bootstrap-type']);

        return $options;
    }

    /**
     *
     * Try to match the specified HTML code with a button or a input with submit type.
     *
     * @param string $html The HTML code to check
     *
     * @return true if the HTML code contains a button
     *
     **/
    protected function _matchButton($html)
    {
        return strpos($html, '<button') !== false || strpos($html, 'type="submit"') !== false;
    }

    /**
     *
     * Create a Twitter Bootstrap like form.
     *
     * New options available:
     *  - horizontal: boolean, specify if the form is horizontal
     *  - inline: boolean, specify if the form is inline
     *  - search: boolean, specify if the form is a search form
     *
     * Unusable options:
     *  - inputDefaults
     *
     * @param Model $model The model corresponding to the form
     * @param array $options Options to customize the form
     *
     * @return The HTML tags corresponding to the openning of the form
     *
     **/
    public function create($model = null, $options = [])
    {
        $this->colSize = [
            'label' => 2,
            'input' => 6,
            'error' => 4,
        ];

        if (isset($options['cols'])) {
            $this->colSize = $options['cols'];
            unset($options['cols']);
        }

        $this->horizontal = $this->_extractOption('horizontal', $options, false);
        unset($options['horizontal']);
        $this->search = $this->_extractOption('search', $options, false);
        unset($options['search']);
        $this->inline = $this->_extractOption('inline', $options, false);
        unset($options['inline']);
        if ($this->horizontal) {
            $options = $this->addClass($options, 'form-horizontal');
        } elseif ($this->inline) {
            $options = $this->addClass($options, 'form-inline');
        }
        if ($this->search) {
            $options = $this->addClass($options, 'form-search');
        }
        $options['role'] = 'form';
        $options['inputDefaults'] = [
            'div' => [
                'class' => 'form-group',
            ],
        ];

        return FormHelper::create($model, $options);
    }

    /**
     *
     * Return the col size class for the specified column (label, input or error).
     * @param string $what thing we are looking at
     * @param bool $offset with we are looking at offset
     * @return string
     **/
    protected function _getColClass($what, $offset = false)
    {
        if ($what == 'offset') {
            $what = 'label';
            $offset = true;
        }
        $size = $this->colSize[$what];
        if ($size) {
            return 'col-md-' . ($offset ? 'offset-' : '') . $size;
        }

        return '';
    }

    /**
     *
     * Create & return a error message (Twitter Bootstrap like).
     *
     * The error is wrapped in a <span> tag, with a class
     * according to the form type (help-inline or help-block).
     * @param array $field (not sure what type this is)
     * @param mixed $text string or null
     * @param array $options options array
     * @return string
     **/
    public function error($field, $text = null, $options = [])
    {
        $this->setEntity($field);
        $optField = $this->_magicOptions([]);
        $options['wrap'] = $this->_extractOption('wrap', $options, 'span');
        $errorClass = 'help-block';
        if ($this->horizontal && $optField['type'] != 'checkbox' && $optField['type'] != 'radio') {
            $errorClass .= ' ' . $this->_getColClass('error');
        }
        $options = $this->addClass($options, $errorClass);

        return FormHelper::error($field, $text, $options);
    }

    /**
     *
     * Create & return a label message (Twitter Boostrap like).
     * @param string $fieldName field name
     * @param mixed $text string or null
     * @param array $options options array
     * @return string
     **/
    public function label($fieldName = null, $text = null, $options = [])
    {
        if ($this->_currentInputType == 'checkbox') {
            if ($text === null) {
                if (strpos($fieldName, '.') !== false) {
                    $fieldElements = explode('.', $fieldName);
                    $text = array_pop($fieldElements);
                } else {
                    $text = $fieldName;
                }
                if (substr($text, -3) === '_id') {
                    $text = substr($text, 0, -3);
                }
                $text = __(Inflector::humanize(Inflector::underscore($text)));
            }

            return $text;
        }
        if (!$this->inline) {
            $options = $this->addClass($options, 'control-label');
        }
        if ($this->horizontal) {
            $options = $this->addClass($options, $this->_getColClass('label'));
        }
        if ($this->inline) {
            //  $options = $this->addClass($options, 'sr-only') ;
        }

        return FormHelper::label($fieldName, $text, $options);
    }

    /**
     *
     * Create & return an input block (Twitter Boostrap Like).
     *
     * New options:
     *  - prepend:
     *      -> string: Add <span class="add-on"> before the input
     *      -> array: Add elements in array before inputs
     *  - append: Same as prepend except it add elements after input
     * @param string $fieldName field name
     * @param array $options Options array
     * @return string
     **/
    public function input($fieldName, $options = [])
    {
        $options += [
            'multiple' => '',
        ];
        $inputGroupSize = $this->_extractOption('input-group-size', $options, null);
        unset($options['input-group-size']);
        $prepend = $this->_extractOption('prepend', $options, null);
        unset($options['prepend']);
        $append = $this->_extractOption('append', $options, null);
        unset($options['append']);
        $before = $this->_extractOption('before', $options, '');
        $after = $this->_extractOption('after', $options, '');
        $between = $this->_extractOption('between', $options, '');
        $label = $this->_extractOption('label', $options, false);

        $inline = $this->_extractOption('inline', $options, false);
        unset($options['inline']);

        $this->setEntity($fieldName);
        $options = $this->_parseOptions($options);

        //jmits changes to put error outside after and it works@!!!!!
        $options['format'] = ['label', 'before', 'input', 'between', 'after', 'error'];
        $this->_currentInputType = $options['type'];

        $beforeClass = [];
        $oneLessDiv = false;

        if ($options['type'] == 'checkbox' || $options['type'] == 'radio') {
            $before = '<label' . ($inline ? ' class="' . $options['type'] . '-inline"' : '') . '>' . $before;
            $between = $between . '</label>';
            $options['format'] = [
                'before',
                'input',
                'label',
                'between',
                'error',
                'after', ];
            if ($this->horizontal) {
                $before = '<div class="' . $this->_getColClass('input') .
                    ($options['type'] == 'checkbox' || !$label ? ' ' . $this->_getColClass('offset') : '') . '">' .
                    ($inline ? '' : '<div class="' . $options['type'] . '">') . $before;
                $after = $after . ($inline ? '' : '</div>') . '</div>';
            } elseif (!$inline && ($options['type'] == 'checkbox' || !$label)) {
                $options['div'] = [
                    'class' => $options['type'],
                ];
            }
            if ($options['type'] == 'radio') {
                if ($label) {
                    $before = $this->label($fieldName, $label) . ($this->horizontal ? '' : '<div class="radio radio">') . $before;
                    $after .= $this->horizontal ? '' : '</label></div>';
                }
                $options['label'] = false;
                $options['separator'] = '</label>' . ($inline ? '<label' . ($inline ? ' class="' . $options['type'] . '-inline"' : '') . '>' : '</div><div class="radio"><label>');
            }
        } elseif ($this->horizontal) {
            $beforeClass[] = $this->_getColClass('input');
            $oneLessDiv = true;
        }
        $beforePrepend = '';
        if ($prepend) {
            $defaultBeforeClass = 'input-group';
            if ($inputGroupSize) {
                $defaultBeforeClass .= ' ' . $inputGroupSize;
            }
            $beforeClass[] = $defaultBeforeClass;
            if (is_string($prepend)) {
                $beforePrepend .= '<span class="input-group-' . ($this->_matchButton($prepend) ? 'btn' : 'addon') . '">' . $prepend . '</span>';
            }
            if (is_array($prepend)) {
                foreach ($prepend as $pre) {
                    $beforePrepend .= $pre;
                }
            }
        }
        if ($append) {
            $defaultBeforeClass = 'input-group';
            if ($inputGroupSize) {
                $defaultBeforeClass .= ' ' . $inputGroupSize;
            }
            $beforeClass[] = $defaultBeforeClass;
            if (is_string($append)) {
                $between = '<span class="input-group-' . ($this->_matchButton($append) ? 'btn' : 'addon') . '">' . $append . '</span>' . $between;
            }
            if (is_array($append)) {
                foreach ($append as $apd) {
                    $between = '<span class="input-group-' . ($this->_matchButton($apd) ? 'btn' : 'addon') . '">' . $apd . '</span>' . $between;
                }
            }
        }

        if ($oneLessDiv) {
            $between .= '</div>';
        }

        if (!empty($beforeClass)) {
            foreach ($beforeClass as $bc) {
                $before .= '<div class="' . $bc . '">';
                if (!$oneLessDiv) {
                    $after = '</div>' . $after;
                }
                $oneLessDiv = false;
            }
        }
        $before .= $beforePrepend;

        $type = $options['type'];
        $error = $this->_extractOption('error', $options, null);
        if (
            $type !== 'hidden'
            && $error !== false
            && $this->error($fieldName, $error)
        ) {
            $options['div'] = $this->addClass($this->_inputDefaults['div'], 'has-error');
        }

        $options['before'] = $before;
        $options['after'] = $after;
        $options['between'] = $between;

        if (!in_array($options['type'], ['checkbox', 'radio', 'file']) && !($options['multiple'] === 'checkbox')) {
            $options = $this->addClass($options, 'form-control');
        }
        //debug(FormHelper::input($fieldName, $options) );

        return FormHelper::input($fieldName, $options);
    }

    /**
     *
     * Create & return a Twitter Like button.
     *
     * New options:
     *  - bootstrap-type: Twitter bootstrap button type (primary, danger, info, etc.)
     *  - bootstrap-size: Twitter bootstrap button size (mini, small, large)
     * @param string $title Title
     * @param array $options Options array
     * @return string
     **/
    public function button($title, $options = [])
    {
        $options = $this->_addButtonClasses($options);
        //$options['type'] = FALSE ;

        return FormHelper::button($title, $options);
    }

    /**
     *
     * Create & return a Twitter Like button group.
     *
     * @param array $buttons The buttons in the group
     * @param array $options Options for div method
     *
     * Extra options:
     *  - vertical true/false
     * @return string
     **/
    public function buttonGroup($buttons, $options = [])
    {
        $vertical = $this->_extractOption('vertical', $options, false);
        unset($options['vertical']);
        $options = $this->addClass($options, 'btn-group');
        if ($vertical) {
            $options = $this->addClass($options, 'btn-group-vertical');
        }

        return $this->Html->tag('div', implode('', $buttons), $options);
    }

    /**
     *
     * Create & return a Twitter Like button toolbar.
     *
     * @param  array $buttonGroups The groups in the toolbar
     * @param array $options Options for div method
     * @return string
     **/
    public function buttonToolbar($buttonGroups, $options = [])
    {
        $options = $this->addClass($options, 'btn-toolbar');

        return $this->Html->tag('div', implode('', $buttonGroups), $options);
    }

    /**
     *
     * Create & return a twitter bootstrap dropdown button.
     *
     * @param string $title The text in the button
     * @param string $menu HTML tags corresponding to menu options (which will be wrapped
     *       into <li> tag). To add separator, pass 'divider'.
     * @param array $options Options for button
     * @return string
     *
     **/
    public function dropdownButton($title, $menu = [], $options = [])
    {
        $options['type'] = false;
        $options['data-toggle'] = 'dropdown';
        $options = $this->addClass($options, 'dropdown-toggle');

        $outPut = '<div class="btn-group">';
        $outPut .= $this->button($title . '<span class="caret"></span>', $options);
        $outPut .= '<ul class="dropdown-menu">';
        foreach ($menu as $action) {
            if ($action === 'divider') {
                $outPut .= '<li class="divider"></li>';
            } else {
                $outPut .= '<li>' . $action . '</li>';
            }
        }
        $outPut .= '</ul></div>';

        return $outPut;
    }

    /**
     *
     * Create & return a Twitter Like submit input.
     *
     * New options:
     *  - bootstrap-type: Twitter bootstrap button type (primary, danger, info, etc.)
     *  - bootstrap-size: Twitter bootstrap button size (mini, small, large)
     *
     * Unusable options: div
     * @param string $caption Submit caption
     * @param array $options Options array
     * @return string
     **/
    public function submit($caption = null, $options = [])
    {
        $options = $this->_addButtonClasses($options);
        if (!isset($options['div'])) {
            $options['div'] = false;
        }
        if (!$this->horizontal) {
            return FormHelper::submit($caption, $options);
        }

        return '<div class="form-group"><div class="' . $this->_getColClass('offset') . ' ' . $this->_getColClass('input') . '">' . FormHelper::submit($caption, $options) . '</div></div>';
    }

    /** SPECIAL FORM **/

    /**
     *
     * Create a basic bootstrap search form.
     *
     * @param Model $model The model of the form
     * @param array $options The options that will be pass to the BootstrapForm::create method
     *
     * Extra options:
     *  - label: The input label (default false)
     *  - placeholder: The input placeholder (default "Search... ")
     *  - button: The search button text (default: "Search")
     * @return string
     **/
    public function searchForm($model = null, $options = [])
    {
        $label = $this->_extractOption('label', $options, false);
        unset($options['label']);
        $placeholder = $this->_extractOption('placeholder', $options, 'Search... ');
        unset($options['placeholder']);
        $button = $this->_extractOption('button', $options, 'Search');
        unset($options['button']);

        $output = '';

        $output .= $this->create($model, array_merge(['search' => true, 'inline' => (bool)$label], $options));
        $output .= $this->input('search', [
            'label' => $label,
            'placeholder' => $placeholder,
            'append' => [
                $this->button($button, ['style' => 'vertical-align: middle']),
            ],
        ]);
        $output .= $this->end();

        return $output;
    }

    /**
     * Returns an array of formatted OPTION/OPTGROUP elements
     *
     * @param array $elements Elements to format.
     * @param array $parents Parents for OPTGROUP.
     * @param bool $showParents Whether to show parents.
     * @param array $attributes HTML attributes.
     * @return array
     */
    protected function _selectOptions($elements = [], $parents = [], $showParents = null, $attributes = [])
    {
        $select = [];
        $attributes = array_merge(
            ['escape' => true, 'style' => null, 'value' => null, 'class' => null],
            $attributes
        );
        $selectedIsEmpty = ($attributes['value'] === '' || $attributes['value'] === null);
        $selectedIsArray = is_array($attributes['value']);

        // Cast boolean false into an integer so string comparisons can work.
        if ($attributes['value'] === false) {
            $attributes['value'] = 0;
        }

        $this->_domIdSuffixes = [];
        foreach ($elements as $name => $title) {
            $htmlOptions = [];
            if (is_array($title) && (!isset($title['name']) || !isset($title['value']))) {
                if (!empty($name)) {
                    if ($attributes['style'] === 'checkbox') {
                        $select[] = $this->Html->useTag('fieldsetend');
                    } else {
                        $select[] = $this->Html->useTag('optiongroupend');
                    }
                    $parents[] = $name;
                }
                $select = array_merge($select, $this->_selectOptions(
                    $title,
                    $parents,
                    $showParents,
                    $attributes
                ));

                if (!empty($name)) {
                    $name = $attributes['escape'] ? h($name) : $name;
                    if ($attributes['style'] === 'checkbox') {
                        $select[] = $this->Html->useTag('fieldsetstart', $name);
                    } else {
                        $select[] = $this->Html->useTag('optiongroup', $name, '');
                    }
                }
                $name = null;
            } elseif (is_array($title)) {
                $htmlOptions = $title;
                $name = $title['value'];
                $title = $title['name'];
                unset($htmlOptions['name'], $htmlOptions['value']);
            }

            if ($name !== null) {
                $isNumeric = is_numeric($name);
                if (
                    (!$selectedIsArray && !$selectedIsEmpty && (string)$attributes['value'] == (string)$name) ||
                    ($selectedIsArray && in_array((string)$name, $attributes['value'], !$isNumeric))
                ) {
                    if ($attributes['style'] === 'checkbox') {
                        $htmlOptions['checked'] = true;
                    } else {
                        $htmlOptions['selected'] = 'selected';
                    }
                }

                if ($showParents || (!in_array($title, $parents))) {
                    $title = ($attributes['escape']) ? h($title) : $title;

                    $hasDisabled = !empty($attributes['disabled']);
                    if ($hasDisabled) {
                        $disabledIsArray = is_array($attributes['disabled']);
                        if ($disabledIsArray) {
                            $disabledIsNumeric = is_numeric($name);
                        }
                    }
                    if (
                        $hasDisabled &&
                        $disabledIsArray &&
                        in_array((string)$name, $attributes['disabled'], !$disabledIsNumeric)
                    ) {
                        $htmlOptions['disabled'] = 'disabled';
                    }
                    if ($hasDisabled && !$disabledIsArray && $attributes['style'] === 'checkbox') {
                        $htmlOptions['disabled'] = $attributes['disabled'] === true ? 'disabled' : $attributes['disabled'];
                    }

                    if ($attributes['style'] === 'checkbox') {
                        $htmlOptions['value'] = $name;

                        $tagName = $attributes['id'] . $this->domIdSuffix($name);
                        $htmlOptions['id'] = $tagName;
                        $label = ['for' => $tagName];

                        if (isset($htmlOptions['checked']) && $htmlOptions['checked'] === true) {
                            $label['class'] = 'selected';
                        }

                        $name = $attributes['name'];

                        if (empty($attributes['class'])) {
                            $attributes['class'] = 'checkbox';
                        } elseif ($attributes['class'] === 'form-error') {
                            $attributes['class'] = 'checkbox ' . $attributes['class'];
                        }

                        // jmits nest checkbox input inside label
                        $item = $this->Html->useTag('checkboxmultiple', $name, $htmlOptions);

                        $label = $this->label(null, $item . $title, $label);

                        $select[] = $this->Html->div($attributes['class'], $label);
                    } else {
                        if ($attributes['escape']) {
                            $name = h($name);
                        }
                        $select[] = $this->Html->useTag('selectoption', $name, $htmlOptions, $title);
                    }
                }
            }
        }

        return array_reverse($select, true);
    }
}