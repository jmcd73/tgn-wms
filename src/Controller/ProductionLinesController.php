<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductionLines Controller
 *
 * @property \App\Model\Table\ProductionLinesTable $ProductionLines
 *
 * @method \App\Model\Entity\ProductionLine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductionLinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Printers', 'ProductTypes'],
        ];
        $productionLines = $this->paginate($this->ProductionLines);

        $this->set(compact('productionLines'));
    }

    /**
     * View method
     *
     * @param string|null $id Production Line id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productionLine = $this->ProductionLines->get($id, [
            'contain' => ['Printers', 'ProductTypes', 'Labels', 'Pallets'],
        ]);

        $this->set('productionLine', $productionLine);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productionLine = $this->ProductionLines->newEmptyEntity();
        if ($this->request->is('post')) {
            $productionLine = $this->ProductionLines->patchEntity($productionLine, $this->request->getData());
            if ($this->ProductionLines->save($productionLine)) {
                $this->Flash->success(__('The production line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The production line could not be saved. Please, try again.'));
        }
        $printers = $this->ProductionLines->Printers->find('list', ['limit' => 200]);
        $productTypes = $this->ProductionLines->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('productionLine', 'printers', 'productTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Production Line id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productionLine = $this->ProductionLines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productionLine = $this->ProductionLines->patchEntity($productionLine, $this->request->getData());
            if ($this->ProductionLines->save($productionLine)) {
                $this->Flash->success(__('The production line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The production line could not be saved. Please, try again.'));
        }
        $printers = $this->ProductionLines->Printers->find('list', ['limit' => 200]);
        $productTypes = $this->ProductionLines->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('productionLine', 'printers', 'productTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Production Line id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productionLine = $this->ProductionLines->get($id);
        if ($this->ProductionLines->delete($productionLine)) {
            $this->Flash->success(__('The production line has been deleted.'));
        } else {
            $this->Flash->error(__('The production line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
