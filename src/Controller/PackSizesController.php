<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PackSizes Controller
 *
 * @property \App\Model\Table\PackSizesTable $PackSizes
 *
 * @method \App\Model\Entity\PackSize[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PackSizesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $packSizes = $this->paginate($this->PackSizes);

        $this->set(compact('packSizes'));
    }

    /**
     * View method
     *
     * @param string|null $id Pack Size id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $packSize = $this->PackSizes->get($id, [
            'contain' => ['Items'],
        ]);

        $this->set('packSize', $packSize);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $packSize = $this->PackSizes->newEmptyEntity();
        if ($this->request->is('post')) {
            $packSize = $this->PackSizes->patchEntity($packSize, $this->request->getData());
            if ($this->PackSizes->save($packSize)) {
                $this->Flash->success(__('The pack size has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pack size could not be saved. Please, try again.'));
        }
        $this->set(compact('packSize'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pack Size id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $packSize = $this->PackSizes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $packSize = $this->PackSizes->patchEntity($packSize, $this->request->getData());
            if ($this->PackSizes->save($packSize)) {
                $this->Flash->success(__('The pack size has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pack size could not be saved. Please, try again.'));
        }
        $this->set(compact('packSize'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pack Size id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $packSize = $this->PackSizes->get($id);
        if ($this->PackSizes->delete($packSize)) {
            $this->Flash->success(__('The pack size has been deleted.'));
        } else {
            $this->Flash->error(__('The pack size could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
