<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PrintTemplates Controller
 *
 * @property \App\Model\Table\PrintTemplatesTable $PrintTemplates
 *
 * @method \App\Model\Entity\PrintTemplate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrintTemplatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentPrintTemplates'],
        ];
        $printTemplates = $this->paginate($this->PrintTemplates);

        $this->set(compact('printTemplates'));
    }

    /**
     * View method
     *
     * @param string|null $id Print Template id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $printTemplate = $this->PrintTemplates->get($id, [
            'contain' => ['ParentPrintTemplates', 'Items', 'ChildPrintTemplates'],
        ]);

        $this->set('printTemplate', $printTemplate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $printTemplate = $this->PrintTemplates->newEmptyEntity();
        if ($this->request->is('post')) {
            $printTemplate = $this->PrintTemplates->patchEntity($printTemplate, $this->request->getData());
            if ($this->PrintTemplates->save($printTemplate)) {
                $this->Flash->success(__('The print template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The print template could not be saved. Please, try again.'));
        }
        $parentPrintTemplates = $this->PrintTemplates->ParentPrintTemplates->find('list', ['limit' => 200]);
        $this->set(compact('printTemplate', 'parentPrintTemplates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Print Template id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $printTemplate = $this->PrintTemplates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $printTemplate = $this->PrintTemplates->patchEntity($printTemplate, $this->request->getData());
            if ($this->PrintTemplates->save($printTemplate)) {
                $this->Flash->success(__('The print template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The print template could not be saved. Please, try again.'));
        }
        $parentPrintTemplates = $this->PrintTemplates->ParentPrintTemplates->find('list', ['limit' => 200]);
        $this->set(compact('printTemplate', 'parentPrintTemplates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Print Template id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $printTemplate = $this->PrintTemplates->get($id);
        if ($this->PrintTemplates->delete($printTemplate)) {
            $this->Flash->success(__('The print template has been deleted.'));
        } else {
            $this->Flash->error(__('The print template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
