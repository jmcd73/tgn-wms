<?php
App::uses('AppController', 'Controller');
/**
 * ProductionLines Controller
 *
 * @property ProductionLine $ProductionLine
 * @property PaginatorComponent $Paginator
 */
class ProductionLinesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->ProductionLine->recursive = 0;
        $this->set('productionLines', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id Production Line ID
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->ProductionLine->exists($id)) {
            throw new NotFoundException(__('Invalid production line'));
        }
        $options = ['conditions' => ['ProductionLine.' . $this->ProductionLine->primaryKey => $id]];
        $this->set('productionLine', $this->ProductionLine->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->ProductionLine->create();
            if ($this->ProductionLine->save($this->request->data)) {
                $this->Flash->success(__('The production line has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The production line could not be saved. Please, try again.'));
            }
        }
        $printers = $this->ProductionLine->Printer->find('list');
        $productTypes = $this->ProductionLine->ProductType->find('list');
        $this->set(compact(
            'productTypes',
            'printers'
        ));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param int $id ID of Production Line Record
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->ProductionLine->exists($id)) {
            throw new NotFoundException(__('Invalid production line'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->ProductionLine->save($this->request->data)) {
                $this->Flash->success(__('The production line has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The production line could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['ProductionLine.' . $this->ProductionLine->primaryKey => $id]];
            $this->request->data = $this->ProductionLine->find('first', $options);
        }
        $printers = $this->ProductionLine->Printer->find('list');

        $productTypes = $this->ProductionLine->ProductType->find('list');
        $this->set(compact(
            'productTypes',
            'printers'
        ));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param int $id ID of Production Line Record
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!$this->ProductionLine->exists($id)) {
            throw new NotFoundException(__('Invalid production line'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->ProductionLine->delete($id)) {
            $this->Flash->success(__('The production line has been deleted.'));
        } else {
            $this->Flash->error(__('The production line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
