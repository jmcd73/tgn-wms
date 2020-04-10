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
use App\Lib\PrintLabels\LabelFactory;
use App\Lib\PrintLabels\ResultTrait;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use ShippingLabelGeneric;

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
     * @param string|null $id Print Log id.
     * @return \Cake\Http\Response|null|void Renders view
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
     * @param string|null $id Print Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
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
     * @param string|null $id Print Log id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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
        $glabelsRoot = $this->PrintLog->getSetting('GLABELS_ROOT');

        $printTemplatesThreaded = $this->PrintLog
            ->getSettingsTable('PrintTemplates')->find(
                'threaded'
            )->order([
                'lft' => 'ASC',
            ])->where([
                'active' => 1,
                'show_in_label_chooser' => 1,
            ])->toArray();

        $this->set(compact('glabelsRoot', 'printTemplatesThreaded'));
    }

    /**
     * @param int $printLogId Print ID
     * @return void
     */
    public function completed($printLogId = null)
    {
        $completed = $this->PrintLog->get($printLogId);

        $this->set(compact('completed'));
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

            $itemsTable = TableRegistry::get('Items');

            $printTemplate = $itemsTable->find()
            ->where([
                'Items.trade_unit' => $data['barcode'],
            ])->
                contain([
                    'CartonTemplates',
                ])->first()->toArray();

            $printerDetails = $this->PrintLog->getLabelPrinterById($data['printer_id']);

            $printResult = LabelFactory::create($this->request->getParam('action'))
                ->format($printTemplate['carton_template'], $data)
                    ->print($printerDetails);

            if ($printResult['return_value'] == 0) {
                $logData = $this->PrintLog->formatPrintLogData(
                    $data['print_action'],
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
        $printers = $this->PrintLog->getLabelPrinters(
            $controller,
            $action
        );

        $template = $this->PrintLog->getGlabelsDetail(
            $controller,
            $action
        );

        $printTemplate = TableRegistry::get('PrintTemplates')->find()->where([
            'print_controller' => $controller,
            'print_action' => $action,
            'active' => 1,
        ])->first()->toArray();

        $this->set('print_action', $action);
        $this->set(compact('printers', 'printTemplate', 'template'));
    }

    /**
     * crossdockLabels
     *
     * @return mixed
     */
    public function crossdockLabels()
    {
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $template = $this->PrintLog->getGlabelsDetail(
            $controller,
            $action
        );

        $form = new CrossdockLabelForm();

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $action,
                    $data
                );

                $glabelsData = $data + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($action)
                    ->format($glabelsData)
                        ->print($printerDetails, $template->file_path);

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
                );
            } else {
                $this->Flash->error('Invalid data');
            }
        }
        $maxShippingLabels = $this->PrintLog->getSetting('MaxShippingLabels');

        $sequence = $this->PrintLog->createSequenceList($maxShippingLabels);

        $printers = $this->PrintLog->getLabelPrinters(
            $controller,
            $action
        );

        $companyName = Configure::read('companyName');

        $this->set(compact('template', 'companyName', 'sequence', 'printers', 'form'));
    }

    /**
     * shippingLabels
     * @return mixed
     */
    public function shippingLabels()
    {
        $maxShippingLabels = $this->PrintLog->getSetting('MaxShippingLabels');

        $shippingLabel = new ShippingLabelsForm();

        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $template = $this->PrintLog->getGlabelsDetail(
            $controller,
            $action
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            if ($shippingLabel->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $action,
                    $data
                );

                $printerDetails = $this->PrintLog->getLabelPrinterById($data['printer']);

                $printResult = LabelFactory::create($this->request->getParam('action'))
                        ->format($this->request->getData())
                            ->print($printerDetails, $template->file_path);

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
                );
            } else {
                $this->Flash->error('no way');
            }
        }

        $sequence = $this->PrintLog->createSequenceList($maxShippingLabels);

        $totalLabels = $this->PrintLog->getSetting('shipping_label_total');

        $printers = $this->PrintLog->getLabelPrinters($this->request->getParam('controller'), $this->request->getParam('action'));

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
        $printers = $this->PrintLog->getLabelPrinters(
            $controller,
            $action
        );

        /**
          * @var GlabelsTemplate $template Glabels Configuration
          */
        $template = $this->PrintLog->getGlabelsDetail(
            $controller,
            $action
        );

        $form = new ShippingLabelsGenericForm();

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $data
                );

                $glabelsData = $data + $saveData;
                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById($glabelsData['printer']);

                $printResult = LabelFactory::create($this->request->getParam('action'))
                    ->format($glabelsData)
                        ->print($printerDetails, $template->file_path);

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
                );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('template', 'printers', 'form'));
    }

    /**
     * keepRefrigerated
     * @return mixed
     */
    public function keepRefrigerated()
    {
        $form = new KeepRefrigeratedForm();

        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            if ($form->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $data
                );

                $glabelsData = $data + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($this->request->getParam('action'))
                    ->format($glabelsData)
                        ->print($printerDetails, $template->file_path);

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
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

        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();

            if ($glabelsSample->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $data
                );

                $glabelsData = $data + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($this->request->getParam('action'))
                    ->format($glabelsData)->print(
                        $printerDetails,
                        $template->file_path
                    );

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
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
        $bigNumber = new BigNumberForm();
        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $printerId = $printers['default'];

        $printer = $printers['printers'][$printerId];

        $printTemplatesTable = TableRegistry::get('PrintTemplates');
        $printTemplate = $printTemplatesTable->find()
            ->where(
                [
                    'PrintTemplates.print_action' => 'bigNumber',
                    'PrintTemplates.active' => 1,
                ],
            )->first()->toArray();

        $exampleImage = $printTemplate['example_image'];

        $glabelsRoot = $this->PrintLog->getSetting('GLABELS_ROOT');

        if ($this->request->is(['POST', 'PUT'])) {
            $formData = $this->request->getData();

            $printerDetails = $this->PrintLog->getLabelPrinterById(
                $formData['printerId']
            );

            $saveData = $this->PrintLog->formatPrintLogData(
                $this->request->getParam('action'),
                $formData
            );

            $printResult = LabelFactory::create($this->request->getParam('action'))
                ->format($printTemplate, $formData)
                    ->print($printerDetails);

            $this->handlePrintResult(
                $printResult,
                $printerDetails,
                $printTemplate,
                $saveData
            );
        }

        $this->set(compact('printer', 'printerId', 'exampleImage', 'glabelsRoot', 'printTemplate'));
    }

    /**
     * customPrint
     * @return mixed
     */
    public function customPrint()
    {
        $conditions = [
            'conditions' => [
                "Settings.name LIKE 'custom_print_%'",
            ],
        ];
        $settings = TableRegistry::get('Settings');

        $customPrints = $settings->find('all', $conditions)->toArray();

        $forms = [];

        foreach ($customPrints as $key => $customPrint) {
            $formName = 'form-' . $customPrint['id'];

            $decodedComment = json_decode($customPrint['comment'], true);

            $customPrints[$key]['comment'] = $decodedComment;

            $copies = isset($decodedComment['copies']) && is_numeric($decodedComment['copies']) ? $decodedComment['copies'] : null;

            $forms[$formName] = (new CustomPrintForm())->setFormName($formName)->setCopies($copies);

            $customPrints[$key]['formName'] = $formName;
        }

        $action = $this->request->getParam('action');
        $controller = $this->request->getParam('controller');

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            $formName = $data['formName'];

            if ($forms[$formName]->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $action,
                    $data[$formName]
                );

                $glabelsData = $data[$formName] + $saveData;

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $data[$formName]['printer']
                );

                $printResult = LabelFactory::create($action)
                    ->format($glabelsData)
                        ->print(
                            $printerDetails,
                            WWW_ROOT . $data[$formName]['template']
                        );

                $printTemplate['name'] = 'Custom Print';

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $printTemplate,
                    $saveData
                );
            } else {
                $this->Flash->error('Invalid data!');
                $forms[$formName]->setData($this->request->getData());
                $forms[$formName]->setErrors($forms[$formName]->getErrors());
            }
        }

        $printers = $this->PrintLog->getLabelPrinters(
            $controller,
            $action
        );

        $this->set(compact('forms', 'printers', 'customPrints'));
    }

    /**
     * sampleLabels
     * @return mixed
     */
    public function sampleLabels()
    {
        $form = new SampleLabelForm();

        $maxShippingLabels = $this->PrintLog->getSetting('MaxShippingLabels');
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $template = $this->PrintLog->getGlabelsDetail(
            $controller,
            $action
        );

        $printers = $this->PrintLog->getLabelPrinters(
            $controller,
            $action
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
                    $action,
                    $data
                );
                $glabelsData = $data + $saveData;
                $printersTable = TableRegistry::get('Printers');
                $printerDetails = $printersTable->get($glabelsData['printer'])->toArray();

                $printResult = LabelFactory::create($this->request->getParam('action'))
                    ->format($glabelsData)
                        ->print($printerDetails, $template->file_path);

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
                );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('sequence', 'template', 'printers', 'form'));
    }

    public function ssccLabel($id = null)
    {
        $palletTable = TableRegistry::get('Pallets');

        if ($id === null) {
            return $this->redirect($this->referer());
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

            $bestBeforeBc = $this->PrintLog->formatYymmdd($pallet['bb_date']);

            $cabLabelData = [
                'printDate' => $pallet['print_date'],
                'companyName' => Configure::read('companyName'),
                'internalProductCode' => $pallet['items']['code'],
                'reference' => $pallet['pl_ref'],
                'sscc' => $pallet['sscc'],
                'description' => $pallet['items']['description'],
                'gtin14' => $pallet['gtin14'],
                'quantity' => $pallet['qty'],
                'bestBeforeHr' => $pallet['best_before'],
                'bestBeforeBc' => $bestBeforeBc,
                'batch' => $pallet['batch'],
                'numLabels' => $data['copies'],
                'ssccBarcode' => '[00]' . $pallet['sscc'],
                'itemBarcode' => '[02]' . $pallet['gtin14'] .
                    '[15]' . $bestBeforeBc . '[10]' . $pallet['batch'] .
                    '[37]' . $pallet['qty'],
            ];

            $saveData = $this->PrintLog->formatPrintLogData(
                $this->request->getParam('action'),
                $cabLabelData
            );

            $isPrintDebugMode = Configure::read('pallet_print_debug');

            $template = $this->PrintLog->getGlabelsDetail(
                'Pallets',
                'lookup'
            );

            $printResult = LabelFactory::create($this->request->getParam('action'))
                ->format($cabLabelData)
                ->print($printerDetails, $template->file_path);

            $this->handlePrintResult(
                $printResult,
                $printerDetails,
                $template->details,
                $saveData
            );
        }

        $printers = $palletTable->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers

        $labelCopies = $pallet['pallet_label_copies'] > 0
            ? $pallet['pallet_label_copies']
            : $this->PrintLog->getSetting('sscc_default_label_copies');

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

        $inputDefaultCopies = $this->PrintLog->getSetting('sscc_default_label_copies');

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