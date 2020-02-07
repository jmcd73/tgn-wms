<?php
App::uses('AppController', 'Controller');
/**
 * Printers Controller
 *
 * @property Printer $Printer
 * @property PaginatorComponent $Paginator
 * @property CrtlComponent $Ctrl
 */
class PrintersController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'Ctrl'];

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Printer->recursive = 0;
        $this->set('printers', $this->Paginator->paginate());
        $cupsUrl = $this->Printer->getCupsURL($this->request);

        $this->set(compact('cupsUrl'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id ID of Printer
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Printer->exists($id)) {
            throw new NotFoundException(__('Invalid printer'));
        }
        $options = ['conditions' => ['Printer.' . $this->Printer->primaryKey => $id]];
        $this->set('printer', $this->Printer->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Printer->create();
            if ($this->Printer->save($this->request->data)) {
                $this->Flash->success(__('The printer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The printer could not be saved. Please, try again.'));
            }
        }

        $localPrinters = $this->Printer->getLocalPrinterList();

        $cupsUrl = $this->Printer->getCupsURL($this->request);

        $controllers = $this->Ctrl->formatForPrinterViews($showSelected = true);
        $this->set(compact('controllers', 'localPrinters', 'cupsUrl'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID of Printer
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->Printer->exists($id)) {
            throw new NotFoundException(__('Invalid printer'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Printer->save($this->request->data)) {
                $this->Flash->success(__('The printer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The printer could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Printer.' . $this->Printer->primaryKey => $id]];
            $this->request->data = $this->Printer->find('first', $options);
        }
        $controllers = $this->Ctrl->formatForPrinterViews($showSelected = true);
        $localPrinters = $this->Printer->getLocalPrinterList();
        $cupsUrl = $this->Printer->getCupsURL($this->request);
        $this->set(compact('controllers', 'localPrinters', 'cupsUrl'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id ID to Delete
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!$this->Printer->exists($id)) {
            throw new NotFoundException(__('Invalid printer'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Printer->delete($id)) {
            $this->Flash->success(__('The printer has been deleted.'));
        } else {
            $this->Flash->error(__('The printer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}