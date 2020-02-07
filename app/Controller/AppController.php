<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @package       app.Controller
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeTime', 'Utility');
App::uses('MissingItemException', 'Lib/Exception');
App::uses('MissingConfigurationException', 'Lib/Exception');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * If you run getHelpPage when Debug_Kit is trying to get
     * History it will fail
     * Also getHelpPage is not relavent to menus/buildMenu
     *
     * @var $controllerActionsToSkip
     *
     * [ 'controller' => 'action' ]
     *
     */
    protected $controllerActionsToSkip = [
        'menus' => 'buildMenu',
        'toolbar_access' => 'history_state',
    ];
    /**
     * @var array
     */
    public $components = [
        'RequestHandler',
        'Flash',
        /*  'Security' => [
            'csrfExpires' => '+1 hour',
        ], */
        'Auth' => [
            'loginRedirect' => [
                'controller' => 'pages',
                'action' => 'display',
                'index',
            ],
            'logoutRedirect' => [
                'controller' => 'pages',
                'action' => 'display',
                'index',
            ],
            'authorize' => ['Controller'],
            'flash' => [
                'key' => 'auth',
                'element' => 'error',
            ],
            'authError' => 'You cannot access that function without the correct permission.',
            'authenticate' => [
                'Form' => [
                    'passwordHasher' => 'Blowfish',
                ],
            ],
        ],
    ];

    /**
     * Added to allow dynamic addition of DebugKit.Toolbar
     * @param CakeRequest $request Cake Request
     * @param CakeResponse $response Cake Response
     * @return void
     */
    public function __construct($request = null, $response = null)
    {
        //Load DebugKit is is necessary
        //$this->components = $this->defaultComponents;
        if (getenv('CAKEPHP_DEBUG')) {
            $this->components[] = 'DebugKit.Toolbar';
        }

        parent::__construct($request, $response);
    }

    // make the settings table available from all controllers
    /**
     * @var array
     */
    public $uses = ['Setting'];

    // enable Time
    // 'Form', 'Html',
    /**
     * @var array
     */
    public $helpers = [
        'Time',
        'Nav' => [
            'className' => 'NavBar', // extends BootstrapNavbarHelper
        ],
        'Html' => [
            'className' => 'ToggenHtml',
        ],
        'Form' => [
            'className' => 'ToggenForm',
        ],
        'Modal' => [
            'className' => 'Bootstrap3.BootstrapModal',
        ],
    ];

    /**
     * BeforeFilter
     *
     * @return void
     */
    public function beforeFilter()
    {
        if (isset($this->request->params['requested'])) {
            $this->Auth->allow($this->request->action);
        }

        //allow everything by default
        $this->Auth->allow();

        if ((bool)AuthComponent::user()) {
            $user = $this->Auth->user();
            $this->set(compact('user'));
        }

        $companyName = Configure::read('companyName');

        $this->set(compact('companyName'));

        $this->set('isLoggedIn', $this->Auth->user() !== null);

        if ($this->allowGetHelpPage($this->request)) {
            $controllerAction = $this->request->controller . 'Controller::' . $this->request->action;

            $this->set(
                'helpPage',
                $this->{$this->modelClass}
                     ->getHelpPage($controllerAction)
            );
        }
    }

    protected function allowGetHelpPage($request)
    {
        $controller = $request->controller;
        $action = $request->action;

        if ($request->is(['PUT', 'POST'])) {
            return false;
        }

        foreach ($this->controllerActionsToSkip as $key => $value) {
            if ($controller === $key && $action === $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * formats date as YYmmdd
     * @param string $date Date string
     * @param string $format PHP date format
     * @return date
     */
    public function formatYymmdd($date, $format = '%y%m%d')
    {
        return CakeTime::format($date, $format);
    }

    /**
     * isAuthorized
     * @param array $user User array object
     * @return bool
     */
    public function isAuthorized($user)
    {
        // Admin can access every action

        $allowed_actions = ['view', 'display'];

        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // allow all
        if (in_array($this->request->action, $allowed_actions)) {
            return true;
        }

        // Default deny
        $this->Flash->set('Access Denied', ['key' => 'auth', 'element' => 'error']);

        return false;
    }

    /**
     * getSetting
     * makes getSetting available to all controllers via $this->getSetting
     * and passes it to the corresponding model method
     *
     * @param string $settingName specify the value from the settings.name field
     * @param bool    $inComment whether the setting value is in the setting or comment field in settings table
     *
     * @return mixed
     */
    public function getSetting($settingName, $inComment = false)
    {
        return $this->{$this->modelClass}->getSetting($settingName, $inComment);
    }
}