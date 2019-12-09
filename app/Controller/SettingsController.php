<?php
App::uses('AppController', 'Controller');
/**
 * Settings Controller
 *
 * @property Setting $Setting
 * @property PaginatorComponent $Paginator
 */
class SettingsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * beforeFilter
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->deny();
        $this->Auth->allow('customPrint', 'sampleLabels');
    }

    /**
     * @param array $user User array object
     * @return bool
     */
    public function isAuthorized($user)
    {
        // Admin can access every action

        $allowed_actions = ['customPrint', 'sampleLabels'];

        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // allow all
        if (in_array($this->request->action, $allowed_actions)) {
            return true;
        }

        // Default deny

        return false;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Setting->recursive = 0;
        $this->set('settings', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id ID of Setting
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Setting->exists($id)) {
            throw new NotFoundException(__('Invalid setting'));
        }
        $options = ['conditions' => ['Setting.' . $this->Setting->primaryKey => $id]];
        $this->set('setting', $this->Setting->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Setting->create();
            if ($this->Setting->save($this->request->data)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The setting could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param int $id Setting ID
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->Setting->exists($id)) {
            throw new NotFoundException(__('Invalid setting'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Setting->save($this->request->data)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The setting could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Setting.' . $this->Setting->primaryKey => $id]];
            $this->request->data = $this->Setting->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param int $id Setting ID
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->Setting->id = $id;
        if (!$this->Setting->exists()) {
            throw new NotFoundException(__('Invalid setting'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Setting->delete()) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}