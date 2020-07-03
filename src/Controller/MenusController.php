<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 * @property \App\Controller\Component\CtrlComponent $Ctrl
 *
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Ctrl');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentMenus'],
            'order' => ['lft' => 'ASC'],
        ];
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Menu id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['ParentMenus', 'ChildMenus'],
        ]);

        $this->set('menu', $menu);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEmptyEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            pr($menu->getErrors());
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $parentMenus = $this->Menus->ParentMenus->find('treeList', [
            'spacer' => '&nbsp;&nbsp;',
            'limit' => 200, ]);
        $bsUrls = $this->Ctrl->getMenuActions();
        $this->set(compact('menu', 'parentMenus', 'bsUrls'));
    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id Menu id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $parentMenus = $this->Menus->ParentMenus->find('treeList', [
            'spacer' => '&nbsp;&nbsp;',
            'limit' => 200, ]);
        $bsUrls = $this->Ctrl->getMenuActions();
        $this->set(compact('menu', 'parentMenus', 'bsUrls'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id Menu id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param  int   $id    ID of menu
     * @param  int   $delta how much to move up or down
     * @return mixed
     */
    public function move($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);

        $data = $this->request->getData();

        $menu = $this->Menus->get($id);

        if (is_numeric($data['amount'])) {
            $delta = $data['amount'];
        }

        $action = isset($data['moveUp']) ? 'moveUp' : 'moveDown';

        if ($this->Menus->$action($menu, abs($delta))) {
            $this->Flash->success($action . ' success!');
        } else {
            $this->Flash->error('The category could not be moved up. Please, try again.');
        }

        return $this->redirect($this->request->referer(false));
    }

    public function tree()
    {

        $menus = $this->Menus->find('threaded')
        ->orderAsc('lft');

        $this->set(compact('menus'));
    }
}