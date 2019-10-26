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
                'printTemplates', 'glabelsRoot'
            )
        );
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
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
 * @return void
 */
    public function add()
    {
        if ($this->request->is('post')) {
            /*
            [file_template] => Array
            (
            [name] => 150x200-shipping-labels.glabels
            [type] => application/octet-stream
            [tmp_name] => /tmp/phpDd2TA4
            [error] => 0
            [size] => 6864
            )
             */

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
            'list', [
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
 * @param string $id
 * @return void
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
            'list', [
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
 * @param string $id
 * @return void
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
     * @param $id
     * @param null $delta
     */
    public function move($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        if (is_numeric($this->data['PrintTemplate']['amount'])) {
            $delta = $this->data['PrintTemplate']['amount'];
        }
        if (isset($this->data['PrintTemplate']['move_up'])) {
            $this->requestAction(
                [
                    'action' => 'move_up',
                    $id,
                    $delta
                ],

            );
        }
        if (isset($this->data['PrintTemplate']['move_down'])) {
            $this->requestAction(
                [
                    'action' => 'move_down',
                    $id,
                    $delta
                ]
            );
        }
    }



     /**
     * @param $id
     * @param null $delta
     * @return mixed
     */
    public function move_down($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $this->PrintTemplate->id = $id;
        if(is_numeric($this->data['PrintTemplate']['amount'])) {
            $delta = $this->data['PrintTemplate']['amount'];
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
     * @param $id
     * @param null $delta
     * @return mixed
     */
    public function move_up($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $this->PrintTemplate->id = $id;
        if(is_numeric($this->data['PrintTemplate']['amount'])) {
            $delta = $this->data['PrintTemplate']['amount'];
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
