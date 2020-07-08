<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View;

use App\View\Helper\HtmlHelper;
//use BootstrapUI\View\UIView;
use App\View\UIViewTrait;
use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    use UIViewTrait;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        /*$this->loadHelper('Html', [
            'className' => 'ToggenHtml',
        ]);*/

        $uiOptions = [
            'layout' => 'TwitterBootstrap/toggen-default',
        ];

        /**
         * if view is not default then assume it has been
         * set with $this->viewBuilder()->setLayout('customLayout');
         */
        if ($this->layout !== 'default') {
            $uiOptions = [
                'layout' => $this->layout,
            ];
        }

        $this->initializeUI($uiOptions);

        $this->loadHelper('Html', ['className' => 'App\View\Helper\HtmlHelper']);
        $this->loadHelper('Form', ['className' => 'App\View\Helper\FormHelper']);
        $this->loadHelper('Flash', ['className' => 'App\View\Helper\FlashHelper']);
        $this->loadHelper('Paginator', ['className' => 'BootstrapUI.Paginator']);
        $this->loadHelper('Authentication.Identity');
    }
}