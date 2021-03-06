<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Database\Query;
use Cake\Event\EventInterface;

use App\Lib\Utility\SettingsTrait;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    use LocatorAwareTrait;
    use SettingsTrait;

    public $companyName = '';

    protected $controllerActionsToSkip = [
        'menus::buildMenu',
        'toolbar_access::history_state',
        //'Pages' => 'display',
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $ctrlSettings = Configure::read('Ctrl.printControllersActions');

        $this->companyName = $this->getSetting('COMPANY_NAME');
        
        $this->loadComponent('Ctrl', $ctrlSettings);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
        $this->loadModel('Menus');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $result = $this->Authentication->getResult();

        $isAdmin = false;

        if ($result->isValid()) {
            $user = $this->Authentication->getIdentity();

            $isAdmin = $this->isAdmin($user);

            $this->set(compact('user'));
        }

        $menuTree = $this->getMenuTree();

        $companyName = $this->companyName;

        $this->set(compact('menuTree', 'companyName'));

        $controllerAction = $this->getControllerAction();

        if ($this->allowGetHelpPage($controllerAction)) {
            $helpTable = $this->getTableLocator()->get('Help');

            $this->set(
                'helpPage',
                $helpTable
                     ->getHelpPage($controllerAction)
            );
        }
        $this->set(compact('isAdmin'));
    }

    protected function allowGetHelpPage($controllerAaction)
    {
        if ($this->request->is(['PUT', 'POST'])) {
            return false;
        }

        return !in_array($controllerAaction, $this->controllerActionsToSkip);
    }

    public function getControllerAction()
    {
        return $this->request->getParam('controller') . '::' . $this->request->getParam('action');
    }

    public function isAdmin($user)
    {
        $adminRole = Configure::read('Users.admin_role');

        return $user->role === $adminRole;
    }

    public function getMenuTree(): Query
    {
        return $this->Menus->find('threaded')
            ->where([
                'active' => 1,
            ])->orderAsc('lft');
    }
}