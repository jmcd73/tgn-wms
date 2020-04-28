<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


App::uses('BootstrapNavbarHelper', 'Bootstrap3.View/Helper') ;

class NavBarHelper extends BootstrapNavbarHelper {

    public $helpers = ['Html'] ;

    private $options = [] ;
    private $fixed = false ;
    private $static = false ;
    private $responsive = false ;
    private $inverse = false ;
	private $fluid = false;

    /** Specify if we are currently in a submenu or not. If in submenu,
    this must be an array like: array('name' => '', 'url' => '', 'menu' => array()). **/
    private $currentMenu = null ;
    /** Same but for hover menu. **/
    private $currentSubMenu = null ;

    private $brand = null ;
    private $navs =  [] ;

    /**
     *
     * Create a new navbar.
     *
     * @param options Options passed to tag method for outer navbar div
     *
     * Extra options:
     *  - fixed: false, 'top', 'bottom'
     *  - static: false, true (useless if fixed != false)
     *  - responsive: false, true
     *  - inverse: false, true
     *  - fluid: false, true
     *
    **/
    public function create ($options = []) {
        $this->fixed = $this->_extractOption('fixed', $options, false) ;
        unset($options['fixed']) ;
        $this->responsive = $this->_extractOption('responsive', $options, false) ;
        unset($options['responsive']) ;
        $this->static = $this->_extractOption('static', $options, false) ;
        unset($options['static']) ;
        $this->inverse = $this->_extractOption('inverse', $options, false) ;
        unset($options['inverse']) ;
	$this->fluid = $this->_extractOption('fluid', $options, false);
	unset($options['fluid']);
        $this->options = $options ;
    }

    /**
     *
     * Create the brand link of the navbar.
     *
     * @param name The brand link text
     * @param url The brand link URL (default '/')
     * @param collapse true if you want the brand to be collapsed
     *      with responsive design (default false)
     * @param options Options passed to link method
     *
    **/
    public function brand ($name, $url = '/', $collapse = false, $options = []) {
        $this->brand = [
            'text' => $name,
            'url' => $url,
            'collapse' => $collapse,
            'options' => $options
        ] ;
    }

    /**
     *
     * Functions below accept following options:
     *
     *   - disabled (default false)
     *   - active (default auto)
     *   - pull (default auto)
     *
    **/

    /**
     *
     * Add a link to the navbar or to a menu.
     *
     * @param name The link text
     * @param url The link URL
     * @param options Options passed to link method (+ extra options, see above)
     *
    **/
    public function link ($name, $url, $options = []) {
        $value = [
            'text' => $name,
            'url' => $url
        ] ;
        $this->_addToCurrent('link', $value, $options) ;
    }

    /**
     *
     * Add a divider to the navbar or to a menu.
     *
    **/
    public function divider () {
        $this->_addToCurrent('divider', [], []) ;
    }

    /**
     *
     * Add a text to the navbar or to a menu.
     *
     * @param text The text message
     * @param options Options passed to the tag method (+ extra options, see above)
     *
     * Extra options:
     *  - wrap The HTML tag to use (default p)
     *
    **/
    public function text ($text, $options = []) {
        $tag = $this->_extractOption('wrap', $options, 'p') ;
        unset($options['wrap']) ;
        $value = [
            'wrap' => $tag,
            'text' => $text,
        ] ;
        $this->_addToCurrent('text', $value, $options) ;
    }

    /**
     *
     * Add a HTML block to the navbar.
     *
     * @param block The HTML block to add
     *
     * Extra options:
     *  - list true/false (default true), specify if block should be wrap in a "li" tag, only
     *      work on main nav (in submenu, block are always wrapped in a li tag)
     *
    **/
    public function block ($block, $options = []) {
        $list = $this->_extractOption('list', $options, true) ;
        unset ($options['list']) ;
        $value = [
            'text' => $block,
            'list' => $list
        ] ;
        $this->_addToCurrent('block', $value, $options) ;
    }

    /**
     *
     * Add a serach form to the navbar.
     *
     * @param block The HTML block to add
     * @param options
     *
     * Extra options:
     *  - form Extra options for BootstrapFormHelper::searchForm options
     *  - pull left/right (default left)
     *  - model Model for BootstrapFormHelper::searchForm method
     *
    **/
    public function searchForm ($options = []) {
        App::import('Helper', 'BootstrapForm') ;
        $bootFormHelper = new BootstrapFormHelper($this->_View);
        $formOptions = $this->_extractOption('form', $options, []) ;
        unset($formOptions['form']) ;
        $pull = $this->_extractOption('pull', $options, 'left') ;
        unset($options['pull']) ;
        $model = $this->_extractOption('model', $options, null) ;
        unset($options['model']) ;
        $formOptions = $this->addClass($formOptions, 'navbar-form pull-'.$pull) ;
        $this->block($bootFormHelper->searchForm($model, $formOptions), ['list' => false]) ;
    }

