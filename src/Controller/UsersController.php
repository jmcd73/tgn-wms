<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use DateTimeZone;

/**
 * Users Controller
 *
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication Auth component
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
        $viewUser = $this->Users->get($id, [
            'contain' => ['Cartons'],
        ]);

        $this->set('viewUser', $viewUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $newUser = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $newUser = $this->Users->patchEntity($newUser, $this->request->getData());
            if ($this->Users->save($newUser)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $timezones = DateTimeZone::listIdentifiers(Configure::read('timezones'));

        $timezones = array_combine($timezones, $timezones);

        $roles = $this->Users->roleList(Configure::read('Users.roles'));
        $this->set(compact('newUser', 'timezones', 'roles'));
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
        $editUser = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eidtUser = $this->Users->patchEntity($editUser, $this->request->getData());
            if ($this->Users->save($editUser)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $timezones = DateTimeZone::listIdentifiers(Configure::read('timezones'));

        $timezones = array_combine($timezones, $timezones);
        $roles = $this->Users->roleList(Configure::read('Users.roles'));
        $this->set(compact('editUser', 'timezones', 'roles'));
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

                $target = $this->Authentication->getLoginRedirect();

                if (!$target) {
                    $target = ['controller' => 'Pages', 'action' => 'display', 'index'];
                }

                return $this->redirect($target);
            } else {
                $this->Flash->error(__('Invalid username or password'));
            }
        }
    }

    public function logout()
    {
        // $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();

        // $redirect = $this->request->getQuery('redirect', '/');

        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success('You are logged out');
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
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
