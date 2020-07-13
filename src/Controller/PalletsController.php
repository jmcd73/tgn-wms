<?php

declare(strict_types=1);

namespace App\Controller;


use App\Mailer\AppMailer;
use App\Model\Table\CartonsTable;
use App\Model\Table\PalletsTable;
use App\Model\Table\ProductTypesTable;
use App\Model\Table\SettingsTable;
use App\Form\LookupSearchForm;
use App\Form\OnhandSearchForm;
use App\Form\PalletPrintForm;
use App\Form\ShiftReportForm;
use App\Lib\PrintLabels\PalletPrintResultTrait;
use App\Lib\PrintLabels\PrintLabel;
use App\Lib\Utility\Batch;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;
use App\Lib\Utility\Barcode;
use Cake\I18n\Time;

/**
 * Pallets Controller
 *
 * @property \App\Model\Table\PalletsTable $Pallets
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *
 * @method \App\Model\Entity\Pallet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PalletsController extends AppController
{
    use PalletPrintResultTrait;

    public function initialize(): void
    {
        parent::initialize();

        $eventClasses = [
            PrintLabel::class,
            ProductTypesTable::class,
            SettingsTable::class,
            PalletsTable::class
        ];

        foreach ($eventClasses as $eventClass) {
            $this->getEventManager()->on(new $eventClass);
        }
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([
            'multiEdit',
        ]);
    }

    // $this->Security->setConfig('unlockedActions', ['edit']);

    /**
     * Print a new pallet label
     *
     * @param int ProductTypeId $productTypeId Product Type ID
     *
     * @return mixed
     */
    public function palletPrint($productTypeId = null)
    {
        $forms = [];

        foreach (['left', 'right'] as $form) {
            $forms[$form] = (new PalletPrintForm())->setFormName($form);
        }

        $productTypes = $this->Pallets->Items->ProductTypes->find('list', [
            'conditions' => [
                'ProductTypes.active' => 1,
            ],
        ]);

        if (!$productTypeId) {
            $this->Flash->error('Select a product type from the actions on the left');
            $this->set(compact('productTypes'));
            return;
        }

        $productType = $this->Pallets->Items->ProductTypes->get($productTypeId);

        $productionLines = $this->Pallets->Items
            ->ProductTypes->ProductionLines->find(
                'list',
                [
                    'conditions' => [
                        'product_type_id' => $productTypeId,
                        'active' => 1,
                    ],
                ]
            );

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $formName = $data['formName'];

            if ($forms[$formName]->validate($data)) {

                $newData = [];

                foreach ($data as $key => $value) {
                    $newKey = str_replace($formName . '-', '', $key);
                    $newData[$newKey] = $value;
                }

                $newData['user_id'] = $this->Authentication->getIdentity()->getIdentifier();

                /* create a pallet entity for the pallets table but don't persist it yet */

                $pallet = $this->Pallets->createPalletEntity($newData);

                $item = $this->Pallets->Items->get($newData['item'], [
                    'contain' =>
                    ['PrintTemplates', 'ProductTypes']
                ]);

                $productionLine = $this->Pallets->ProductionLines->get($newData['production_line'], [
                    'contain' => 'Printers'
                ]);

                if (!$pallet->hasErrors()) {
                    $this->Flash->success($this->createMessage($pallet, $productionLine->printer), ['escape' => false]);

                    /* dispatch an event to the PrintLabel controller to 
                     * print labels and sendEmail
                     * */
                    $event = new Event('PrintLabels.palletPrint', $pallet, [
                        'item' => $item,
                        'printer' => $productionLine->printer,
                        'company' => $this->companyName,
                        'action' => $this->request->getParam('action')
                    ]);

                    $this->getEventManager()->dispatch($event);

                    $printResult = $event->getResult()['printResult'];

                    $labelClass = $event->getResult()['labelClass'];

                    if ($printResult['return_value'] === 0) {

                        /* if print is successful 
                         * increment serial numbers 
                         * persist pallet entity and
                         * create a carton record
                        */
                        $events = [
                            'Model.ProductTypes.incrementNextSerialNumber',
                            'Model.Settings.incrementSsccRef',
                        ];

                        foreach ($events as $eventName) {
                            $evt =  new Event($eventName, $pallet);
                            $this->getEventManager()->dispatch($evt);
                        }

                        $palletEvents = [
                            'Model.Pallets.addPalletLabelFilename',
                            'Model.Pallets.persistPalletRecord'
                        ];

                        foreach ($palletEvents as $eventName) {

                            $evt = new Event(
                                $eventName,
                                $pallet,
                                [
                                    'labelClass' => $labelClass,
                                    'labelOutputPath' => $this->getSetting('LABEL_OUTPUT_PATH')
                                ]
                            );

                            $this->getEventManager()->dispatch($evt);
                        }
                    }
                } else {
                    $errors = $this->Pallets->flattenAndFormatValidationErrors($pallet->getErrors());
                    $this->Flash->error("Contact IT Support: " . $errors,  ['escape' => false]);
                }
            } else {
                $this->Flash->error('There was a problem submitting your form.');
                $forms[$this->request->getData()['formName']]->setData($this->request->getData());
                $forms[$this->request->getData()['formName']]->setErrors(
                    $forms[$this->request->getData()['formName']]->getErrors()
                );
            }
        } // end of post check
        // populate form

        $items = $this->Pallets->Items->getPalletPrintItems($productTypeId);

        $exampleBatchNo = (new Batch)->getBatchNumbers($productType['batch_format']);

        $refer = $this->request->getPath();


        $labelOutputPath = $this->getSetting('LABEL_OUTPUT_PATH');

        $lastPrintsCount = (int) $this->getSetting('LABEL_DOWNLOAD_LIST');

        $lastPrints = $this->Pallets->find()
            ->select(['id', 'pallet_label_filename', 'pl_ref', 'item'])
            ->where(['pallet_label_filename IS NOT NULL'])
            ->order(['id' => 'DESC'])
            ->limit($lastPrintsCount)->filter(function ($pallet)  use ($labelOutputPath) {
                return $this->Pallets->checkFileExists($labelOutputPath, $pallet->pallet_label_filename);
            });


        //debug($lastPrints);

        $showLabelDownload = (bool) $lastPrintsCount;

        $this->set(
            compact(
                'lastPrints',
                'showLabelDownload',
                'lastPrintsCount',
                'labelOutputPath',
                'items',
                'productionLines',
                'productType',
                'productTypes',
                'refer',
                'forms',
                'exampleBatchNo'
            )
        );
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductionLines', 'Items', 'Printers', 'Locations', 'Shipments', 'InventoryStatuses', 'ProductTypes'],
        ];
        $pallets = $this->paginate($this->Pallets);

        $this->set(compact('pallets'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Pallet id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pallet = $this->Pallets->get($id, [
            'contain' => ['ProductionLines', 'Items', 'Printers', 'Locations', 'Shipments', 'InventoryStatuses', 'ProductTypes', 'Cartons'],
        ]);

        $this->set('pallet', $pallet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pallet = $this->Pallets->newEmptyEntity();
        if ($this->request->is('post')) {
            $pallet = $this->Pallets->patchEntity($pallet, $this->request->getData());
            if ($this->Pallets->save($pallet)) {
                $this->Flash->success(__('The pallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pallet could not be saved. Please, try again.'));
        }
        $productionLines = $this->Pallets->ProductionLines->find('list', ['limit' => 200]);
        $items = $this->Pallets->Items->find('list', ['limit' => 200]);
        $printers = $this->Pallets->Printers->find('list', ['limit' => 200]);
        $locations = $this->Pallets->Locations->find('list', ['limit' => 200]);
        $shipments = $this->Pallets->Shipments->find('list', ['limit' => 200]);
        $inventoryStatuses = $this->Pallets->InventoryStatuses->find('list', ['limit' => 200]);
        $productTypes = $this->Pallets->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('pallet', 'productionLines', 'items', 'printers', 'locations', 'shipments', 'inventoryStatuses', 'productTypes'));
    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id Pallet id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pallet = $this->Pallets->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pallet = $this->Pallets->patchEntity($pallet, $this->request->getData());
            if ($this->Pallets->save($pallet)) {
                $this->Flash->success(__('The pallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pallet could not be saved. Please, try again.'));
        }
        $productionLines = $this->Pallets->ProductionLines->find('list', ['limit' => 200]);
        $items = $this->Pallets->Items->find('list', ['limit' => 200]);
        $printers = $this->Pallets->Printers->find('list', ['limit' => 200]);
        $locations = $this->Pallets->Locations->find('list', ['limit' => 200]);
        $shipments = $this->Pallets->Shipments->find('list', ['limit' => 200]);
        $inventoryStatuses = $this->Pallets->InventoryStatuses->find('list', ['limit' => 200]);
        $productTypes = $this->Pallets->ProductTypes->find('list', ['limit' => 200]);
        $this->set(compact('pallet', 'productionLines', 'items', 'printers', 'locations', 'shipments', 'inventoryStatuses', 'productTypes'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id Pallet id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pallet = $this->Pallets->get($id);
        if ($this->Pallets->delete($pallet)) {
            $this->Flash->success(__('The pallet has been deleted.'));
        } else {
            $this->Flash->error(__('The pallet could not be deleted. Please, try again.'));
        }
        $this->request->trustProxy = true;
        $referer = $this->request->referer($local = false);
        $host = $this->request->host();
        $scheme = $this->request->scheme();

        if (preg_match('/^' . $scheme . ':\/\/' . $host . '/', $referer) === 1) {
            return $this->redirect($referer);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * batchLookup used by Pallets/lookup to get list of queried batch numbers from fragment
     *
     * @return void
     */
    public function batchLookup()
    {
        $search_term = $this->request->getQuery('term');

        $json_output = $this->Pallets->batchLookup($search_term);

        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * @param int StatusID $status_id the id to change
     *
     * @return void
     */
    public function bulkStatusRemove($status_id = null)
    {
        $view_perms = $this->Pallets->getViewPermNumber('view_in_remove_status');
        $setNoteKey = 'set-note';

        if ($this->request->is(['POST', 'PUT'])) {
            $inventory_status_note = $this->Pallets->inventoryStatusNote($this->request->getData());

            $update_statuses = [];
            $updateStatusIds = [];
            $data = $this->request->getData();

            foreach ($data['pallets'] as $pallet) {
                if (isset($pallet['inventory_status_id']) && ((is_numeric($pallet['inventory_status_id']) &&
                    $pallet['inventory_status_id'] >= 0) || $pallet['inventory_status_id'] === $setNoteKey)) {
                    $pallet['inventory_status_note'] = $inventory_status_note;
                    if ($pallet['inventory_status_id'] === $setNoteKey) {
                        unset($pallet['inventory_status_id']);
                    }
                    $update_statuses[] = $pallet;
                    $updateStatusIds[] = $pallet['id'];
                }
            }

            if (!empty($update_statuses)) {
                $entities = $this->Pallets->find('all')
                    ->whereInList('id', $updateStatusIds);

                $patched = $this->Pallets->patchEntities($entities, $update_statuses);

                if (
                    $this->Pallets->saveMany(
                        $patched
                    )
                ) {
                    $this->Flash->success(__('The data has been saved.'));
                    return $this->redirect($this->request->referer(false));
                };
            }
        }

        $options = [
            'contain' => [
                'InventoryStatuses',
                'Items',
                'Locations',
            ],
        ];

        if (empty($status_id)) {
            $options['conditions'] = [
                'Pallets.shipment_id' => 0,
            ];
        } else {
            $options['conditions'] = [
                'Pallets.inventory_status_id' => $status_id,
                'Pallets.shipment_id' => 0,
                'InventoryStatuses.perms & ' . $view_perms,
            ];
        }

        $this->paginate = [
            'order' => [
                'Pallets.id' => 'DESC',
            ],
            'limit' => 500,
            'maxLimit' => 3000,
        ];

        $pallets = $this->Pallets->find('all', $options);

        $pallets = $this->paginate($pallets);

        $status_options = [
            'conditions' => [
                'InventoryStatuses.perms & ' . $view_perms,
            ],
        ];

        $statuses = $this->Pallets->InventoryStatuses->find('all', $status_options);

        $status_list = $this->Pallets->InventoryStatuses->find('list', $status_options)->toArray();
        $showBulkChangeToSelect = false;
        if (!empty($status_id)) {
            $showBulkChangeToSelect = 1 === $this->Pallets->InventoryStatuses->find('all', [
                'conditions' => [
                    'id' => $status_id,
                    'allow_bulk_status_change' => true,
                ],
            ])->count();
        }

        $status_list[0] = 'Remove status';

        unset($status_list[$status_id]);

        ksort($status_list);
        $status_list[$setNoteKey] = 'Set note';

        $disable_footer = true;

        $this->set(
            compact(
                'pallets',
                'statuses',
                'status_id',
                'status_list',
                'showBulkChangeToSelect',
                'disable_footer'
            )
        );
    }


    /**
     * @param string $aisle Aisle to find columns and levels for
     *
     * @return void
     */
    public function columnsAndLevels($aisle = null)
    {
        list($aisles, $columns, $levels) = $this->Pallets->getColumnsAndLevels($aisle);

        $this->set(compact('columns', 'levels'));

        $this->render('/Elements/columns_levels');
    }

    /**
     * @param  int   $id Supply ID of pallet
     * @return mixed
     */
    public function editPallet($id = null)
    {
        $pallet = $this->Pallets->get($id, [
            'contain' => [
                'Locations',
            ],
        ]);

        if ($this->request->is(['post', 'put'])) {
            $patched = $this->Pallets->patchEntity($pallet, $this->request->getData());

            if ($this->Pallets->save($patched)) {
                $this->Flash->success(__('The pallet data has been saved.'));

                return $this->redirect($this->request->getData()['referer']);
            } else {
                $validationErrors = $this->Pallets->flattenAndFormatValidationErrors($patched->getErrors());
                $this->Flash->error(__('The  pallet data could not be saved. Please, try again.' . $validationErrors));
            }
        }

        $pallet->qty_before = $pallet->qty;

        $item_data = $this->Pallets->Items->get($pallet->item_id, ['contain' => []]);

        $item_qty = $item_data['quantity'];

        $inventory_statuses = $this->Pallets->InventoryStatuses->find('list');

        $productType = $this->Pallets->getProductType($id);

        $productTypeId = isset($productType['id'])
            ? $productType['id'] : 0;

        $availableLocations = $this->Pallets->getAvailableLocations('available', $productTypeId);
        $locationsCombined = $availableLocations;

        if ($pallet->has('location')) {
            $currentLocation = [
                $pallet['location']['id'] => $pallet['location']['location'],
            ];
            $locationsCombined = $locationsCombined + $currentLocation;
        }

        asort($locationsCombined, SORT_NATURAL);

        $locations = $locationsCombined;

        $shipments = $this->Pallets->Shipments->find('list');

        //$pallet->qty_user_id = $this->Auth->user()['id'];

        $pallet->product_type_id = $item_data['id'];

        $referer = $this->request->referer(false);
        //$restricted = $this->isAuthorized($this->Auth->user()) ? false : true;
        $restricted = false;
        $user = $this->Authentication->getIdentity();

        /*   if ($result->isValid()) {
              $user = $request->getAttribute('identity');
          } else {
              $this->log($result->getStatus());
              $this->log($result->getErrors());
          } */

        $this->set(
            compact(
                'item_qty',
                'user',
                'locations',
                'referer',
                'pallet',
                'shipments',
                'inventory_statuses',
                'restricted'
            )
        );
    }

    /**
     * @param URLDate $url_date provided on command line
     *
     * @return void
     */
    public function shiftReport($url_date = null)
    {
        $shiftReportForm = new ShiftReportForm();

        if ($this->request->is('POST')) {
            $data = $this->request->getData();

            if ($shiftReportForm->validate($data)) {

                $query_date = $data['start_date'];

                if (!empty($url_date)) {
                    $query_date = $url_date;
                }

                $reports = $this->Pallets->shiftReport($query_date);

                $this->set('reports', $reports['reports']);
                $this->set('shift_date', $query_date);
                $this->set('xml_shift_report', $reports['xml_shift_report']);
            } else {
                $this->Flash->error('Invalid data try again');
            }
        }

        $this->loadModel('Shifts');

        $shifts = $this->Shifts->find(
            'list',
            [
                'conditions' => [
                    'Shifts.active' => 1,
                    'Shifts.for_prod_dt' => 0,
                ],
            ]
        );

        $this->set('shiftReportForm', $shiftReportForm);
        $this->set('shifts', $shifts);
        $this->set('_serialize', ['xml_shift_report']);
    }

    /**
     * itemLookup for Pallets/lookup
     *
     * @return void
     */
    public function itemLookup()
    {
        $search_term = $this->request->getQuery('term');

        $json_output = $this->Pallets->Items->itemLookup($search_term);

        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * locationStockLevels method
     *
     * @param mixed $filter Filter value default is all but can be
     *
     * @return void
     */
    public function locationSpaceUsage($filter = 'all')
    {
        $viewOptions = [
            'limit' => 800,
            'maxLimit' => 3000,
            'sortWhitelist' => [
                'location', 'pallets', 'hasSpace', 'pallet_capacity',
            ],
            'order' => [
                'location' => 'ASC',
            ],
        ];
        // filter 'all', 'available'
        // productTypeId 'all' or id or productType

        $query = $this->Pallets->locationSpaceUsageOptions($filter, 'all');

        $this->paginate = $viewOptions;

        $locations = $this->paginate($query);

        $this->set(compact('locations', 'filter'));
    }

    /**
     * lookup action for pallet track
     *
     * @return void
     */
    public function lookup()
    {
        $options = [];

        if (!empty($this->request->getQueryParams())) {
            $options = $this->Pallets->formatLookupActionConditions(
                $this->request->getQueryParams()
            );
        }

        $searchForm = new LookupSearchForm();

        $this->paginate = [
            'conditions' => $options,
            'contain' => [
                'InventoryStatuses',
                'Locations',
                'Shipments',
                'Items',
            ],
            'limit' => Configure::read('PalletsLookup.limit'),
            'maxLimit' => Configure::read('PalletsLookup.maxLimit'),
            'order' => [
                'id' => 'DESC'
            ]
        ];

        $pallets = $this->paginate();

        $statuses = $this->Pallets->InventoryStatuses->find('list');

        $locations = $this->Pallets->Locations->find(
            'list',
            [
                'order' => [
                    'Locations.location' => 'ASC',
                ],
            ]
        );

        $options = [
            'fields' => [
                'Shipments.id',
                'Shipments.shipper',
            ],
            'order' => [
                'Shipments.id' => 'DESC',
            ],
        ];

        $shipments = $this->Pallets->Shipments->find('list', $options);

        $this->set(
            compact(
                'searchForm',
                'pallets',
                'locations',
                'shipments',
                'statuses'
            )
        );
    }

    /**
     * @return mixed
     */
    public function lookupSearch()
    {
        // the page we will redirect to
        $url['action'] = 'lookup';

        // build a URL will all the search elements in it
        // the resulting URL will be
        // example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3

        foreach ($this->request->getData() as $k => $v) {
            if (!empty($v)) {
                $url['?'][$k] = $v;
            }
        }

        // redirect the user to the url

        return $this->redirect($url);
    }

    /**
     * move pallet to new location
     *
     * @param  int   $id ID of Pallet
     * @return mixed
     */
    public function move($id = null)
    {
        $pallet = $this->Pallets->get($id, ['contain' => ['Locations']]);

        if ($this->request->is(['post', 'put'])) {
            $location = $this->Pallets->Locations->find()
                ->where([
                    'id' => $this->request->getData()['location_id'],
                ])->first();

            $msg = sprintf(
                'Pallet moved from <strong>%s</strong> to <strong>%s</strong>',
                $pallet->location->location,
                $location->location
            );

            $patched = $this->Pallets->patchEntity($pallet, $this->request->getData());

            if ($this->Pallets->save($patched)) {
                $this->Flash->success($msg, ['escape' => false]);

                return $this->redirect($this->request->getData()['referer']);
            } else {
                $this->Flash->error(__('The label could not be saved. Please, try again.'));
            }
        }

        $referer = $this->request->referer(false);

        $availableLocations = $this->Pallets->getAvailableLocations('available', $pallet->product_type_id);

        $this->set(compact('availableLocations', 'pallet', 'referer'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param  string            $id ID of pallet
     * @return void
     */
    public function multiEdit($id = null)
    {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->input('json_decode', true);
            $ids = Hash::extract($data, '{n}.id');

            $entities = $this->Pallets->find()->where([
                'id IN' => $ids,
            ]);

            $patchedEntities = $this->Pallets->patchEntities($entities, $data);

            if ($this->Pallets->saveMany($patchedEntities)) {
                if ($this->request->is('ajax')) {
                    $msg = [
                        'result' => 'success',
                        'message' => 'Successfully updated pallet',
                        'data' => $data,
                    ];
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode($msg));
                }
                $this->Flash->set(__('The label has been saved.'));
            } else {
                $msg = [
                    'result' => 'danger',
                    'message' => 'The data could not be saved',
                ];
                return $this->response->withType('application/json')->withStringBody(json_encode($msg));
            }
        }
    }

    /**
     * palletReferenceLookup find pl_ref and return list to typeahead for Pallets/lookup
     *
     * @return void
     */
    public function palletReferenceLookup()
    {
        $search_term = $this->request->getQuery('term');
        $json_output = $this->Pallets->palletReferenceLookup($search_term);
        $this->set(compact('json_output'));
        $this->set('_serialize', 'json_output');
    }

    /**
     * PutAway function
     *
     * @param ID $id ID of Pallet to put-away
     *
     * @return mixed
     */
    public function putAway($id = null)
    {
        if (!$this->Pallets->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }

        $pallet = $this->Pallets->get($id);

        $this->Pallets->getValidator()->add(
            'location_id',
            'notblank',
            [
                'rule' => 'notBlank',
                'message' => 'Specify a location to put-away the pallet',
            ]
        );

        if ($this->request->is(['post', 'put'])) {
            $locationId = $this->request->getData()['location_id'];

            $entity = $this->Pallets->get($id);

            $pallet = $this->Pallets->patchEntity($entity, $this->request->getData());

            if ($this->Pallets->save($pallet)) {
                $location = $this->Pallets->Locations->get($locationId)->toArray();

                $this->Flash->success(
                    __(
                        'A pallet of <strong>{0} - {1}</strong> with reference no. <strong>{2}</strong> has been moved to put-away location <strong>{3}</strong>',
                        $pallet->item,
                        $pallet->description,
                        $pallet->pl_ref,
                        $location['location']
                    ),
                    ['escape' => false]
                );

                return $this->redirect(['action' => 'unassignedPallets']);
            } else {
                $error = '';
                foreach ($this->Pallets->validationErrors as $validationError) {
                    foreach ($validationError as $errorMessage) {
                        $error .= $errorMessage . ' ';
                    }
                }
                $this->Flash->error($error);
            }

            return $this->redirect(['action' => 'unassignedPallets']);
        } else {
            $availableLocations = $this->Pallets->getAvailableLocations(
                $filter = 'available',
                $pallet['product_type_id']
            );

            $this->set(compact('availableLocations', 'pallet'));
        }
    }

    /**
     * unassignedPallets gets list of pallets that haven't been put-away yet
     *
     * @return void
     */
    public function unassignedPallets()
    {
        $last_pallet = null;
        $pallets = null;

        //$this->Pallets->Behaviors->load("Containable");

        $productTypeIds = $this->Pallets->Items->ProductTypes->find()
            ->select(['id'])
            ->where([
                'ProductTypes.active' => 1,
                'ProductTypes.location_id IS NULL',
            ]);

        //$productTypeIds = Hash::extract($productTypeIds, '{n}.id');

        if (!empty($productTypeIds)) {
            $last_pallet = $this->Pallets->find()
                ->order(['Pallets.id' => 'DESC'])
                ->where([
                    'Pallets.location_id !=' => 0,
                    'Pallets.shipment_id' => 0,
                    'Pallets.product_type_id IN' => $productTypeIds,
                ])
                ->contain(['Locations'])
                ->first();
        }

        $this->paginate = [
            'conditions' => [
                'Pallets.location_id' => 0,
            ],
        ];

        $pallets = $this->paginate($this->Pallets);

        if ($pallets->isEmpty() && isset($last_pallet['location']['location'])) {
            $this->Flash->success(
                __(
                    'The last pallet <strong>{0} - {1}</strong> with reference no. <strong>{2}</strong> was put-away in location <strong>{3}</strong>',
                    $last_pallet->item,
                    $last_pallet->description,
                    $last_pallet->pl_ref,
                    $last_pallet->location->location
                ),
                [
                    'escape' => false,
                    'clear' => true,
                ]
            );
        }

        $this->set(compact('pallets', 'last_pallet'));
    }

    /**
     * selectPalletPrintType returns list of product types to select page
     *
     * @return void
     */
    public function selectPalletPrintType()
    {
        $productTypes = $this->Pallets->Items->ProductTypes->find('list', [
            'conditions' => [
                'ProductTypes.active' => 1,
            ],
        ]);
        $this->set(compact('productTypes'));
    }

    /**
     * viewPartPalletsCartons
     *
     * @return void
     */
    public function viewPartPalletsCartons()
    {
        $view_perms = $this->Pallets->getViewPermNumber('view_in_stock');
        $query = $this->Pallets->find();

        $query->select([
            'cartonRecordCount' => $query->func()->count('Carton.id'),
        ])->select(
            $this->Pallets
        )->select($this->Pallets->Shipments)
            ->select($this->Pallets->Items)
            ->select($this->Pallets->Locations)
            ->select($this->Pallets->InventoryStatuses)
            ->where([
                'OR' => [
                    'InventoryStatuses.perms & ' . $view_perms,
                    'Pallets.inventory_status_id' => 0,
                ],
            ])->limit(20)
            ->join([
                [
                    'table' => 'cartons',
                    'alias' => 'Carton',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Carton.pallet_id = Pallets.id',
                    ],
                ],
            ])->contain([
                'Items',
                'Shipments',
                'Cartons',
                'Locations',
                'InventoryStatuses',
            ])->group([
                'Pallets.id',
            ])->having([
                'OR' => [
                    [
                        'OR' => [
                            'Shipments.shipped IS NULL',
                            'Shipments.shipped = 0',
                        ],
                        [
                            'cartonRecordCount > 1',
                        ],
                    ],
                    [
                        'Items.quantity <> Pallets.qty',
                        'OR' => [
                            'Shipments.shipped IS NULL',
                            'Shipments.shipped = 0',
                        ],
                    ],
                ],
            ])->orderDesc('Pallets.production_date');

        // This behavior implements paginate and paginateCount
        // because the default paginateCount will not work with the HAVING clause
        //$this->Pallets->Behaviors->load('Cartons');

        //$this->paginate = $options;

        // $pallets = $this->Pallets->find('all', $query);

        $pallets = $this->paginate($query);
        $this->set(compact('pallets'));
    }

    /**
     * Shows onhand stock and adds flags such as oncooldown,
     * pallet age, dont_ship etc
     *
     * @return void
     */
    public function onhand()
    {
        $cooldown = $this->Pallets->getSetting('COOL_DOWN_HRS');

        $searchForm = new OnhandSearchForm();

        $filter_value = $this->request->getQuery('filter_value');

        if ($filter_value) {
            $searchForm->setData($this->request->getQuery());
        }

        [$pallets, $options] = $this->Pallets->buildOnHandQuery($filter_value);

        $limit = Configure::read('onhandPageSize');

        $this->paginate = [
            'limit' => $limit,
            'maxLimit' => $limit,
            'sortWhitelist' => [
                'id',
                'location_id',
                'item_id',
                'description',
                'pl_ref',
                'production_date',
                'bb_date',
                'batch',
                'qty',
                'shipment_id',
                'inventory_status_id',
            ],
            'order' => [
                'id' => 'DESC',            
            ],
        ];


        $pallets  = $this->paginate($pallets);

        $pallet_count = $this->Pallets->find('all', $options)->count();

        $filter_values = $this->Pallets->getFilterValues();

        $dont_ship_count = $this->Pallets->getDontShipCount($pallets);

        $this->set(
            compact(
                'cooldown',
                'pallets',
                'pallet_count',
                'filter_values',
                'dont_ship_count',
                'searchForm'
            )
        );
    }

    /**
     * @return mixed
     */
    public function search()
    {
        // the page we will redirect to
        $url['action'] = 'onhand';
        if (!empty($this->request->getData('filter_value'))) {
            $url['?'] = $this->request->getData();
        }

        return $this->redirect($url);
    }

    public function sendFile($id)
    {
        $downloadParam = $this->request->getQuery('download');

        $download = is_null($downloadParam) || (int) $downloadParam === 1  ? true : false;

        $response = $this->response;

        $outputPath = $this->getSetting('LABEL_OUTPUT_PATH');
        $downloadFilePath = WWW_ROOT . $outputPath . DS;

        $pallet = $this->Pallets->get($id);
        
        $filename = $pallet->pallet_label_filename;

        $fullPath = $downloadFilePath . $pallet->pallet_label_filename;

        if (!$this->Pallets->checkFileExists($outputPath, $filename)) {
            $this->Flash->error('Label not available for download. Please Reprint to make one available');
            return $this->redirect(['controller' => 'PrintLog', 'action' => 'palletLabelReprint', $id]);
        }

        if ($download === false) {
            $response = $response->withHeader('Content-Disposition', "inline; filename=" . $filename);
        }

        $response = $response->withFile(
            $fullPath,
            ['download' => $download, 'name' =>  $filename]
        );

        return $response;
    }

    public function export()
    {
        Configure::write('debug', false);

        $filter_value = $this->request->getQuery('filter_value');

        $header = ['Location', 'Status', 'Note', 'Item', 'Description', "Print Date", 'Best Before', "Age", "Ref", "Batch", "Qty", "Shipment",  "Low Date", 'Allow Ship', 'SSCC'];

        $companyPrefix = $this->getSetting('SSCC_COMPANY_PREFIX');

        $extract = [
            function (array $row) {
                return $row['location']['location'] ?? $row['location']['location'];
            },
            function (array $row) {
                return $row['inventory_status']['name'] ?? $row['inventory_status']['name'];
            },
            'inventory_status_note',
            'item',
            'description',
            'print_date',
            'bb_date',
            function (array $row) {
                $time = new Time($row['print_date']);
                return $time->timeAgoInWords();
            },
            'pl_ref',
            'batch',
            'qty',
            function (array $row) {
                return $row['shipment']['shipper'] ?? $row['shipment']['shipper'];
            },

            'dont_ship',
            'ship_low_date',

            function (array $row) use ($companyPrefix) {
                $barcode = new Barcode();
                return  $barcode->ssccFormat($row['sscc'], $companyPrefix);
            },
        ];

        [$pallets, $options] = $this->Pallets->buildOnHandQuery($filter_value);

        $this->setResponse($this->getResponse()->withDownload('pallets.csv'));

        // $header = $pallets->toArray()[0]->getVisible();


        $this->set(compact('pallets'));

        $this->viewBuilder()
            ->setClassName('CsvView.Csv')
            ->setOptions([
                'serialize' => 'pallets',
                'header' => $header,
                'extract' => $extract,
            ]);

        // Configure::write('debug', true);
    }

    /**
     * @param  int   $id Supply ID of pallet
     * @return mixed
     */
    public function modifyPallet($id = null)
    {

        $user = $this->Authentication->getIdentity();

        $pallet = $this->Pallets->get($id, [
            'contain' => [
                'Locations',
                'Cartons',
                'Items',
                'Shipments'
            ],
        ]);

        if (isset($pallet['shipment']['shipped']) && (bool) $pallet['shipment']['shipped']) {
            $this->Flash->error('Cannot modify a pallet that is already shipped');
            return $this->redirect($this->request->referer(false));
        }

        if ($this->request->is(['post', 'put']) && $user->can('bestBeforeEdit', $pallet)) {


            $data = $this->request->getData();

            [$total, $result] = $this->Pallets->Cartons->processCartons($data['cartons'], $user);

            if($result) {
                $this->Flash->error($result, ['escape' => false]);
            } else {
                unset($data['cartons']);

                $pallet->qty = $total;
    
                $patched = $this->Pallets->patchEntity($pallet, $data);
    
                if ($this->Pallets->save($patched)) {
                    $this->Flash->success(__('The pallet data has been saved.'));
    
                    $event = new Event('Model.Pallets.updateBestBeforeAndProductionDate', $pallet, ['id' => $id]);
                    $this->getEventManager()->dispatch($event);
    
                    if ($data['submit-action'] === 'submit-and-reprint') {
                        $companyName = $this->getSetting("COMPANY_NAME");
                        $action = $this->request->getParam('action');
    
                        $this->Pallets->reprintLabel($id, null, $companyName, $action);
                    }
    
                    return $this->redirect($this->request->getData()['referer']);
                    
                } else {
                    $validationErrors = $this->Pallets->flattenAndFormatValidationErrors($patched->getErrors());
                    $this->Flash->error(__('The  pallet data could not be saved. Please, try again.' . $validationErrors));
                }
            }

           
        }

        $cartons = $pallet['cartons'];

        array_push($cartons, [
            'count' => '',
            'best_before' => '',
            'pallet_id' => $id,
            'item_id' => $pallet->item_id
        ]);

        $pallet['cartons'] = $cartons;

        $pallet->qty_before = $pallet->qty;

        $item_data = $this->Pallets->Items->get($pallet->item_id, ['contain' => []]);

        $item_qty = $item_data['quantity'];

        $inventory_statuses = $this->Pallets->InventoryStatuses->find('list');

        $productType = $this->Pallets->getProductType($id);

        $productTypeId = isset($productType['id'])
            ? $productType['id'] : 0;

        $availableLocations = $this->Pallets->getAvailableLocations('available', $productTypeId);

        $locationsCombined = $availableLocations;

        if ($pallet->has('location')) {
            $currentLocation = [
                $pallet['location']['id'] => $pallet['location']['location'],
            ];

            $locationsCombined = $locationsCombined + $currentLocation;
        }

        asort($locationsCombined, SORT_NATURAL);

        $locations = $locationsCombined;

        //$pallet->qty_user_id = $this->Auth->user()['id'];

        $pallet->product_type_id = $item_data['id'];

        $referer = $this->request->referer(false);

        $restricted = false;
        $user = $this->Authentication->getIdentity();

        if (!$user->can('bestBeforeEdit', $pallet)) {
            $this->Flash->error(
                __(
                    "<strong>{0}</strong> doesn't have edit access. Please contact <strong>{1}</strong> on <strong>{2}</strong> for assistance",
                    $user->get('username'),
                    Configure::read('contact.company'),
                    Configure::read('contact.phone')
                ),
                ['escape' => false]
            );
        }

        $this->set(
            compact(
                'item_qty',
                'user',
                'locations',
                'referer',
                'pallet',
                'inventory_statuses',
                'restricted'
            )
        );
    }

    public function missingLabel()
    {   
        $id = $this->request->getQueryParams()['id'];
        $pallet = $this->Pallets->get($id);

        $this->set(compact('id', 'pallet'));

        
    }
}
