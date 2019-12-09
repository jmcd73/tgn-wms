<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Helps Controller
 *
 * @property Help $Help
 * @property PaginatorComponent $Paginator
 */
class HelpController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'Ctrl'];
    /**
     * @var array
     */

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $controllerActions = $this->Ctrl->formatForPrinterViews();
        $documentationRoot = ROOT . $this->getSetting('DOCUMENTATION_ROOT');
        $mdFiles = $this->Help->listMdFiles($documentationRoot);
        $markdownDocuments = array_combine($mdFiles, $mdFiles);
        $this->set(compact('controllerActions', 'documentationRoot', 'markdownDocuments'));
        $this->Help->recursive = 0;

        $this->set(compact('documentationRoot'));
        $this->set('helps', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id Help Table ID
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Help->exists($id)) {
            throw new NotFoundException(__('Invalid help'));
        }
        $options = ['conditions' => ['Help.' . $this->Help->primaryKey => $id]];

        $help = $this->Help->find('first', $options);

        $mdDocumentPath = ROOT . $this->getSetting('DOCUMENTATION_ROOT') .
            DS . $help['Help']['markdown_document'];

        $markdown = $this->Help->getMarkdown($mdDocumentPath);

        $this->set(compact('help', 'markdown'));
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
        if (!$this->Help->exists($id)) {
            throw new NotFoundException(__('Invalid help'));
        }
        $options = ['conditions' => ['Help.' . $this->Help->primaryKey => $id]];
        $help = $this->Help->find('first', $options);

        $mdDocumentPath = ROOT . $this->getSetting('DOCUMENTATION_ROOT') .
            DS . $help['Help']['markdown_document'];

        $markdown = $this->Help->getMarkdown($mdDocumentPath);
        $this->set(compact('help', 'markdown'));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Help->create();
            if ($this->Help->save($this->request->data)) {
                $this->Flash->success(__('The help has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The help could not be saved. Please, try again.'));
            }
        }
        $documentationRoot = ROOT . $this->getSetting('DOCUMENTATION_ROOT');
        $mdFiles = $this->Help->listMdFiles($documentationRoot);
        $markdownDocuments = array_combine($mdFiles, $mdFiles);
        $controllerActions = $this->Ctrl->formatForPrinterViews();
        $this->set(compact('controllerActions', 'documentationRoot', 'markdownDocuments'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id ID of Help page
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->Help->exists($id)) {
            throw new NotFoundException(__('Invalid help'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Help->save($this->request->data)) {
                $this->Flash->success(__('The help has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The help could not be saved. Please, try again.'));
            }
        } else {
            $documentationRoot = ROOT . $this->getSetting('DOCUMENTATION_ROOT');
            $mdFiles = $this->Help->listMdFiles($documentationRoot);
            $markdownDocuments = array_combine($mdFiles, $mdFiles);
            $controllerActions = $this->Ctrl->formatForPrinterViews();
            $this->set(compact('controllerActions', 'documentationRoot', 'markdownDocuments'));
            $options = ['conditions' => ['Help.' . $this->Help->primaryKey => $id]];
            $this->request->data = $this->Help->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id ID to delete
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!$this->Help->exists($id)) {
            throw new NotFoundException(__('Invalid help'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Help->delete($id)) {
            $this->Flash->success(__('The help has been deleted.'));
        } else {
            $this->Flash->error(__('The help could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}