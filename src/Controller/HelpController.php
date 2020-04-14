<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Help Controller
 *
 * @property \App\Model\Table\HelpTable $Help
 *
 * @method \App\Model\Entity\Help[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HelpController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $help = $this->paginate($this->Help);

        $this->set(compact('help'));
    }

    /**
     * View method
     *
     * @param string|null $id Help id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $help = $this->Help->get($id, [
            'contain' => [],
        ]);

        $this->set('help', $help);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $help = $this->Help->newEmptyEntity();
        if ($this->request->is('post')) {
            $help = $this->Help->patchEntity($help, $this->request->getData());
            if ($this->Help->save($help)) {
                $this->Flash->success(__('The help has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The help could not be saved. Please, try again.'));
        }

        $documentationRoot = ROOT . $this->Help->getSetting('DOCUMENTATION_ROOT');
        $mdFiles = $this->Help->listMdFiles($documentationRoot);
        $markdownDocuments = array_combine($mdFiles, $mdFiles);
        $controllerActions = $this->Ctrl->getMenuActions();
        $this->set(compact('controllerActions', 'documentationRoot', 'markdownDocuments'));

        $this->set(compact('help'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Help id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $help = $this->Help->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $help = $this->Help->patchEntity($help, $this->request->getData());
            if ($this->Help->save($help)) {
                $this->Flash->success(__('The help has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The help could not be saved. Please, try again.'));
        }

        $documentationRoot = ROOT . $this->Help->getSetting('DOCUMENTATION_ROOT');
        $mdFiles = $this->Help->listMdFiles($documentationRoot);
        $markdownDocuments = array_combine($mdFiles, $mdFiles);
        $controllerActions = $this->Ctrl->getMenuActions();
        $this->set(compact('controllerActions', 'documentationRoot', 'markdownDocuments'));
        $this->set(compact('help'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Help id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $help = $this->Help->get($id);
        if ($this->Help->delete($help)) {
            $this->Flash->success(__('The help has been deleted.'));
        } else {
            $this->Flash->error(__('The help could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id ID of Help page
     * @return void
     */
    public function viewPageHelp($id = null)
    {
        $help = $this->Help->get($id);

        $mdDocumentPath = ROOT . $this->Help->getSetting('DOCUMENTATION_ROOT') .
            DS . $help->markdown_document;

        $markdown = $this->Help->getMarkdown($mdDocumentPath);
        $this->set(compact('help', 'markdown'));
    }
}