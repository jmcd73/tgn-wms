<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('PrintJob', 'Lib/Print');
App::uses('GlabelsException', 'Lib/Exception');
App::import('Lib/Print/Label', 'CabLabel');
App::uses('LabelFactory', 'Lib/Print');
App::uses('LabelResult', 'Lib/Print');
App::uses('ResultTrait', 'Lib/Print');

/**
 *
 * Print labels controller gathers print functions which have no models
 * and utility functions
 * @property PrintLabel $PrintLabel PrintLabel Model
 * @property PrintTemplate $PrintTemplate Print
 * @property Printer $Printer Model
 * @property Item $Item Model
 */
class PrintLabelsController extends AppController
{
    use ResultTrait;

    /**
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * Models that this Controller Uses
     * @var array
     */
    public $uses = ['PrintLabel', 'PrintTemplate', 'Printer', 'Item'];

    /**
     * @param int $printLogId Print ID
     * @return void
     */
    public function completed($printLogId = null)
    {
        if (!$this->PrintLabel->exists($printLogId)) {
            throw new NotFoundException(__('Invalid item'));
        }
        $options = ['conditions' => ['PrintLabel.' . $this->PrintLabel->primaryKey => $printLogId]];

        $completed = $this->PrintLabel->find('first', $options);

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

            $printerDetails = $this->PrintLabel->getLabelPrinterById($formData['printer_id']);

            $printResult = LabelFactory::create($this->request->action)
                ->format($printTemplate['CartonLabel'], $formData)
                    ->print($printerDetails);

            if ($printResult['return_value'] == 0) {
                $logData = $this->PrintLabel->formatPrintLogData(
                    $this->request->data['print_action'],
                    $this->request->data
                );
                $this->PrintLabel->save($logData);
            }

            $replyData = $this->request->data + $printResult;

            $this->set('data', $replyData);
            $this->set('_serialize', ['data']);
        }

