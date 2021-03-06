<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\BigNumberForm;
use App\Form\CrossdockLabelForm;
use App\Form\CustomPrintForm;
use App\Form\KeepRefrigeratedForm;
use App\Form\SampleLabelForm;
use App\Form\ShippingLabelsForm;
use App\Form\ShippingLabelsGenericForm;
use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Glabel\GlabelsProject;
use App\Lib\PrintLabels\LabelFactory;
use App\Lib\PrintLabels\ResultTrait;
use App\Lib\PrintLabels\Template;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenTime;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Utility\Inflector;
use App\Lib\PrintLabels\Glabel\ShippingLabelGeneric;
use Cake\Event\Event;
use App\Lib\PrintLabels\PrintLabel;
use App\Model\Table\PalletsTable;

/**
 * PrintLog Controller
 *
 * @property \App\Model\Table\PrintLogTable $PrintLog
 *
 * @method \App\Model\Entity\PrintLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrintLogController extends AppController
{
    use ResultTrait;

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $printLog = $this->paginate($this->PrintLog);

        $this->set(compact('printLog'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Print Log id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $printLog = $this->PrintLog->get($id, [
            'contain' => [],
        ]);

        $this->set('printLog', $printLog);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $printLog = $this->PrintLog->newEmptyEntity();
        if ($this->request->is('post')) {
            $printLog = $this->PrintLog->patchEntity($printLog, $this->request->getData());
            if ($this->PrintLog->save($printLog)) {
                $this->Flash->success(__('The print log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The print log could not be saved. Please, try again.'));
        }
        $this->set(compact('printLog'));
    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id Print Log id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $printLog = $this->PrintLog->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $printLog = $this->PrintLog->patchEntity($printLog, $this->request->getData());
            if ($this->PrintLog->save($printLog)) {
                $this->Flash->success(__('The print log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The print log could not be saved. Please, try again.'));
        }

        $this->set(compact('printLog'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id Print Log id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $printLog = $this->PrintLog->get($id);
        if ($this->PrintLog->delete($printLog)) {
            $this->Flash->success(__('The print log has been deleted.'));
        } else {
            $this->Flash->error(__('The print log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * dayOfYear shows day_of_year.ctp but doesn't do much else
     * @return void
     */
    public function dayOfYear()
    {
    }

    /**
     * labelChooser method action
     *
     * @return mixed
     */
    public function labelChooser()
    {
        $glabelsRoot = $this->PrintLog->getSetting('TEMPLATE_ROOT');

        $printTemplatesThreaded = $this->PrintLog
            ->getSettingsTable('PrintTemplates')
            ->find('threaded')
            ->order([
                'lft' => 'ASC',
            ]);

        $this->set(compact('glabelsRoot', 'printTemplatesThreaded'));
    }

    /**
     * @param  int  $printLogId Print ID
     * @return void
     */
    public function completed($printLogId = null)
    {
        /* $completed = $this->PrintLog->get($printLogId);

        $this->set(compact('completed')); */
    }

    /**
     * Ajax endpoint for cartonPrint action
     *
     * @return void
     */
    public function printCartonLabels()
    {
        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            $itemsTable = $this->getTableLocator()->get('Items');

            $printTemplate = $itemsTable->find()
                ->where([
                    'Items.trade_unit' => $data['barcode'],
                ])->contain([
                    'CartonTemplates',
                ])->first()->toArray();

            $printerDetails = $this->PrintLog->getLabelPrinterById($data['printer_id']);

            $printResult = LabelFactory::create($printTemplate['carton_template']['print_class'], $this->request->getParam('action'))
                ->format($printTemplate['carton_template'], $data)
                ->print($printerDetails);

            if ($printResult['return_value'] == 0) {
                $logData = $this->PrintLog->formatPrintLogData(
                    $data['controller_action'],
                    $data
                );
                $newEntity = $this->PrintLog->newEntity($logData);
                $this->PrintLog->save($newEntity);
            }

            $replyData = $data + $printResult;
            $replyData['name'] = $printerDetails['name'];

            $this->set('data', $replyData);
            $this->set('_serialize', ['data']);
        }
    }

    /**
     * cartonPrint
     *
     * @return void
     */
    public function cartonPrint()
    {
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $controllerAction = $controller . '::' . $action;

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $printTemplate = $this->getTableLocator()->get('PrintTemplates')->find()->where([
            'controller_action' => $controllerAction,
            'active' => 1,
        ])->first();

        $glabelsRoot = $this->PrintLog->getSetting('TEMPLATE_ROOT');

        $template = new Template($printTemplate, $glabelsRoot);

        $this->set('controllerAction', $controllerAction);
        $this->set(compact('printers', 'printTemplate', 'template'));
    }

    /**
     * crossdockLabels
     *
     * @return mixed
     */
    public function crossdockLabels()
    {
        $controllerAction = $this->getControllerAction();

        $action = $this->request->getParam('action');

        $template = $this->PrintLog->getTemplate(
            $controllerAction
        );

        $form = new CrossdockLabelForm();

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );

                $glabelsData = $data + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($template->details->print_class, $action)
                    ->format($template, $glabelsData)
                    ->print($printerDetails);


                $this->handlePrintResult(
                    $printResult,
                    $saveData,
                    [
                        'error' => [
                            'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                            'values' => [$template->details->name, $printerDetails->name]
                        ],
                        'success' => [
                            'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                            'values' => [$template->details->name, $printerDetails->name, $printResult['stderr']]
                        ]
                    ]
                );
            } else {
                $this->Flash->error('Invalid data');
            }
        }
        $maxShippingLabels = $this->PrintLog->getSetting('MAX_SHIPPING_LABELS');

        $sequence = $this->PrintLog->createSequenceList($maxShippingLabels);

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $companyName = $this->companyName;

        $this->set(compact('template', 'companyName', 'sequence', 'printers', 'form'));
    }

    /**
     * shippingLabels
     * @return mixed
     */
    public function shippingLabels()
    {
        $maxShippingLabels = $this->PrintLog->getSetting('MAX_SHIPPING_LABELS');

        $shippingLabel = new ShippingLabelsForm();

        $controllerAction = $this->getControllerAction();

        $action = $this->request->getParam('action');

        $template = $this->PrintLog->getTemplate(
            $controllerAction
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            if ($shippingLabel->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );

                $printerDetails = $this->PrintLog->getLabelPrinterById($data['printer']);

                $printResult = LabelFactory::create($template->details->print_class, $action)
                    ->format($template, $this->request->getData())
                    ->print($printerDetails);

                $this->handlePrintResult(
                    $printResult,
                    $saveData,
                    [
                        'error' => [
                            'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                            'values' => [$template->details->name, $printerDetails->name]
                        ],
                        'success' => [
                            'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                            'values' => [$template->details->name, $printerDetails->name, $printResult['stderr']]
                        ]
                    ]
                );
            } else {
                $this->Flash->error('no way');
            }
        }

        $sequence = $this->PrintLog->createSequenceList($maxShippingLabels);

        $totalLabels = $this->PrintLog->getSetting('MAX_SHIPPING_LABELS');

        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller') . '::' . $this->request->getParam('action')
        );

        $this->set(compact('totalLabels', 'template', 'printers', 'sequence', 'shippingLabel'));
    }

    /**
     * shippingLabelsGeneric
     * @return mixed
     *
     */
    public function shippingLabelsGeneric()
    {
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');
        $controllerAction = $this->getControllerAction();
        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        /**
         * @var GlabelsTemplate $template Glabels Configuration
         */
        $template = $this->PrintLog->getTemplate(
            $controllerAction
        );

        $form = new ShippingLabelsGenericForm();

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );

                $glabelsData = $data + $saveData;
                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById($glabelsData['printer']);

                $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                    ->format($template, $glabelsData)
                    ->print($printerDetails);

                    $this->handlePrintResult(
                        $printResult,
                        $saveData,
                        [
                            'error' => [
                                    'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                    'values' => [ $template->details->name, $printerDetails->name ] 
                            ], 
                            'success' => [
                                'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                            ]
                        ]
                    );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $companyName = $this->companyName;

        $this->set(compact('template', 'printers', 'form', 'companyName'));
    }

    /**
     * keepRefrigerated
     * @return mixed
     */
    public function keepRefrigerated()
    {
        $form = new KeepRefrigeratedForm();

        $controllerAction = $this->getControllerAction();

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $template = $this->PrintLog->getTemplate(
            $controllerAction
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );

                $glabelsData = $data + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                    ->format($template, $glabelsData)
                    ->print($printerDetails);
               
                    $this->handlePrintResult(
                        $printResult,
                        $saveData,
                        [
                            'error' => [
                                    'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                    'values' => [ $template->details->name, $printerDetails->name ] 
                            ], 
                            'success' => [
                                'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                            ]
                        ]
                    );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('template', 'printers', 'form'));
    }

    /**
     * glabelSampleLabels
     * @return mixed
     */
    public function glabelSampleLabels()
    {
        $glabelsSample = new KeepRefrigeratedForm();

        $controllerAction = $this->getControllerAction();

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $template = $this->PrintLog->getTemplate(
            $controllerAction
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            if ($glabelsSample->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );

                $glabelsData = $data + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                    ->format($template, $glabelsData)->print(
                        $printerDetails
                    );

                    $this->handlePrintResult(
                        $printResult,
                        $saveData,
                        [
                            'error' => [
                                    'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                    'values' => [ $template->details->name, $printerDetails->name ] 
                            ], 
                            'success' => [
                                'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                            ]
                        ]
                    );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('template', 'printers', 'glabelsSample'));
    }

    /**
     * bigNumber action method
     *
     * @return mixed
     */
    public function bigNumber()
    {
        $controllerAction = $this->getControllerAction();

        $bigNumber = new BigNumberForm();

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $printerId = $printers['default'];

        $printer = $printers['printers'][$printerId];

        $printTemplatesTable = $this->getTableLocator()->get('PrintTemplates');

        $printTemplate = $printTemplatesTable->find()
            ->where(
                [
                    'PrintTemplates.controller_action' => $controllerAction,
                    'PrintTemplates.active' => 1,
                ],
            )->first();

        $exampleImage = $printTemplate['example_image'];

        $glabelsRoot = $this->PrintLog->getSetting('TEMPLATE_ROOT');

        if ($this->request->is(['POST', 'PUT'])) {
            $formData = $this->request->getData();

            $printerDetails = $this->PrintLog->getLabelPrinterById(
                $formData['printerId']
            );

            $saveData = $this->PrintLog->formatPrintLogData(
                $controllerAction,
                $formData
            );

            $formData['companyName'] = $this->companyName;

            $printResult = LabelFactory::create($printTemplate->print_class, $this->request->getParam('action'))
                ->format($printTemplate, $formData)
                ->print($printerDetails);

                $this->handlePrintResult(
                    $printResult,
                    $saveData,
                    [
                        'error' => [
                                'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name ] 
                        ], 
                        'success' => [
                            'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                            'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                        ]
                    ]
                );
        }

        $this->set(compact('printer', 'printerId', 'exampleImage', 'glabelsRoot', 'printTemplate'));
    }

    public function customPrint()
    {
        $controllerAction = $this->getControllerAction();

        $template = $this->PrintLog->getTemplate($controllerAction);

        $form = (new CustomPrintForm())->setCopies(Configure::read('MAX_COPIES'));

        $fields = ['copies', 'printer'];

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );

                $glabelsData = $data + $saveData;

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $data['printer']
                );

                $data['csv'] = $template->details->text_template;

                $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                    ->format($template, $data)
                    ->print(
                        $printerDetails
                    );

                    $this->handlePrintResult(
                        $printResult,
                        $saveData,
                        [
                            'error' => [
                                    'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                    'values' => [ $template->details->name, $printerDetails->name ] 
                            ], 
                            'success' => [
                                'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                            ]
                        ]
                    );
            } else {
                $this->Flash->error('Invalid data!');
                $form->setData($this->request->getData());
                $form->setErrors($form->getErrors());
            }
        }

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $this->set(compact('template', 'form', 'printers'));
    }

    /**
     * sampleLabels
     * @return mixed
     */
    public function sampleLabels()
    {
        $controllerAction = $this->getControllerAction();

        $form = new SampleLabelForm();

        $maxShippingLabels = $this->PrintLog->getSetting('MAX_SHIPPING_LABELS');
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $template = $this->PrintLog->getTemplate(
            $controllerAction
        );

        $printers = $this->PrintLog->getLabelPrinters(
            $controllerAction
        );

        $sequence = $this->PrintLog->createSequenceList(
            $maxShippingLabels,
            1,
            [
                50, 60, 80, 100, 200,
            ]
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $controllerAction,
                    $data
                );
                $glabelsData = $data + $saveData;
                $printerDetails = $this->PrintLog->getLabelPrinterById($glabelsData['printer']);

                $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                    ->format($template, $glabelsData)
                    ->print($printerDetails);

                    $this->handlePrintResult(
                        $printResult,
                        $saveData,
                        [
                            'error' => [
                                    'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                    'values' => [ $template->details->name, $printerDetails->name ] 
                            ], 
                            'success' => [
                                'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                            ]
                        ]
                    );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('sequence', 'template', 'printers', 'form'));
    }

    public function ssccLabel($id = null)
    {
        $controllerAction = $this->getControllerAction();

        $palletTable = $this->getTableLocator()->get('Pallets');

        if ($id === null) {
            return $this->redirect($this->request->referer(false));
        }

        $options = [
            'contain' => [
                'Items' => [
                    'ProductTypes',
                    'PrintTemplates',
                ],
            ],
        ];

        $pallet = $palletTable->get($id, $options);

        $palletTable->getValidator()->add('printer_id', 'required', [
            'rule' => 'notBlank',
            'message' => 'Please select a printer',
        ]);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $pallet_ref = $pallet['pl_ref'];

            $replaceTokens = json_decode($pallet['items']['print_template']['replace_tokens']);

            if (!isset($pallet['items']['print_template']) || empty($pallet['items']['print_template'])) {
                throw new MissingConfigurationException(__('Please configure a print template for item %s', $pallet['item']));
            }

            // get the printer queue name
            $printerId = $data['printer_id'];

            $printerDetails = $palletTable->getLabelPrinterById($printerId);

            $dateFormats = [
                'bb_bc' => 'ymd',
                'bb_hr' => 'd/m/y',
            ];

            $bb_date = new FrozenTime($pallet['bb_date']);

            $bestBeforeDates = $this->PrintLog->formatLabelDates(
                $bb_date,
                $dateFormats
            );

            $cabLabelData = [
                'printDate' => $pallet['production_date'],
                'companyName' => $this->companyName,
                'internalProductCode' => $pallet['items']['code'],
                'reference' => $pallet['pl_ref'],
                'sscc' => $pallet['sscc'],
                'description' => $pallet['items']['description'],
                'gtin14' => $pallet['gtin14'],
                'quantity' => $pallet['qty'],
                'bestBeforeHr' => $bestBeforeDates['bb_hr'],
                'bestBeforeBc' => $bestBeforeDates['bb_bc'],
                'batch' => $pallet['batch'],
                'numLabels' => $data['copies'],
                'ssccBarcode' => '[00]' . $pallet['sscc'],
                'itemBarcode' => '[02]' . $pallet['gtin14'] .
                    '[15]' . $bestBeforeDates['bb_bc'] . '[10]' . $pallet['batch'] .
                    '[37]' . $pallet['qty'],
            ];

            $saveData = $this->PrintLog->formatPrintLogData(
                $controllerAction,
                $cabLabelData
            );

            $isPrintDebugMode = Configure::read('pallet_print_debug');

            $template = $this->PrintLog->getTemplate(
                'Pallets::lookup'
            );

            $printResult = LabelFactory::create($template->details->print_class, $this->request->getParam('action'))
                ->format($template, $cabLabelData)
                ->print($printerDetails);

                $this->handlePrintResult(
                    $printResult,
                    $saveData,
                    [
                        'error' => [
                                'template' => 'Error sending <strong>{0}</strong> to <strong>{1}</strong> printer',
                                'values' => [ $template->details->name, $printerDetails->name ] 
                        ], 
                        'success' => [
                            'template' => 'Successfully sent <strong>{0}</strong> to <strong>{1}</strong> printer',
                            'values' => [ $template->details->name, $printerDetails->name, $printResult['stderr'] ] 
                        ]
                    ]
                );
        }

        $printers = $palletTable->getLabelPrinters(
            $controllerAction
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers

        $labelCopies = $pallet['pallet_label_copies'] > 0
            ? $pallet['pallet_label_copies']
            : $this->PrintLog->getSetting('SSCC_DEFAULT_LABEL_COPIES');

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

        $refer = $this->request->referer();

        $inputDefaultCopies = $this->PrintLog->getSetting('SSCC_DEFAULT_LABEL_COPIES');

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

    public function palletLabelReprint($id = null)
    {
        $controllerAction = $this->getControllerAction();

        $companyName = $this->PrintLog->getSetting('COMPANY_NAME');

        $palletTable = $this->getTableLocator()->get('Pallets');

        if ($id === null) {
            return $this->redirect($this->request->referer(false));
        }

        $pallet = $palletTable->get($id, [
            'contain' => [
                'Items' => [
                    'ProductTypes',
                    'PrintTemplates',
                ],
            ],
        ]);

        $palletTable->getValidator()->add('printer_id', 'required', [
            'rule' => 'notBlank',
            'message' => 'Please select a printer',
        ]);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $pallet_ref = $pallet->pl_ref;

            if (!$pallet->has('items')  || !$pallet->items->has('print_template')) {
                throw new MissingConfigurationException(__('Please configure a print template for item {0}', $pallet->item));
            }

            // get the printer queue name
            $printerId = $data['printer_id'];

            $printerDetails = $palletTable->getLabelPrinterById($printerId);

            [$printResult, $labelClass] = $palletTable->reprintLabel(
                $pallet->id,
                $printerDetails,
                $companyName,
                $this->request->getParam('action')
            );

            $this->handlePrintResult(
                $printResult,
                ['controller_action' => $controllerAction, 'print_data' =>  json_encode($labelClass->getPrintContentArray())],
                [
                    'referer' => $data['refer'],
                    'error' => [
                        'template' => 'Failed sending pallet <strong>{0}</strong> using template <strong>{1}</strong> to <strong>{2}</strong> printer. Error: <strong>{3}</strong>',
                            'values' => [ $pallet->pl_ref, $pallet->items->print_template->name, $printerDetails->name,$printResult['stderr']] 
                    ], 
                    'success' => [
                        'template' => 'Successfully sent pallet <strong>{0}</strong> using template <strong>{1}</strong> to <strong>{2}</strong>.',
                        'values' => [ $pallet->pl_ref,  $pallet->items->print_template->name, $printerDetails->name] 
                    ]
                ]
            );
        }

        $printers = $palletTable->getLabelPrinters(
            $controllerAction
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers

        $labelCopies = $pallet['pallet_label_copies'] > 0
            ? $pallet['pallet_label_copies']
            : $this->PrintLog->getSetting('SSCC_DEFAULT_LABEL_COPIES');

        $tag = 'Copy';

        $labelCopiesList = [];

        for ($i = 1; $i <= $labelCopies; $i++) {
            if ($i > 1) {
                $tag = Inflector::pluralize($tag);
            } else {
                $tag = Inflector::singularize($tag);
            }
            $labelCopiesList[$i] = $i . ' ' . $tag;
        }

        $refer = $this->request->referer(false);

        $inputDefaultCopies = $this->PrintLog->getSetting('SSCC_DEFAULT_LABEL_COPIES');

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
}
