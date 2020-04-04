<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\CustomPrintForm;
use App\Form\ShippingLabelsForm;
use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\LabelFactory;
use App\Lib\PrintLabels\ResultTrait;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

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
        if (!$this->PrintLog->exists($printLogId)) {
            throw new NotFoundException(__('Invalid item'));
        }
        $options = ['conditions' => ['PrintLabel.' . $this->PrintLog->primaryKey => $printLogId]];

        $completed = $this->PrintLog->find('first', $options);

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
            $formData = $this->request->data;

            $printTemplate = $this->Item->find('first', [
                'conditions' => [
                    'Item.trade_unit' => $formData['barcode'],
                ],
                'contain' => [
                    'CartonLabel',
                ],
            ]);

            $printerDetails = $this->PrintLog->getLabelPrinterById($formData['printer_id']);

            $printResult = LabelFactory::create($this->request->getParam('action'))
                ->format($printTemplate['CartonLabel'], $formData)
                    ->print($printerDetails);

            if ($printResult['return_value'] == 0) {
                $logData = $this->PrintLog->formatPrintLogData(
                    $this->request->data['print_action'],
                    $this->request->data
                );
                $newEntity = $this->PrintLog->newEntity($logData);
                $this->PrintLog->save($newEntity);
            }

            $replyData = $this->request->data + $printResult;

            $this->set('data', $replyData);
            $this->set('_serialize', ['data']);
        }

        //$this->autoRender = false;
    }

    /**
     * cartonPrint
     *
     * @return void
     */
    public function cartonPrint()
    {
        $printers = $this->PrintLog->getLabelPrinters($this->request->getParam('controller'), $this->request->getParam('action'));

        $print_action = $this->request->getParam('action');

        $this->set(compact('print_action', 'printers'));
    }

    /**
     * crossdockLabels
     *
     * @return mixed
     */
    public function crossdockLabels()
    {
        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLog->set($this->request->data);

            if ($this->PrintLog->validates()) {
                $dataNoModel = $this->request->data['PrintLabel'];

                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

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
        $maxShippingLabels = $this->PrintLog->getSetting('MaxShippingLabels');

        $sequence = $this->PrintLog->createSequenceList($maxShippingLabels);

        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $companyName = Configure::read('companyName');

        $this->set(compact('template', 'companyName', 'sequence', 'printers'));
    }

    /**
     * shippingLabels
     * @return mixed
     */
    public function shippingLabels()
    {
        $maxShippingLabels = $this->PrintLog->getSetting('MaxShippingLabels');

        $shippingLabel = new ShippingLabelsForm();
        //$shippingLabel = null;

        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            if ($shippingLabel->validate($this->request->getData())) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $this->request->getData()
                );

                $this->log(print_r($saveData, true));
                $newEntity = $this->PrintLog->newEntity($saveData);

                $this->PrintLog->save($newEntity);

                $printerDetails = $this->PrintLog->getLabelPrinterById($this->request->getData()['printer']);

                $printResult = LabelFactory::create($this->request->getParam('action'))
                        ->format($this->request->getData())
                            ->print($printerDetails, $template->file_path);
                //$this->log(get_defined_vars());

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
        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        /**
          * @var GlabelsTemplate $template Glabels Configuration
          */
        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLog->set($this->request->data);

            $dataNoModel = $this->request->data['PrintLabel'];

            if ($this->PrintLog->validates()) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;
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

        $this->set(compact('template', 'printers'));
    }

    /**
     * keepRefrigerated
     * @return mixed
     */
    public function keepRefrigerated()
    {
        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLog->set($this->request->data);

            $dataNoModel = $this->request->data['PrintLabel'];

            if ($this->PrintLog->validates()) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

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

        $this->set(compact('template', 'printers'));
    }

    /**
     * glabelSampleLabels
     * @return mixed
     */
    public function glabelSampleLabels()
    {
        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLog->set($this->request->data);
            $dataNoModel = $this->request->data['PrintLabel'];

            if ($this->PrintLog->validates()) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

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

        $this->set(compact('template', 'printers'));
    }

    /**
     * bigNumber action method
     *
     * @return mixed
     */
    public function bigNumber()
    {
        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $printerId = $printers['default'];

        $printer = $printers['printers'][$printerId];

        $printTemplate = $this->PrintTemplate->find(
            'first',
            [
                'conditions' => [
                    'PrintTemplate.print_action' => 'bigNumber',
                    'PrintTemplate.active' => 1,
                ],
            ]
        );

        $glabelsRoot = $this->PrintLog->getSetting('GLABELS_ROOT');

        if ($this->request->is(['POST', 'PUT'])) {
            $formData = $this->request->data['PrintLabel'];

            $printerDetails = $this->PrintLog->getLabelPrinterById(
                $formData['printerId']
            );

            $saveData = $this->PrintLog->formatPrintLogData(
                $this->request->getParam('action'),
                $this->request->data['PrintLabel']
            );

            $printResult = LabelFactory::create($this->request->getParam('action'))
                ->format($printTemplate['PrintTemplate'], $formData)
                    ->print($printerDetails);

            $this->handlePrintResult(
                $printResult,
                $printerDetails,
                $printTemplate,
                $saveData
            );
        }

        $exampleImage = $printTemplate['PrintTemplate']['example_image'];

        $this->set(compact('printer', 'printerId', 'exampleImage', 'glabelsRoot'));
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

        foreach ($customPrints as $key => $customPrint) {
            $customPrints[$key]['decoded'] = json_decode($customPrint['comment'], true);
            $forms[$customPrint['id']] = new CustomPrintForm();
        }

        $action = $this->request->getParam('action');

        if ($this->request->is(['POST', 'PUT'])) {
            $data = $this->request->getData();
            $id = $data['id'];

            if ($forms[$id]->validate($data)) {
                $saveData = $this->PrintLog->formatPrintLogData(
                    $action,
                    $data
                );

                $newEntity = $this->PrintLog->newEntity($saveData);
                $this->PrintLog->save($newEntity);

                $glabelsData = $data + $saveData;

                $printerDetails = $this->PrintLog->getLabelPrinterById(
                    $glabelsData['printer']
                );
                $this->log(print_r([$printerDetails, $action, $data], true));
                $printResult = LabelFactory::create($action)
                    ->format($data)
                        ->print(
                            $printerDetails,
                            WWW_ROOT . $data['template']
                        );

                $printTemplate['name'] = 'Custom Print';

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $printTemplate,
                    $saveData
                );
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $printers = $this->PrintLog->getLabelPrinters(
            $this->request->getParam('controller'),
            $action
        );

        $this->set(compact('customPrints', 'printers', 'forms'));
    }

    /**
     * sampleLabels
     * @return mixed
     */
    public function sampleLabels()
    {
        $maxShippingLabels = $this->PrintLog->getSetting('MaxShippingLabels');

        $template = $this->PrintLog->getGlabelsDetail(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        $printers = $this->PrintLog->getLabelPrinters($this->request->getParam('controller'), $this->request->getParam('action'));

        $sequence = $this->PrintLog->createSequenceList(
            $maxShippingLabels,
            1,
            [
                50, 60, 80, 100, 200,
            ]
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLog->set($this->request->data);

            if ($this->PrintLog->validates()) {
                $dataNoModel = $this->request->data['PrintLabel'];
                $saveData = $this->PrintLog->formatPrintLogData(
                    $this->request->getParam('action'),
                    $dataNoModel
                );
                $glabelsData = $dataNoModel + $saveData;

                $printerDetails = $this->Printer->find(
                    'first',
                    [
                        'conditions' => [
                            'id' => $glabelsData['printer'],
                        ],
                    ]
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

        $this->set(compact('sequence', 'template', 'printers'));
    }

    public function ssccLabel($id = null)
    {
        $pallet = TableRegistry::get('Pallet');
        if ($id === null) {
            return $this->redirect([
                'action' => 'labelChooser',
            ]);
        }
        if (!$pallet->exists($id)) {
            throw new NotFoundException(__('Invalid Pallet'));
        }

        $options = [
            'contain' => [
                'Items' => [
                    'ProductTypes',
                    'PrintTemplates',
                ],
            ],
        ];

        $palletRecord = $pallet->get($id, $options);

        $pallet->getValidator()->add('printer_id', 'required', [
            'rule' => 'notBlank',
            'message' => 'Please select a printer',
        ]);

        if ($this->request->is(['post', 'put'])) {
            $pallet_ref = $palletRecord['pl_ref'];

            $replaceTokens = json_decode($palletRecord['Item']['PrintTemplate']['replace_tokens']);

            if (!isset($palletRecord['Item']['PrintTemplate']) || empty($palletRecord['Item']['PrintTemplate'])) {
                throw new MissingConfigurationException(__('Please configure a print template for item %s', $pallet['Pallet']['item']));
            }

            // get the printer queue name
            $printerId = $this->request->data['Pallet']['printer_id'];

            $printerDetails = $pallet->getLabelPrinterById($printerId);

            $bestBeforeBc = $this->PrintLog->formatYymmdd($palletRecord['Pallet']['bb_date']);

            $cabLabelData = [
                'printDate' => $palletRecord['Pallet']['print_date'],
                'companyName' => Configure::read('companyName'),
                'internalProductCode' => $palletRecord['Item']['code'],
                'reference' => $palletRecord['Pallet']['pl_ref'],
                'sscc' => $palletRecord['Pallet']['sscc'],
                'description' => $palletRecord['Item']['description'],
                'gtin14' => $palletRecord['Pallet']['gtin14'],
                'quantity' => $palletRecord['Pallet']['qty'],
                'bestBeforeHr' => $palletRecord['Pallet']['best_before'],
                'bestBeforeBc' => $bestBeforeBc,
                'batch' => $palletRecord['Pallet']['batch'],
                'numLabels' => $this->request->data['Pallet']['copies'],
                'ssccBarcode' => '[00]' . $palletRecord['Pallet']['sscc'],
                'itemBarcode' => '[02]' . $palletRecord['Pallet']['gtin14'] .
                    '[15]' . $bestBeforeBc . '[10]' . $palletRecord['Pallet']['batch'] .
                    '[37]' . $palletRecord['Pallet']['qty'],
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

        $printers = $pallet->getLabelPrinters(
            $this->request->getParam('controller'),
            $this->request->getParam('action')
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers
        unset($palletRecord['Pallet']['printer_id']);

        $labelCopies = $palletRecord['Item']['pallet_label_copies'] > 0
            ? $palletRecord['Item']['pallet_label_copies']
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

        $this->request->data = $palletRecord;

        $refer = $this->referer();

        $inputDefaultCopies = $this->PrintLog->getSetting('sscc_default_label_copies');

        $this->set(
            compact(
                'labelCopiesList',
                'palletRecord',
                'printers',
                'refer',
                'inputDefaultCopies'
            )
        );
    }
}