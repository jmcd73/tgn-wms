<?php
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 * @property PaginatorComponent $Paginator
 */
class MenusController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = [
        'Paginator',
        'Ctrl'

    ];

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.

        $this->Auth->deny();
        $this->Auth->allow('build_menu');

    }

    public function controllerList()
    {

        $controllerList = $this->Ctrl->get();
        $controllerList = $this->Ctrl->formatArray($controllerList);

        $this->set(compact('controllerList'));

    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Menu->recursive = 0;

        $this->Paginator->settings['order'] = [
            'Menu.lft' => 'ASC'
        ];

        $menus = $this->Paginator->paginate();
        $edit_menus = $this->Menu->find_stacked();
        $this->set(compact('menus', 'edit_menus'));
    }

    /**
     * @param $id
     * @param null $delta
     * @return mixed
     */
    public function move_up($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $this->Menu->id = $id;
        if(is_numeric($this->data['Menu']['amount'])) {
            $delta = $this->data['Menu']['amount'];
        }
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->Menu->moveUp($this->Menu->id, abs($delta))) {
            $this->Flash->success('The category has been moved Up.');
        } else {
            $this->Flash->error('The category could not be moved up. Please, try again.');
        }
        return $this->redirect($this->referer());
    }

    /**
     * @param $id
     * @param null $delta
     * @return mixed
     */
    public function move_down($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);
        $this->Menu->id = $id;
        if(is_numeric($this->data['Menu']['amount'])) {
            $delta = $this->data['Menu']['amount'];
        }
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->Menu->moveDown($this->Menu->id, abs($delta))) {
            $this->Flash->success('The category has been moved down.');
        } else {
            $this->Flash->error('The category could not be moved down. Please, try again.');
        }
        return $this->redirect($this->referer());
    }

    /**
     * @return mixed
     */
    public function build_menu()
    {
        $this->Menu->recursive = -1;
        $options = [
            'order' => [
                'Menu.lft' => 'ASC'
            ]
        ];

        return $this->Menu->find('threaded', $options);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id Menu Id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Menu->exists($id)) {
            throw new NotFoundException(__('Invalid menu'));
        }
        $options = ['conditions' => ['Menu.' . $this->Menu->primaryKey => $id]];
        $this->set('menu', $this->Menu->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }
        }

        $parentMenus = $this->Menu->find_stacked();

        $controllerList = $this->Ctrl->get();
        $bs_url = $this->Ctrl->formatArray($controllerList);

        $this->set(compact('parentMenus', 'bs_url'));
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
        if (!empty($this->request->data['Menu']['edit_menu'])) {
            $id = $this->request->data['Menu']['edit_menu'];

            return $this->redirect(['action' => 'edit', $id]);
        }

        if (!$this->Menu->exists($id)) {
            throw new NotFoundException(__('Invalid menu'));
        }
        if ($this->request->is(['post', 'put']) && empty($this->request->data['Menu']['edit_menu'])) {
            if ($this->Menu->save($this->request->data)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }
        } else {
            $options = ['conditions' => ['Menu.' . $this->Menu->primaryKey => $id]];
            $this->request->data = $this->Menu->find('first', $options);
        }
        $parentMenus = $this->Menu->find_stacked();

        $controllerList = $this->Ctrl->get();
        $bs_url = $this->Ctrl->formatArray($controllerList);
        $menu_id = $id;
        $menu_name = $this->request->data['Menu']['name'];

        $this->set(compact('parentMenus', 'bs_url', 'menu_id', 'menu_name'));
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
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        $this->request->allowMethod('post', 'delete');
        // don't delete the tree if you remove a parent or child
        if ($this->Menu->removeFromTree($id, true)) {
            $this->Flash->success(__('The menu has been deleted.'));
            $redirectUrl = $this->request->query('redirect');
            if ($redirectUrl) {
                $this->redirect(urldecode($redirectUrl));
            }
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
