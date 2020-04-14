<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\LookupSearchForm;
use App\Form\OnhandSearchForm;
use App\Form\PalletPrintForm;
use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\LabelFactory;
use App\Lib\PrintLabels\PalletPrintResultTrait;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

/**
 * Pallets Controller
 *
 * @property \App\Model\Table\PalletsTable $Pallets
 * @property Authentication $Authentication
 *
 * @method \App\Model\Entity\Pallet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PalletsController extends AppController
{
    use PalletPrintResultTrait;

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

        $isPrintDebugMode = Configure::read('pallet_print_debug');

        if (!$productTypeId) {
            $this->Flash->error('Select a product type from the actions on the left');
            $this->set(compact('productTypes'));
            return;
        }

        $productType = $this->Pallets->Items->ProductTypes->get($productTypeId);

        // if the product_type has a default save location defined
        // set location_id else return 0

        $locationId = $productType['location_id'] > 0 ? $productType['location_id'] : 0;

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

        $inventoryStatusId = ($productType->inventory_status_id > 0)
            ? $productType->inventory_status_id : 0;

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $formName = $data['formName'];

            if ($forms[$formName]->validate($data)) {
                $newData = [];
                foreach ($data as $key => $value) {
                    $newKey = str_replace($formName . '-', '', $key);
                    $newData[$newKey] = $value;
                }
                $data = $newData;

                $productionLineId = $data['production_line'];

                $productionLine = $this->Pallets->Items
                    ->ProductTypes->ProductionLines->get($productionLineId);

                $productionLineName = $productionLine['name'];

                $printerId = $productionLine['printer_id'];

                $printerDetails = $this->Pallets->Printers->get($printerId);

                if (empty($printerDetails)) {
                    throw new MissingConfigurationException(
                        [
                            'message' => 'Missing Printer',
                            'printer' => $printerId,
                        ],
                        404
                    );
                }

                $sscc = $this->Pallets->generateSSCCWithCheckDigit();

                $pallet_ref = $this->Pallets->createPalletRef($productTypeId);

                $item_detail = $this->Pallets->Items->get($data['item']);

                $labelCopies = $item_detail['pallet_label_copies'] > 0
                    ? $item_detail['pallet_label_copies']
                    : $this->Pallets->getSetting('sscc_default_label_copies');

                $printTemplateId = $item_detail['pallet_template_id'];

                $qty = !empty($data['qty'])
                    ? $data['qty']
                    : $item_detail['quantity'];

                $days_life = $item_detail['days_life'];

                $print_date = new FrozenTime();

                $print_date_plus_days_life = $print_date->addDays($days_life);

                $bestBeforeDates = $this->Pallets->formatLabelDates(
                    $print_date_plus_days_life,
                    [
                        'bb_date' => 'Y-m-d',
                        'bb_bc' => 'ymd',
                        'bb_hr' => 'd/m/y',
                    ]
                );

                $palletData =
                    [
                        'item' => $item_detail['code'],
                        'description' => $item_detail['description'],
                        'bb_date' => $bestBeforeDates['bb_date'],
                        'item_id' => $data['item'],
                        'batch' => $data['batch_no'],
                        'qty' => $qty,
                        'qty_previous' => 0,
                        'pl_ref' => $pallet_ref,
                        'gtin14' => $item_detail['trade_unit'],
                        'sscc' => $sscc,
                        'printer' => $printerDetails['name'],
                        'printer_id' => $printerId,
                        'print_date' => $print_date,
                        'cooldown_date' => $print_date,
                        'location_id' => $locationId,
                        'shipment_id' => 0,
                        'inventory_status_id' => $inventoryStatusId,
                        'production_line' => $productionLineName,
                        'production_line_id' => $productionLineId,
                        'product_type_id' => $productType['id'],
                    ];

                // the print template contents which has the replace tokens in it

                $printTemplate = $this->Pallets->Items->PrintTemplates->find()
                ->where([
                    'id' => $printTemplateId,
                    'active' => 1,
                ])
                ->firstOrFail()->toArray();

                if (empty($printTemplate)) {
                    throw new MissingConfigurationException(
                        [
                            'message' => __(
                                'Print Template Missing: Check the <strong>"Pallet Label Print Template"</strong> setting of item <a href="%s">%s</a>',
                                Router::url(
                                    [
                                        'controller' => 'Items',
                                        'action' => 'edit',
                                        $item_detail['Item']['id'],
                                    ]
                                ),
                                $item_detail['Item']['code']
                            ), ],
                        500
                    );
                }

                $cabLabelData = [
                    'companyName' => Configure::read('companyName'),
                    'internalProductCode' => $item_detail['code'],
                    'reference' => $pallet_ref,
                    'sscc' => $sscc,
                    'description' => $item_detail['description'],
                    'gtin14' => $item_detail['trade_unit'],
                    'quantity' => $qty,
                    'bestBeforeHr' => $bestBeforeDates['bb_hr'],
                    'bestBeforeBc' => $bestBeforeDates['bb_bc'],
                    'batch' => $data['batch_no'],
                    'numLabels' => $labelCopies,
                ];

                $printResult = LabelFactory::create($this->request->getParam('action'))
                    ->format($printTemplate, $cabLabelData)
                        ->print($printerDetails->toArray());

                $isPrintDebugMode = Configure::read('pallet_print_debug');

                $this->handleResult(
                    $printResult,
                    $printerDetails,
                    $pallet_ref,
                    $palletData,
                    $isPrintDebugMode,
                    $data['refer']
                );
            } else {
                $this->Flash->error('There was a problem submitting your form.');
                $forms[$this->request->getData()['formName']]->setData($this->request->getData());
                $forms[$this->request->getData()['formName']]->setErrors($forms[$this->request->getData()['formName']]->getErrors());
            }
        } // end of post check
        // populate form

        $batch_nos = $this->Pallets->getBatchNumbers();

        $items = $this->Pallets->Items->getPalletPrintItems($productTypeId);

        $refer = $this->request->getPath();

        $this->set(
            compact(
                'items',
                'productionLines',
                'batch_nos',
                'productType',
                'productTypes',
                'refer',
                'forms'
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
     * @param string|null $id Pallet id.
     * @return \Cake\Http\Response|null|void Renders view
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
     * @param string|null $id Pallet id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
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
     * @param string|null $id Pallet id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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
                $pallet['inventory_status_id'] >= 0) || $pallet['inventory_status_id'] === $setNoteKey)
               ) {
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
                    return $this->redirect($this->request->referer());
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
            'maxLimit' => 3000, ];

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
     * @param ID $id ID of Pallet
     * @return mixed
     */
    public function changeLocation($id = null)
    {
        if (!$this->Pallets->exists($id)) {
            throw new NotFoundException(__('Invalid label'));
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->Pallets->save($this->request->getData())) {
                $this->Flash->set(__('The label has been saved.'));

                return $this->redirect(['action' => 'onhand']);
            } else {
                $this->Flash->set(__('The label could not be saved. Please, try again.'));
            }
        } else {
            $this->request->withData($this->Pallets->get($id)) ;
        }
        $locations = $this->Pallets->Locations->find('list');
        $shipments = $this->Pallets->Shipments->find('list');
        $this->set(compact('locations', 'shipments'));
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
    * @param int $id Supply ID of pallet
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
                $validationErrors = $this->Pallets->formatValidationErrors($patched->getErrors());
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

        $referer = $this->referer();
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
        if ($this->request->is('POST')) {
            $query_date = $this->request->getData('start_date');

            if (!empty($url_date)) {
                $query_date = $url_date;
            }

            $reports = $this->Pallets->shiftReport($query_date);
            //$this->log(pr($reports));

            $this->set('reports', $reports['reports']);
            $this->set('shift_date', $query_date);
            $this->set('xml_shift_report', $reports['xml_shift_report']);
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
        // $this->Authorization->skipAuthorization();

        $options = [];

        if (!empty($this->request->getQueryParams())) {
            $options = $this->Pallets->formatLookupActionConditions(
                $this->request->getQueryParams()
            );

            /*  $searchForm = $this->Pallets->formatLookupRequestData(
                 $this->request->getQueryParams()
             ); */
        }

        tog($options);

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
     * @param int $id ID of Pallet
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

        $referer = $this->referer();

        $availableLocations = $this->Pallets->getAvailableLocations('available', $pallet->product_type_id);

        $this->set(compact('availableLocations', 'pallet', 'referer'));
    }

    /**
         * edit method
         *
         * @throws NotFoundException
         * @param string $id ID of pallet
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
                        'The product has been saved to the <strong>{0}</strong> location',
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
            $pallet = $this->Pallets->get($id);

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
                    'The last product was saved to <strong>{0}</strong>. There are no pallets to put away',
                    $last_pallet['location']['location']
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
     * view method
     *
     * @throws NotFoundException
     * @param string $id ID of Pallet
     * @return mixed
     */
    public function palletReprint($id = null)
    {
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $pallet = $this->Pallets->get(
            $id,
            [
                'contain' => [
                    'Items' => [
                        'ProductTypes',
                        'PrintTemplates',
                    ],
                ], ]
        );

        $this->Pallets->getValidator()->add('printer_id', 'required', [
            'rule' => 'notBlank',
            'message' => 'Please select a printer',
        ]);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $pallet_ref = $pallet->pl_ref;

            if (!isset($pallet['items']['print_template']) || empty($pallet['items']['print_template'])) {
                throw new MissingConfigurationException(__('Please configure a print template for item %s', $pallet['item']));
            }

            $replaceTokens = json_decode($pallet->items->print_template->replace_tokens);

            // get the printer queue name
            $printerId = $data['printer_id'];

            $printerDetails = $this->Pallets->Printers->get($printerId);

            $dateFormats = [
                'bb_date' => 'Y-m-d',
                'bb_bc' => 'ymd',
                'bb_hr' => 'd/m/y',
            ];

            $bestBeforeDates = $this->Pallets->formatLabelDates(
                $pallet['bb_date'],
                $dateFormats
            );

            $cabLabelData = [
                'companyName' => Configure::read('companyName'),
                'internalProductCode' => $pallet['items']['code'],
                'reference' => $pallet['pl_ref'],
                'sscc' => $pallet['sscc'],
                'description' => $pallet['items']['description'],
                'gtin14' => $pallet['gtin14'],
                'quantity' => $pallet['qty'],
                'bestBeforeHr' => $bestBeforeDates['bb_hr'],
                'bestBeforeBc' => $bestBeforeDates['bb_bc'],
                'batch' => $pallet['batch'],
                'numLabels' => $this->request->getData()['copies'],
            ];

            $isPrintDebugMode = Configure::read('pallet_print_debug');

            $printResult = LabelFactory::create($action)
                ->format($pallet['items']['print_template'], $cabLabelData)
                ->print($printerDetails);

            $this->handleResult(
                $printResult,
                $printerDetails,
                $pallet_ref,
                $pallet,
                $isPrintDebugMode,
                $this->request->referer(),
                false
            );
        }

        $printers = $this->Pallets->getLabelPrinters(
            $controller,
            $action
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers
        unset($pallet['printer_id']);

        $labelCopies = $pallet['items']['pallet_label_copies'] > 0
            ? $pallet['items']['pallet_label_copies']
            : $this->Pallets->getSetting('sscc_default_label_copies');

        $tag = 'Pallet';

        $labelCopiesList = [];

        for ($i = 1; $i <= $labelCopies; $i++) {
            if ($i > 1) {
                $tag = Inflector::pluralize($tag);
            } else {
                $tag = Inflector::singularize($tag);
            }
            $labelCopiesList[$i] = $i . ' ' . $tag;
        }

        $refer = $this->referer();

        $inputDefaultCopies = $this->Pallets->getSetting('sscc_default_label_copies');

        $this->set(
            compact(
                'labelCopiesList',
                'pallet',
                'printers',
                'refer',
                'inputDefaultCopies'
            )
        );
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
            ])->orderDesc('Pallets.print_date');

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
        //$this->Pallet->Behaviors->load('Containable');

        $cooldown = $this->Pallets->getSetting('cooldown');
        $searchForm = new OnhandSearchForm();

        /*  $this->Pallet->virtualFields['oncooldown'] = 'TIMESTAMPDIFF(HOUR, Pallet.cooldown_date, NOW()) < ' . $cooldown;
         $this->Pallet->virtualFields['pl_age'] = 'TIMESTAMPDIFF(HOUR, Pallet.print_date, NOW())';
 */

        if (!empty($this->request->getQuery('filter_value'))) {
            $filter_value = $this->request->getQuery('filter_value');
            //debug($this->passedArgs);

            $searchForm->setData($this->request->getQuery());

            $lookup_field = 'item_id';

            switch ($filter_value) {
                case 'low_dated':
                    $sqlValue = 1;
                    $lookup_field = 'dont_ship';
                    break;
                case strpos($filter_value, 'product-type-') !== false:
                    $sqlValue = str_replace('product-type-', '', $filter_value);
                    $lookup_field = 'product_type_id';
                    break;
                default:
                    $lookup_field = 'item_id';
                    $sqlValue = $filter_value;
                    break;
            }
        }

        $containSettings = [
            'Shipments' => [
                'fields' => [
                    'id', 'shipper',
                ],
            ],
            'InventoryStatuses' => [
                'fields' => [
                    'id', 'name',
                ],
            ],
            'Items' => [
                'fields' => ['id', 'code', 'description'],
            ],
            'Locations' => [
                'fields' => ['id', 'location'],
            ],
        ];

        $options = $this->Pallets->getViewOptions($containSettings);

        if (!empty($filter_value) && $lookup_field !== 'dont_ship') {
            $options['conditions']['Pallets.' . $lookup_field] = $sqlValue;
        }

        $limit = Configure::read('onhandPageSize');

        $this->paginate = [
            'limit' => $limit,
            'maxLimit' => $limit,
            'order' => [
                'Pallets.item' => 'ASC',
                // oldest first
                'Pallets.pl_ref' => 'ASC',
            ],
        ];

        $pallets = $this->Pallets->find('all', $options)
        ->select([
            'dont_ship' => 'DATEDIFF(Pallets.bb_date, CURDATE()) < Pallets.min_days_life AND Pallets.shipment_id = 0',
        ])->select($this->Pallets);

        if (!empty($lookup_field) && $lookup_field == 'dont_ship') {
            $pallets->having(['DATEDIFF(Pallets.bb_date, CURDATE()) < Pallets.min_days_life AND Pallets.shipment_id = 0']);
        }

        $pallets = $this->paginate($pallets);

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
}