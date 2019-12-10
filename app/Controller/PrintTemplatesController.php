<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * PrintTemplates Controller
 *
 * @property PrintTemplate $PrintTemplate
 * @property PaginatorComponent $Paginator
 */
class PrintTemplatesController extends AppController
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
        $this->PrintTemplate->recursive = 0;
        $this->Paginator->settings = [
            'PrintTemplate' => [
                'order' => ['PrintTemplate.lft' => 'ASC']
            ]
        ];
        $printTemplates = $this->Paginator->paginate();

        $glabelsRoot = DS . $this->getSetting('GLABELS_ROOT') . DS;

        /*$printTemplates = $this->PrintTemplate->generateTreeList(
        null,
        null,
        "{n}.PrintTemplate.description",
        '&nbsp;&nbsp;&nbsp;'
        );*/
        $this->set(
            compact(
                'printTemplates',
                'glabelsRoot'
            )
        );
    }

    /**
     * Method checkExists - Finds files that are in the templates dir
     * that shouldn't be and deletes them
     *
     * @return void
     */
    public function checkExists()
    {
        debug("Remove the return statement from PrintTemplatesController/checkExists() to use");

        return;

        $i2c = array_diff(scandir(WWW_ROOT . 'files/templates'), ['.', '..']);
        $pt = $this->PrintTemplate->find(
            'all',
            [
                'recursive' => -1
            ]
        );

        $ft = Hash::extract(
            $pt,
            '{n}.PrintTemplate.file_template'
        );

        $ei = Hash::extract(
            $pt,
            '{n}.PrintTemplate.example_image'
        );
        $filesToDelete = array_diff($i2c, $ft, $ei);
        debug($filesToDelete);

        foreach ($filesToDelete as $file) {
            $fileObject = new File(WWW_ROOT . 'files/templates' . '/' . $file);
            debug($fileObject->delete());
        }

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
        $options = ['conditions' => ['PrintTemplate.' . $this->PrintTemplate->primaryKey => $id]];
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
                $this->Flash->error(__('The print template could not be saved. Please, try again.'));
            }
        }

        $controllerList = $this->Ctrl->formatControllersWithActionOnlyList(
            $this->Ctrl->get()
        );

        $parents = $this->PrintTemplate->find(
            'list',
            [
                'conditions' => [
                    'PrintTemplate.parent_id IS NULL'
                ],
                'order' => "PrintTemplate.lft"
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
                    'PrintTemplate.parent_id IS NULL'
                ],
                'order' => "PrintTemplate.lft"
            ]
        );
        $controllerList = $this->Ctrl->formatControllersWithActionOnlyList(
            $this->Ctrl->get()
        );
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
     * @return void
     */
    public function move($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        if (is_numeric($this->request->data['PrintTemplate']['amount'])) {
            $delta = $this->request->data['PrintTemplate']['amount'];
        }
        if (isset($this->request->data['PrintTemplate']['moveUp'])) {
            $this->requestAction(
                [
                    'action' => 'moveUp',
                    $id,
                    $delta
                ]
            );
        }
        if (isset($this->request->data['PrintTemplate']['moveDown'])) {
            $this->requestAction(
                [
                    'action' => 'moveDown',
                    $id,
                    $delta
                ]
            );
        }
    }

    /**
     * moveDown
     * @param int $id ID of Print Template
     * @param int $delta how far to move
     * @return mixed
     */
    public function moveDown($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $this->PrintTemplate->id = $id;
        if (is_numeric($this->request->data['PrintTemplate']['amount'])) {
            $delta = $this->request->data['PrintTemplate']['amount'];
        }
        if (!$this->PrintTemplate->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->PrintTemplate->moveDown($this->PrintTemplate->id, abs($delta))) {
            $this->Flash->success('The category has been moved down.');
        } else {
            $this->Flash->error('The category could not be moved down. Please, try again.');
        }

        return $this->redirect($this->referer());
    }

    /**
     * @param int $id ID of Print Template
     * @param int $delta how many places to move
     * @return mixed
     */
    public function moveUp($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $this->PrintTemplate->id = $id;
        if (is_numeric($this->request->data['PrintTemplate']['amount'])) {
            $delta = $this->request->data['PrintTemplate']['amount'];
        }
        if (!$this->PrintTemplate->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->PrintTemplate->moveUp($this->PrintTemplate->id, abs($delta))) {
            $this->Flash->success('The category has been moved Up.');
        } else {
            $this->Flash->error('The category could not be moved up. Please, try again.');
        }

        return $this->redirect($this->referer());
    }
}