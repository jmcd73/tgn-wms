<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * PrintTemplates Controller
 *
 * @property PrintTemplate $PrintTemplate
 * @property PaginatorComponent $Paginator
 * @property CtrlComponent $Ctrl
 */
class PrintTemplatesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = ['Paginator', 'Ctrl'];

    public function beforeFilter()
    {
        // $this->Security->unlockedFields = ['moveUp', 'moveDown'];
        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->PrintTemplate->recursive = 0;
        $this->Paginator->settings = [
            'PrintTemplate' => [
                'order' => ['PrintTemplate.lft' => 'ASC'],
            ],
        ];
        $printTemplates = $this->Paginator->paginate();

        $this->set(compact('printTemplates'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param int $id ID of Print Template
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->PrintTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid print template'));
        }
        $options = [
            'conditions' => [
                'PrintTemplate.' . $this->PrintTemplate->primaryKey => $id,
            ],
        ];

        $this->loadModel('Setting');
        $glabelsRoot = DS . $this->getSetting('GLABELS_ROOT') . DS;
        $this->set(compact('glabelsRoot'));
        $this->set('printTemplate', $this->PrintTemplate->find('first', $options));
    }

    /**
     * add method
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->PrintTemplate->create();

            if ($this->PrintTemplate->save($this->request->data)) {
                $this->Flash->success(__('The print template has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->log(['addErrors' => $this->validationErrors]);
                $this->Flash->error(__('The print template could not be saved. Please, try again.'));
            }
        }

        $controllerList = $this->Ctrl->formatArray();

        $parents = $this->PrintTemplate->find(
            'list',
            [
                'conditions' => [
                    'PrintTemplate.parent_id IS NULL',
                ],
                'order' => 'PrintTemplate.lft',
            ]
        );

        $this->set(compact('controllerList', 'parents'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param int $id ID of Print Template
     * @return mixed
     */
    public function edit($id = null)
    {
        if (!$this->PrintTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid print template'));
        }
        if ($this->request->is(['post', 'put'])) {
            $this->log(['eidt' => $this->request->data]);
            if ($this->PrintTemplate->save($this->request->data)) {
                $this->Flash->success(__('The print template has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The print template could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['PrintTemplate.' . $this->PrintTemplate->primaryKey => $id]];
            $this->request->data = $this->PrintTemplate->find('first', $options);
        }
        $parents = $this->PrintTemplate->find(
            'list',
            [
                'conditions' => [
                    'PrintTemplate.parent_id IS NULL',
                ],
                'order' => 'PrintTemplate.lft',
            ]
        );
        $controllerList = $this->Ctrl->formatArray();

        $this->set(compact('controllerList', 'parents'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param int $id ID of Print Template
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->PrintTemplate->id = $id;
        if (!$this->PrintTemplate->exists()) {
            throw new NotFoundException(__('Invalid print template'));
        }
        $this->request->allowMethod('post', 'delete');

        if ($this->PrintTemplate->removeFromTree($id, true)) {
            $this->Flash->success(__('The print template has been deleted.'));
        } else {
            $this->Flash->error(__('The print template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param int $id ID of Print Template
     * @param int $delta How many places to move in tree
     * @return mixed
     */
    public function move($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);

        $this->PrintTemplate->id = $id;

        if (!$this->PrintTemplate->exists()) {
            throw new NotFoundException(__('Invalid PrintTemplate'));
        }

        if (is_numeric($this->request->data['PrintTemplate']['amount'])) {
            $delta = $this->request->data['PrintTemplate']['amount'];
        }

        $action = isset($this->request->data['PrintTemplate']['moveUp']) ? 'moveUp' : 'moveDown';

        if ($this->PrintTemplate->$action($this->PrintTemplate->id, abs($delta))) {
            $this->Flash->success('The PrintTemplate has been moved down.');
        } else {
            $this->Flash->error('The PrintTemplate could not be moved down. Please, try again.');
        }

        return $this->redirect($this->referer());
    }

    /**
     * use this to delete files that don't exist in the PrintTemplate table
     * file_template or example_image fields
     */
    public function cleanUpTemplates()
    {
        $printTemplates = $this->PrintTemplate->find('all', ['contain' => true]);
        $filesToCheck = [];
        foreach (['file_template', 'example_image'] as $field) {
            $fieldValues = Hash::extract($printTemplates, '{n}.PrintTemplate.' . $field);
            $fieldValues = Hash::filter($fieldValues);

            $filesToCheck = array_merge($filesToCheck, $fieldValues);
        }

        $templateRoot = WWW_ROOT . 'files/templates';

        $folder = new Folder($templateRoot);

        $filesInFolder = $folder->find('.*');

        $filesToDelete = array_diff($filesInFolder, $filesToCheck);

        foreach ($filesToDelete as $file) {
            $file = new File($templateRoot . DS . $file);
            debug('Deleting ' . $file->path);
            $file->delete();
        }

        debug($filesToDelete);
    }
}