    /**
     *
     * Start a new menu, 2 levels: If not in submenu, create a dropdown menu,
     * oterwize create hover menu.
     *
     * @param name The name of the menu
     * @param url A URL for the menu (default null)
     * @param options Options passed to the tag method (+ extra options, see above)
     *
    **/
    public function beginMenu ($name, $url = null, $options = []) {
        $default = [
            'type' => 'menu',
            'text' => $name,
            'url' => $url,
            'menu' => []
        ] ;
        $value = array_merge($this->_extractValue($options), $default) ;
        if ($this->currentMenu === null) {
            $this->currentMenu = $value ;
        }
        else if ($this->currentSubMenu === null) {
            $value['type'] = 'smenu' ;
            $this->currentSubMenu = $value ;
        }
    }

    /**
     *
     * End a menu.
     *
    **/
    public function endMenu () {
        if ($this->currentSubMenu !== null) {
            $this->currentMenu['menu'][] = $this->currentSubMenu ;
            $this->currentSubMenu = null ;
        }
        else if ($this->currentMenu !== null) {
            $this->navs[] = $this->currentMenu ;
            $this->currentMenu = null ;
        }
    }

    /**
     *
     * End a navbar.
     *
     * @param compile If true, compile the navbar and return
     *
    **/
    public function end ($compile = false) {

        if ($compile) {
            return $this->compile () ;
        }
    }

    /**
     *
     * Compile a navigation block.
     *
     * @param nav Array (type, active, pull, disabled, options, ...)
     *
     * @return array(
     *      inner => Inner HTML for li tag
     *      class => Extra class for li tag
     *      active => Active element
     *      disabled => disabled element
     * )
     *
    **/
    private function __compileNavBlock ($nav) {
        $inner = '' ;
        $class = '' ;
        switch ($nav['type']) {
        case 'text':
            //$nav['options'] = $this->addClass($nav['options'], 'navbar-text') ;
            $inner = $this->Html->tag($nav['wrap'], $nav['text'], $nav['options']) ;
        break ;
        case 'link':
            $active = $nav['active'] === 'auto' ?
                Router::url() === Router::normalize($nav['url']) : $nav['active'] ;
            $disabled = $nav['disabled'] ;
            $inner = $this->Html->link($nav['text'], $nav['url'], $nav['options']) ;
        break ;
        case 'menu':
        case 'smenu':
            $res = $this->compileMenu($nav) ;
            $inner = $res['inner'] ;
            $active = $nav['active'] === 'auto' ? $res['active'] : $nav['active'] ;
            $disabled = $nav['disabled'] ;
            $class = $res['class'];
        break ;
        case 'block':
            $inner = $nav['text'] ;
            break ;
        case 'divider':
            $class = 'divider' ;
        break ;
        }
        return [
            'inner' => $inner,
            'class' => $class,
            'active' => isset($active) && $active,
            'disabled' => isset($disabled) && $disabled
        ] ;
    }

    /**
     *
     * Compile a menu.
     *
     * @param menu array(type, pull, url, text, menu)
     *
     * @return array(
     *      inner => Inner HTML for li tag
     *      class => Extra class for li tag
     *      active => Active element
     *      disabled => disabled element
     * )
     *
    **/
    private function compileMenu ($menu) {
        if ($menu['type'] === 'menu') {
            $button = $this->Html->link($menu['text'].'<span class="caret"></span>', $menu['url'] ? $menu['url'] : '#', [
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'escape' => false
            ]) ;
        }
        else {
            $button = $this->Html->link($menu['text'], $menu['url'] ? $menu['url'] : '#', [
                'tabindex' => -1
            ]) ;
        }
        $active = false ;
        $link = [] ;
        foreach ($menu['menu'] as $m) {
            $res = $this->__compileNavBlock($m) ;
            if ($res['active']) {
                $active = true ;
                $res = $this->addClass($res, 'active') ;
            }
            $link[] = $this->Html->tag('li', $res['inner'], $res['class'] ? ['class' => $res['class']] : []) ;
        }
        $list = $this->Html->tag('ul', implode('', $link), [
            'class' => 'dropdown-menu'
        ]) ;
        $class = ($menu['type'] === 'menu') ? 'dropdown' : 'dropdown-submenu' ;
        if ($menu['pull'] !== 'auto') {
            $class .= ' pull-'.$menu['pull'] ;
        }
        return [
            'active' => $active,
            'inner' => $button.$list,
            'class' => $class,
            'disabled' => $menu['disabled']
        ] ;
    }
    /**
     * returns a space separated list of classes
     * @param array $default
     * @param array $added
     * @return string
     */

    private function _mergeClasses($default, $added){

        $def = array_key_exists('class', $default) ? $default['class'] : null;
        $add = array_key_exists('class', $added) ? $added['class'] : null;

        $merge = $add !== null ? $def . ' ' . $add : $def;

        $merged = explode(' ', $merge);

        // dedup
        foreach(array_values($merged) as $k => $v){
            $classes[$v] = null;
        }

        return implode(' ', array_keys($classes));

    }

    /**
     * Allows the brand to be an image by allowing options other than the default
     * Return the html link for the brand
     * @return string
     */
    private function _createBrand() {

        $default = ['class' => 'navbar-brand'];

        $options = $this->brand['options'];

        $options['class'] = $this->_mergeClasses($default, $options);

        return $this->Html->link($this->brand['text'], $this->brand['url'], $options );

    }

