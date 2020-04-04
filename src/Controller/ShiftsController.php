<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Shifts Controller
 *
 * @property \App\Model\Table\ShiftsTable $Shifts
 *
 * @method \App\Model\Entity\Shift[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShiftsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductTypes'],
        ];
        $shifts = $this->paginate($this->Shifts);

        $this->set(compact('shifts'));
    }

    /**
     * View method
     *
     * @param string|null $id Shift id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shift = $this->Shifts->get($id, [
            'contain' => ['ProductTypes'],
        ]);

        $this->set('shift', $shift);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shift = $this->Shifts->newEmptyEntity();
        if ($this->request->is('post')) {
            $shift = $this->Shifts->patchEntity($shift, $this->request->getData());
            if ($this->Shifts->save($shift)) {
                $this->Flash->success(__('The shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shift could not be saved. Please, try again.'));
        }
        $productTypes = $this->Shifts->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('shift', 'productTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shift id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shift = $this->Shifts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shift = $this->Shifts->patchEntity($shift, $this->request->getData());
            if ($this->Shifts->save($shift)) {
                $this->Flash->success(__('The shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shift could not be saved. Please, try again.'));
        }
        $productTypes = $this->Shifts->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('shift', 'productTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shift id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shift = $this->Shifts->get($id);
        if ($this->Shifts->delete($shift)) {
            $this->Flash->success(__('The shift has been deleted.'));
        } else {
            $this->Flash->error(__('The shift could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
