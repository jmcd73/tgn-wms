<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;

/**
 * Help Controller
 *
 * @property \App\Model\Table\HelpTable $Help
 *
 * @method \App\Model\Entity\Help[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HelpController extends AppController
{

    public function initialize(): void
    {

        parent::initialize();
        $this->docsRoot = $this->getSetting('DOCUMENTATION_ROOT');
        $this->fullPathDocumentationRoot = WWW_ROOT . $this->docsRoot;
        
    }
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

        
        $mdFiles = $this->Help->listMdFiles($this->fullPathDocumentationRoot);
        $markdownDocuments = array_combine($mdFiles, $mdFiles);
        $controllerActions = $this->Ctrl->getMenuActions();

        $this->set('documentationRoot', $this->docRoot);

        $this->set(compact('controllerActions', 'markdownDocuments'));

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

        $mdFiles = $this->Help->listMdFiles($this->fullPathDocumentationRoot);
        $markdownDocuments = array_combine($mdFiles, $mdFiles);
        $controllerActions = $this->Ctrl->getMenuActions();
        $this->set(compact('controllerActions', 'markdownDocuments'));
        $this->set(compact('help'));
        $this->set('documentationRoot', $this->docsRoot);
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
  
        $mdDocumentPath = $this->fullPathDocumentationRoot .
            DS . $help->markdown_document;

        $markdown = $this->Help->getMarkdown($mdDocumentPath);

        $baseUrl = Router::url('/');

        $markdown = str_replace('src="' . DS . $this->docsRoot, 'src="' . $baseUrl . $this->docsRoot, $markdown);

        $this->set(compact('help', 'markdown'));
    }
}