        //$this->autoRender = false;
    }

    /**
     * printLog method
     * @return void
     */
    public function printLog()
    {
        $this->paginate = [
            'order' => [
                'PrintLabel.id' => 'DESC',
            ],
        ];

        $this->set('printItems', $this->Paginator->paginate());
    }

    /**
     * cartonPrint
     *
     * @return void
     */
    public function cartonPrint()
    {
        $printers = $this->PrintLabel->getLabelPrinters($this->request->controller, $this->request->action);

        $print_action = $this->request->action;

        $this->set(compact('print_action', 'printers'));
    }

    /**
     * crossdockLabels
     *
     * @return mixed
     */
    public function crossdockLabels()
    {
        $template = $this->PrintLabel->getGlabelsDetail(
            $this->request->controller,
            $this->request->action
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLabel->set($this->request->data);

            if ($this->PrintLabel->validates()) {
                $dataNoModel = $this->request->data['PrintLabel'];

                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLabel->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($this->request->action)
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
        $maxShippingLabels = $this->getSetting('MaxShippingLabels');

        $sequence = $this->PrintLabel->createSequenceList($maxShippingLabels);

        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
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
        $maxShippingLabels = $this->getSetting('MaxShippingLabels');

        $template = $this->PrintLabel->getGlabelsDetail(
            $this->request->controller,
            $this->request->action
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLabel->set($this->request->data);

            $dataNoModel = $this->request->data['PrintLabel'];

            $saveData = $this->PrintLabel->formatPrintLogData(
                $this->request->action,
                $dataNoModel
            );

            if ($this->PrintLabel->validates()) {
                // $results = $HttpSocket->post($url, $this->request->data);
                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;
                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLabel->getLabelPrinterById($glabelsData['printer']);

                $printResult = LabelFactory::create($this->request->action)
                    ->format($glabelsData)
                        ->print($printerDetails, $template->file_path);
                //$this->log(get_defined_vars());

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $template->details,
                    $saveData
                );
            } else {
                $this->Flash->error('Not valid data');
            }
        }

        $sequence = $this->PrintLabel->createSequenceList($maxShippingLabels);

        $totalLabels = $this->getSetting('shipping_label_total');

        $printers = $this->PrintLabel->getLabelPrinters($this->request->controller, $this->request->action);

        $this->set(compact('totalLabels', 'template', 'printers', 'sequence'));
    }

    /**
     * shippingLabelsGeneric
     * @return mixed
     *
     */
    public function shippingLabelsGeneric()
    {
        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        /**
          * @var GlabelsTemplate $template Glabels Configuration
          */
        $template = $this->PrintLabel->getGlabelsDetail(
            $this->request->controller,
            $this->request->action
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLabel->set($this->request->data);

            $dataNoModel = $this->request->data['PrintLabel'];

            if ($this->PrintLabel->validates()) {
                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;
                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLabel->getLabelPrinterById($glabelsData['printer']);

                $printResult = LabelFactory::create($this->request->action)
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
        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        $template = $this->PrintLabel->getGlabelsDetail(
            $this->request->controller,
            $this->request->action
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLabel->set($this->request->data);

            $dataNoModel = $this->request->data['PrintLabel'];

            if ($this->PrintLabel->validates()) {
                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLabel->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($this->request->action)
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
        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        $template = $this->PrintLabel->getGlabelsDetail(
            $this->request->controller,
            $this->request->action
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLabel->set($this->request->data);
            $dataNoModel = $this->request->data['PrintLabel'];

            if ($this->PrintLabel->validates()) {
                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

                unset($glabelsData['print_data']);

                $printerDetails = $this->PrintLabel->getLabelPrinterById(
                    $glabelsData['printer']
                );

                $printResult = LabelFactory::create($this->request->action)
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
        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
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

        $glabelsRoot = $this->getSetting('GLABELS_ROOT');

        if ($this->request->is(['POST', 'PUT'])) {
            $formData = $this->request->data['PrintLabel'];

            $printerDetails = $this->PrintLabel->getLabelPrinterById(
                $formData['printerId']
            );

            $saveData = $this->PrintLabel->formatPrintLogData(
                $this->request->action,
                $this->request->data['PrintLabel']
            );

            $printResult = LabelFactory::create($this->request->action)
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
     * labelChooser method action
     *
     * @return mixed
     */
    public function labelChooser()
    {
        $glabelsRoot = $this->getSetting('GLABELS_ROOT');

        $printTemplatesThreaded = $this->PrintTemplate->find(
            'threaded',
            [
                'order' => [
                    'PrintTemplate.lft' => 'ASC',
                ],
                'contain' => true,
            ]
        );

        $this->set(compact('glabelsRoot', 'printTemplatesThreaded'));
    }

    /**
     * customPrint
     * @return mixed
     */
    public function customPrint()
    {
        if ($this->request->is(['POST', 'PUT'])) {
            $arrayKey = array_keys($this->request->data)[0];

            $this->request->data['PrintLabel'] = $this->request->data[$arrayKey];

            unset($this->request->data[$arrayKey]);

            $this->PrintLabel->set($this->request->data);

            if ($this->PrintLabel->validates()) {
                $dataNoModel = $this->request->data['PrintLabel'];

                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
                    $dataNoModel
                );

                $glabelsData = $dataNoModel + $saveData;

                $printerDetails = $this->PrintLabel->getLabelPrinterById(
                    $glabelsData['printer']
                );

                unset($glabelsData['print_data']);

                $printResult = LabelFactory::create($this->request->action)
                    ->format($glabelsData)
                        ->print(
                            $printerDetails,
                            WWW_ROOT . $dataNoModel['template']
                        );

                $printTemplate['PrintTemplate']['name'] = 'Custom Print';

                $this->handlePrintResult(
                    $printResult,
                    $printerDetails,
                    $printTemplate,
                    $saveData
                );
            } else {
                $this->set('formName', $arrayKey);
                $this->Flash->error('Invalid data');
            }
        }

        $conditions = [
            'conditions' => [
                "Setting.name LIKE 'custom_print_%'",
            ],
        ];

        $customPrints = $this->Setting->find('all', $conditions);

        foreach ($customPrints as $key => $customPrint) {
            $customPrints[$key]['Setting']['decoded'] = json_decode($customPrint['Setting']['comment'], true);
        }

        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        $this->set(compact('customPrints', 'printers'));
    }

    /**
     * sampleLabels
     * @return mixed
     */
    public function sampleLabels()
    {
        $maxShippingLabels = $this->getSetting('MaxShippingLabels');

        $template = $this->PrintLabel->getGlabelsDetail(
            $this->request->controller,
            $this->request->action
        );

        $printers = $this->PrintLabel->getLabelPrinters($this->request->controller, $this->request->action);

        $sequence = $this->PrintLabel->createSequenceList(
            $maxShippingLabels,
            1,
            [
                50, 60, 80, 100, 200,
            ]
        );

        if ($this->request->is(['POST', 'PUT'])) {
            $this->PrintLabel->set($this->request->data);

            if ($this->PrintLabel->validates()) {
                $dataNoModel = $this->request->data['PrintLabel'];
                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
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

                $printResult = LabelFactory::create($this->request->action)
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

    /**
     * dayOfYear shows day_of_year.ctp but doesn't do much else
     * @return void
     */
    public function dayOfYear()
    {
    }

    public function ssccLabel($id = null)
    {
        $pallet = ClassRegistry::init('Pallet');
        if ($id === null) {
            return $this->redirect([
                'action' => 'labelChooser',
            ]);
        }
        if (!$pallet->exists($id)) {
            throw new NotFoundException(__('Invalid Pallet'));
        }

        $options = [
            'conditions' => [
                'Pallet.' . $pallet->primaryKey => $id,
            ],
            'contain' => [
                'Item' => [
                    'ProductType',
                    'PrintTemplate',
                ],
            ],
        ];

        $palletRecord = $pallet->find('first', $options);

        $pallet->validator()->add('printer_id', 'required', [
            'rule' => 'notBlank',
            'message' => 'Please select a printer',
        ]);

        if ($this->request->is(['post', 'put'])) {
            $pallet_ref = $palletRecord['Pallet']['pl_ref'];

            $replaceTokens = json_decode($palletRecord['Item']['PrintTemplate']['replace_tokens']);

            if (!isset($palletRecord['Item']['PrintTemplate']) || empty($palletRecord['Item']['PrintTemplate'])) {
                throw new MissingConfigurationException(__('Please configure a print template for item %s', $pallet['Pallet']['item']));
            }

            // get the printer queue name
            $printerId = $this->request->data['Pallet']['printer_id'];

            $printerDetails = $pallet->getLabelPrinterById($printerId);

            $bestBeforeBc = $this->formatYymmdd($palletRecord['Pallet']['bb_date']);

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

            $saveData = $this->PrintLabel->formatPrintLogData(
                $this->request->action,
                $cabLabelData
            );

            $isPrintDebugMode = Configure::read('pallet_print_debug');

            $template = $this->PrintLabel->getGlabelsDetail(
                'Pallets',
                'lookup'
            );

            $printResult = LabelFactory::create($this->request->action)
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
            $this->request->controller,
            $this->request->action
        );

        // unset this as the default printer is configured
        // for the reprint Controller/Action in Printers
        unset($palletRecord['Pallet']['printer_id']);

        $labelCopies = $palletRecord['Item']['pallet_label_copies'] > 0
            ? $palletRecord['Item']['pallet_label_copies']
            : $this->getSetting('sscc_default_label_copies');

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

        $inputDefaultCopies = $this->getSetting('sscc_default_label_copies');

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