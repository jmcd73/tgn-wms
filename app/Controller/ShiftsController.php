<?php
App::uses('AppController', 'Controller');
/**
 * Shifts Controller
 *
 * @property Shift $Shift
 * @property PaginatorComponent $Paginator
 */
class ShiftsController extends AppController
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
        // Allow users to register and logout.
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Shift->recursive = 0;
        $this->set('shifts', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id ID of shift record
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Shift->exists($id)) {
            throw new NotFoundException(__('Invalid shift'));
        }
        $options = ['conditions' => ['Shift.' . $this->Shift->primaryKey => $id]];
        $this->set('shift', $this->Shift->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Shift->create();
            if ($this->Shift->save($this->request->data)) {
                $this->Flash->success(__('The shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shift could not be saved. Please, try again.'));
            }
        }
        $productTypes = $this->Shift->ProductType->find('list');
        $this->set(compact('productTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param int $id Id of shift record
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->Shift->exists($id)) {
            throw new NotFoundException(__('Invalid shift'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Shift->save($this->request->data)) {
                $this->Flash->success(__('The shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The shift could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Shift.' . $this->Shift->primaryKey => $id]];
            $this->request->data = $this->Shift->find('first', $options);
        }

        $productTypes = $this->Shift->ProductType->find('list');
        $this->set(compact('productTypes'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param int $id Id of shift record
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->Shift->id = $id;
        if (!$this->Shift->exists()) {
            throw new NotFoundException(__('Invalid shift'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Shift->delete()) {
            $this->Flash->success(__('The shift has been deleted.'));
        } else {
            $this->Flash->error(__('The shift could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}