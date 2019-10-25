<?php
App::uses('AppController', 'Controller');
/**
 * InventoryStatuses Controller
 *
 * @property InventoryStatus $InventoryStatus
 * @property PaginatorComponent $Paginator
 */
class InventoryStatusesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = ['Paginator'];


        public function beforeFilter() {
            parent::beforeFilter();
            // Allow users to register and logout.
            $this->Auth->deny();
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InventoryStatus->recursive = 0;
		$this->set('inventoryStatuses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->InventoryStatus->exists($id)) {
			throw new NotFoundException(__('Invalid inventory status'));
		}
		$options = ['conditions' => ['InventoryStatus.' . $this->InventoryStatus->primaryKey => $id]];


		$this->set('stockViewPerms', $this->InventoryStatus->createStockViewPermsList());
		$this->set('inventoryStatus', $this->InventoryStatus->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InventoryStatus->create();
			if ($this->InventoryStatus->save($this->request->data)) {
				$this->Flash->success(__('The inventory status has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The inventory status could not be saved. Please, try again.'));
			}
		}

                 $stockViewPerms = $this->InventoryStatus->createStockViewPermsList();

                $this->set(compact('stockViewPerms'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->InventoryStatus->exists($id)) {
			throw new NotFoundException(__('Invalid inventory status'));
		}
		if ($this->request->is(['post', 'put'])) {
			if ($this->InventoryStatus->save($this->request->data)) {
				$this->Flash->success(__('The inventory status has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The inventory status could not be saved. Please, try again.'));
			}
		} else {
			$options = ['conditions' => ['InventoryStatus.' . $this->InventoryStatus->primaryKey => $id]];
			$this->request->data = $this->InventoryStatus->find('first', $options);
		}

                $stockViewPerms = $this->InventoryStatus->createStockViewPermsList();

                $this->set(compact('stockViewPerms'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->InventoryStatus->id = $id;
		if (!$this->InventoryStatus->exists()) {
			throw new NotFoundException(__('Invalid inventory status'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->InventoryStatus->delete()) {
			$this->Flash->success(__('The inventory status has been deleted.'));
		} else {
			$this->Flash->error(__('The inventory status could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}