    /**
     *
     * Compile and returns the current navbar.
     *
     * @return string The navbar (HTML string)
     *
    **/
    public function compile () {
        $htmls = [] ;
        $ul = false ;
        foreach ($this->navs as $nav) {
            /* Extra check for block... */
            if ($nav['type'] === 'block' && $nav['list'] === false) {
                if ($ul) {
                    $htmls[] = '</ul>' ;
                    $ul = false ;
                }
                $htmls[] = $nav['text'] ;
                continue ;
            }
            if ($ul && $nav['pull'] != 'auto' && $nav['pull'] != $ul) {
                $htmls[] = '</ul>' ;
                $ul = false ;
            }
            if (!$ul && $nav['pull'] === 'auto') {
                $ul = 'left' ;
                $htmls[] = '<ul class="nav navbar-nav">' ;
            }
            if (!$ul && $nav['pull'] !== 'auto') {
                $ul = $nav['pull'] ;
                $htmls[] = '<ul class="nav navbar-nav navbar-'.$nav['pull'].'">' ;
            }

            $res = $this->__compileNavBlock($nav) ;

            $options = ['class' => $res['class']] ;
            if ($res['active']) {
                $options = $this->addClass($options, 'active') ;
            }
            if ($res['disabled']) {
                $options = $this->addClass($options, 'disabled') ;
            }

            if (empty($options['class'])){
                unset($options['class']);
            }
            $htmls[] = $this->Html->tag('li', $res['inner'], $options) ;
        }
        if ($ul) {
            $ul = false ;
            $htmls[] = '</ul>' ;
        }

        /** Generate options for outer div. **/
        $this->options = $this->addClass($this->options, 'navbar navbar-default') ;
        if ($this->fixed !== false) {
            $this->options = $this->addClass($this->options, 'navbar-fixed-'.$this->fixed) ;
        }
        else if ($this->static !== false) {
            $this->options = $this->addClass($this->options, 'navbar-static-top') ;
        }
        if ($this->inverse !== false) {
            $this->options = $this->addClass($this->options , 'navbar-inverse') ;
        }

        $inner = '' ;

        $brand = $this->brand !== null ?
            $this->_createBrand($this->brand) : null ;
        $inner = implode('', $htmls) ;

        if ($this->responsive) {
            $button = $this->Html->tag('button',
                implode('', [
                    $this->Html->tag('span', __('Toggle navigation'), ['class' => 'sr-only']),
                    $this->Html->tag('span', '', ['class' => 'icon-bar']),
                    $this->Html->tag('span', '', ['class' => 'icon-bar']),
                    $this->Html->tag('span', '', ['class' => 'icon-bar'])
                ]),
                [
                    'type' => 'button',
                    'class' => 'navbar-toggle collapsed',
                    'data-toggle' => 'collapse',
                    'data-target' => '.navbar-collapse'
                ]
            ) ;
            if ($this->brand !== null && $this->brand['collapse']) {
                $inner = $brand.$inner ;
            }
            $inner = $this->Html->tag('div', $inner, ['class' => 'navbar-collapse collapse']) ;

            $header = '' ;

            if ($this->brand !== null && !$this->brand['collapse']) {
                $header = $brand ;
            }
            $header = $this->Html->tag('div', $button.$header, ['class' => 'navbar-header']) ;
            $inner = $header.$inner ;
        }
        else if ($this->brand !== null) {
            $inner = $brand.$inner ;
        }

        /** Add container. **/
		$container_class = $this->fluid? 'container-fluid' : 'container';
        $inner = $this->Html->tag('div', $inner, ['class' => $container_class]) ;

        /** Add and return outer div. **/
        return $this->Html->tag('nav', $inner, $this->options) ;

    }

    /**
     *
     * Extract options from $options, returning $default if $key is not found.
     *
    **/
    protected function _extractOption ($key, $options, $default = null) {
        if (isset($options[$key])) {
            return $options[$key] ;
        }
        return $default ;
    }

    /**
     *
     * Extract navbar values from $options.
     *
    **/
    protected function _extractValue ($options) {
        $value =  [] ;
        $value['pull'] = $this->_extractOption('pull', $options, 'auto') ;
        unset ($options['pull']) ;
        $value['disabled'] = $this->_extractOption('disabled', $options, false) ;
        unset ($options['disabled']) ;
        $value['active'] = $this->_extractOption('disabled', $options, 'auto') ;
        unset ($options['active']) ;
        $value['options'] = $options ;
        return $value ;
    }

    /**
     *
     * Add navbar block to current nav (navs, dropdownMenu, hoverMenu).
     *
    **/
    protected function _addToCurrent ($type, $value, $options = []) {
        $value = array_merge($this->_extractValue($options), $value) ;
        $value['type'] = $type ;
        if ($this->currentSubMenu !== null) {
            $this->currentSubMenu['menu'][] = $value ;
        }
        else if ($this->currentMenu !== null) {
            $this->currentMenu['menu'][] = $value ;
        }
        else {
            $this->navs[] = $value ;
        }
    }


}