<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * beforeFilter method
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->deny('index', 'view', 'add', 'delete', 'edit');
        $this->Auth->allow('logout');
    }

    /**
     * @param array $user User object
     * @return bool from parent
     */
    public function isAuthorized($user)
    {
        return parent::isAuthorized($user);
    }

    /**
     * @return mixed
     */
    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id ID of User
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = ['conditions' => ['User.' . $this->User->primaryKey => $id]];

        $user = $this->User->find('first', $options);

        $this->set('user', $user);
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }

        $roles = Configure::read("Users.roles");
        $this->set(compact('roles'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID of User
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['User.' . $this->User->primaryKey => $id]];
            $this->request->data = $this->User->find('first', $options);
        }

        $roles = Configure::read("Users.roles");
        $this->set(compact('roles'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id ID of User Record to Delete
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
