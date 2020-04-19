<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use DateTimeZone;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id User id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Cartons'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $timezones = DateTimeZone::listIdentifiers(Configure::read('timezones'));

        $timezones = array_combine($timezones, $timezones);

        $roles = $this->Users->roleList(Configure::read('Users.roles'));
        $this->set(compact('user', 'timezones', 'roles'));
    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id User id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $timezones = DateTimeZone::listIdentifiers(Configure::read('timezones'));

        $timezones = array_combine($timezones, $timezones);
        $roles = $this->Users->roleList(Configure::read('Users.roles'));
        $this->set(compact('user', 'timezones', 'roles'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id User id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        // $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($this->request->is('POST')) {
            // regardless of POST or GET, redirect if user is logged in
            if ($result->isValid()) {
                // redirect to /articles after login success
                $redirect = $this->request->getQuery('redirect', [
                    'controller' => 'Pages',
                    'action' => 'display',
                    'index',
                ]);
                /*     if ((bool) $this->request->getData()['remember-me'] === true) {
                        $this->response = $this->response->withCookie(
                            new Cookie(
                                'remember-me',
                                [
                                    'remember-me' => 1,
                                    'username' => $this->request->getData()['username'],
                                ]
                            )
                        );
                    } else {
                        $cookies = $this->request->getCookieCollection();
                        if ($cookies->has('remember-me')) {
                            $this->response = $this->response->withCookie(
                                ( new Cookie('remember-me', '', (   new \DateTime())->setDate(1973, 1, 31)))
                            );
                        }
                    } */

                return $this->redirect($redirect);
            } else {
                $this->Flash->error(__('Invalid username or password'));
            }
        }

        /*  $rememberMe = false;
         $username = '';

         if ($this->request->is('GET')) {
             $rememberMe = $this->request->getCookie('remember-me');

             if (isset($rememberMe['username'])) {
                 $username = $rememberMe['username'];
                 $this->set('username', $username);
             }
         } */

        // display error if user submitted and authentication failed

        //$this->set(compact('rememberMe'));
    }

    public function logout()
    {
        // $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();

        $redirect = $this->request->getQuery('redirect', '/');

        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $redirect = $this->Authentication->logout();
            $this->Flash->success('You are logged out');

            return $this->redirect($redirect);
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'login',
            '?' => [
                'redirect' => urldecode($redirect),
            ],
        ]);
    }

    public function accessDenied()
    {
        $result = $this->Authentication->getResult();
        $redirect = $this->request->getQuery('redirect', '/');
        if ($result->isValid()) {
            $msg = '<span class="h6">Access restricted</span>';
            $msg .= '<p class="mt-2">Your account does not have ';
            $msg .= 'permission to perform that function or access that location</p>';
            $msg .= '<p>You need to log out and then log in with an account with sufficient permissions</p>';

            $this->Flash->warning($msg, ['escape' => false]);

            //return $this->redirect($redirect);
        }
        $this->set(compact('redirect'));
    }
}