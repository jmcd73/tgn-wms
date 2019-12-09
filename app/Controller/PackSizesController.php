<?php
App::uses('AppController', 'Controller');
/**
 * PackSizes Controller
 *
 * @property PackSize $PackSize
 * @property PaginatorComponent $Paginator
 */
class PackSizesController extends AppController
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
        $this->PackSize->recursive = 0;
        $this->set('packSizes', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id ID of Pack size record
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->PackSize->exists($id)) {
            throw new NotFoundException(__('Invalid pack size'));
        }
        $options = ['conditions' => ['PackSize.' . $this->PackSize->primaryKey => $id]];
        $this->set('packSize', $this->PackSize->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->PackSize->create();
            if ($this->PackSize->save($this->request->data)) {
                $this->Flash->success(__('The pack size has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pack size could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param int $id ID of pack size record
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->PackSize->exists($id)) {
            throw new NotFoundException(__('Invalid pack size'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->PackSize->save($this->request->data)) {
                $this->Flash->success(__('The pack size has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pack size could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['PackSize.' . $this->PackSize->primaryKey => $id]];
            $this->request->data = $this->PackSize->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param int $id ID of pack size record
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->PackSize->id = $id;
        if (!$this->PackSize->exists()) {
            throw new NotFoundException(__('Invalid pack size'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->PackSize->delete()) {
            $this->Flash->success(__('The pack size has been deleted.'));
        } else {
            $this->Flash->error(__('The pack size could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}