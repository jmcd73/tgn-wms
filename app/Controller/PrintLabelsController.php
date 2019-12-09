<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('gLabelsException', 'Lib');
App::import('Vendor', 'CabLabel');

/**
 *
 * Print labels controller gathers print functions which have no models
 * and utility functions
 */
class PrintLabelsController extends AppController
{
    /**
     * @var array
     */
    public $components = ['Paginator', 'PrintLogic'];
    /**
     * @var mixed
     */
    public $showInSelectedControllerActionList = true;

    /**
     * @param int $id Print ID
     * @return void
     */
    public function completed($id = null)
    {
        if (!$this->PrintLabel->exists($id)) {
            throw new NotFoundException(__('Invalid item'));
        }
        $options = ['conditions' => ['PrintLabel.' . $this->PrintLabel->primaryKey => $id]];
        $this->set('completed', $this->PrintLabel->find('first', $options));
    }

    /**
     * Ajax endpoint for cartonPrint action
     *
     * @return void
     */
    public function printCartonLabels()
    {
        if ($this->request->is(['POST', 'PUT'])) {
            $labelData = $this->request->data;
            $this->loadModel('Item');

            $templateId = $this->Item->find('first', [
                'conditions' => [
                    'Item.trade_unit' => $labelData['barcode']
                ],
                'contain' => [
                    'CartonLabel'
                ]
            ]);

            // each item has a carton template
            $template = $templateId['CartonLabel']['text_template'];

            $replaceTokens = json_decode(
                $this->getSetting('cabCartonTemplateTokens', true)
            );

            $templateValues = [
                'description' => $labelData['description'],
                'gtin14' => $labelData['barcode'],
                'numLabels' => $labelData['count']
            ];

            $cabLabel = new CabLabel(
                $templateValues,
                $template,
                $replaceTokens
            );

            $printJob = $this->PrintLogic->setJobId($labelData['print_action'], $reprint = false);

            $printerDetails = $this->PrintLabel->getLabelPrinterById(
                $labelData['printer_id']
            );

            $printSettings = $this->PrintLogic->getPrintSettings(
                $printerDetails['Printer']['queue_name'],
                $printJob,
                $printerDetails['Printer']['options'],
                'carton'
            );

            $returnValue = $this->PrintLogic->sendPrint(
                $cabLabel->printContent,
                $printSettings
            );

            $logData = '';

            if ($returnValue['return_value'] == 0) {
                $logData = $this->PrintLabel->formatPrintLogData(
                    $this->request->data['print_action'],
                    $this->request->data
                );
                $this->PrintLabel->save($logData);
            }

            $replyData = $this->request->data + $returnValue;

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
                'PrintLabel.id' => 'DESC'
            ]
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

        $this->set('print_action', $this->request->action);
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
    }

    /**
     * crossdockLabels
     *
     * @return mixed
     */
    public function crossdockLabels()
    {
        $this->loadModel('PrintTemplate');

        list(
            $glabelsTemplateFullPath,
            $glabelsExampleImage
        ) = $this->PrintLabel->getGlabelsDetail(
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

                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;

                unset($glabelsData['print_data']);

                $this->PrintLogic->setGlabelsTemplate(
                    $glabelsTemplateFullPath
                );

                $this->PrintLogic->formatPrintLine(
                    $this->request->action,
                    $glabelsData
                );

                $result = $this->PrintLogic->glabelsBatchPrint();

                if ($result['return_value'] == 0) {
                    $printer = $this->PrintLabel->getLabelPrinterById(
                        $glabelsData['printer']
                    );
                    $result = $this->PrintLogic->sendPdfToLpr(
                        $printer['Printer']['queue_name']
                    );
                }

                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to printer";
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred: ";
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }

                return $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
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

        $this->set(compact('glabelsExampleImage', 'companyName'));
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
        $this->set('sequence', $sequence);
    }

    /**
     * shippingLabels
     * @return mixed
     */
    public function shippingLabels()
    {
        $this->loadModel("PrintTemplate");
        $maxShippingLabels = $this->getSetting('MaxShippingLabels');

        list(
            $glabelsTemplateFullPath,
            $glabelsExampleImage
        ) = $this->PrintLabel->getGlabelsDetail(
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

                $this->PrintLogic->setGlabelsTemplate(
                    $glabelsTemplateFullPath
                );
                $this->PrintLogic->formatPrintLine(
                    $this->request->action,
                    $glabelsData
                );

                $result = $this->PrintLogic->glabelsBatchPrint();

                if ($result['return_value'] == 0) {
                    $printer = $this->PrintLabel->getLabelPrinterById($glabelsData['printer']);
                    $result = $this->PrintLogic->sendPdfToLpr(
                        $printer['Printer']['queue_name']
                    );
                }
                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to printer";
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred: ";
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }

                return $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->Flash->error('Not valid data');
            }
        }

        $sequence = $this->PrintLabel->createSequenceList($maxShippingLabels);

        $totalLabels = $this->getSetting('shipping_label_total');

        $printers = $this->PrintLabel->getLabelPrinters($this->request->controller, $this->request->action);

        $this->set('printers', $printers['printers']);
        $this->set(compact('totalLabels', 'glabelsExampleImage'));

        $this->set('default', $printers['default']);
        $this->set(compact('sequence'));
    }

    /**
     * shippingLabelsGeneric
     * @return mixed
     */
    public function shippingLabelsGeneric()
    {
        $printers = $this->PrintLabel->getLabelPrinters($this->request->controller, $this->request->action);

        $this->loadModel('PrintTemplate');

        list(
            $glabelsTemplateFullPath,
            $glabelsExampleImage
        ) = $this->PrintLabel->getGlabelsDetail(
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

                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;
                unset($glabelsData['print_data']);

                $this->PrintLogic->setGlabelsTemplate(
                    $glabelsTemplateFullPath
                );
                $this->PrintLogic->formatPrintLine($this->request->action, $glabelsData);

                $result = $this->PrintLogic->glabelsBatchPrint();
                $printer = $this->PrintLabel->getLabelPrinterById(
                    $glabelsData['printer']
                );
                if ($result['return_value'] == 0) {
                    $result = $this->PrintLogic->sendPdfToLpr(
                        $printer['Printer']['queue_name']
                    );
                }
                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to printer";
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred: ";
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }

                return $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('glabelsExampleImage'));
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
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

        list(
            $glabelsTemplateFullPath,
            $glabelsExampleImage
        ) = $this->PrintLabel->getGlabelsDetail(
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

                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;
                unset($glabelsData['print_data']);

                $this->PrintLogic->setGlabelsTemplate(
                    $glabelsTemplateFullPath
                );

                // needed to set file name which is naff
                $this->PrintLogic->formatPrintLine(
                    $this->request->action,
                    $glabelsData
                );

                $copies = $dataNoModel['copies'];

                $result = $this->PrintLogic->glabelsBatchPrint(false);

                if ($result['return_value'] !== 0) {
                    $message = "glabelsBatchPrint failure";
                    $this->Flash->success($message);
                }

                if ($result['return_value'] == 0) {
                    $printer = $this->PrintLabel->getLabelPrinterById(
                        $glabelsData['printer']
                    );

                    $printerName = $printer['Printer']['queue_name'];

                    $result = $this->PrintLogic->sendPdfToLpr(
                        $printerName
                    );
                }
                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to printer";
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred: " . 'sendPdfToLpr';
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }

                $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->Flash->error('Invalid data');
            }
        }
        $this->set(compact('glabelsExampleImage'));
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
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

        list(
            $glabelsTemplateFullPath,
            $glabelsExampleImage
        ) = $this->PrintLabel->getGlabelsDetail(
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

                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;

                unset($glabelsData['print_data']);

                $this->PrintLogic->setGlabelsTemplate(
                    $glabelsTemplateFullPath
                );

                # needed to set file name which is naff
                $this->PrintLogic->formatPrintLine(
                    $this->request->action,
                    $glabelsData
                );

                $copies = $dataNoModel['copies'];

                $result = $this->PrintLogic->glabelsBatchPrint(false);
                $printer = $this->PrintLabel->getLabelPrinterById(
                    $glabelsData['printer']
                );
                if ($result['return_value'] == 0) {
                    $result = $this->PrintLogic->sendPdfToLpr($printer['Printer']['queue_name'], $copies);
                }
                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to printer";
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred: ";
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }

                return $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->Flash->error('Invalid data');
            }
        }
        $this->set(compact('glabelsExampleImage'));
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
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

        $printer = $printers['printers'][$printers['default']];

        $companyName = $this->PrintLabel->getSetting('companyName');
        $this->loadModel('PrintTemplate');
        $printTemplate = $this->PrintTemplate->find(
            'first',
            [
                'conditions' => [
                    'PrintTemplate.print_action' => 'bigNumber',
                    'PrintTemplate.active' => 1
                ]
            ]
        );
        $glabelsRoot = $this->getSetting('GLABELS_ROOT');

        if ($this->request->is(['POST', 'PUT'])) {
            $printTemplateContents = $printTemplate['PrintTemplate']['text_template'];

            if (empty($printTemplateContents)) {
                throw new NotFoundException("Cannot find print template for bigNumber");
            }

            $formData = $this->request->data['PrintLabel'];

            $number = $formData['number'];
            $quantity = $formData['quantity'];
            $offset = '0160';

            if (strlen($number) === 1) {
                $offset = '0310';
            }

            $templateTokens = json_decode($this->getSetting('bigNumberTemplateTokens', true));

            $labelValues = [];
            foreach ($templateTokens as $ttKey => $ttValue) {
                $labelValues[$ttValue] = $$ttValue;
            }

            $cabLabel = new CabLabel(
                $labelValues,
                $printTemplateContents,
                $templateTokens
            );

            $formData = $formData + [
                'print_action' => $this->request->action
            ];

            $printJob = $this->PrintLogic->setJobId($formData['print_action'], $reprint = false);

            $printerDetails = $this->PrintLabel->getLabelPrinterById(
                $printers['default']
            );

            $printSettings = $this->PrintLogic->getPrintSettings(
                $printerDetails['Printer']['queue_name'],
                $printJob,
                $printerDetails['Printer']['options'],
                $formData['print_action']
            );

            $returnValue = $this->PrintLogic->sendPrint($cabLabel->printContent, $printSettings);

            $logData = '';

            if ($returnValue['return_value'] == 0) {
                $dataNoModel = $this->request->data['PrintLabel'];
                $saveData = $this->PrintLabel->formatPrintLogData(
                    $this->request->action,
                    $dataNoModel
                );
                $this->PrintLabel->save($saveData);
                $this->Flash->success("Sent big numbers to printer " . $formData['printer']);

                return $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->Flash->error("Failed sending big numbers to printer " .
                    $formData['printer'] . ' - ' . $returnValue['stderr']);
            }
        }

        $exampleImage = $printTemplate['PrintTemplate']['example_image'];
        $this->set(compact('printer', 'exampleImage', 'glabelsRoot'));
    }

    /**
     * labelChooser method action
     *
     * @return mixed
     */
    public function labelChooser()
    {
        $glabelsRoot = $this->getSetting('GLABELS_ROOT');

        $this->loadModel("PrintTemplate");

        $printTemplatesThreaded = $this->PrintTemplate->find(
            'threaded',
            [
                'order' => [
                    'PrintTemplate.lft' => "ASC"
                ],
                'contain' => true

            ]
        );

        $this->set(
            compact(
                'glabelsRoot',
                'printTemplatesThreaded'
            )
        );
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
                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;

                unset($glabelsData['print_data']);

                $this->PrintLogic->setGlabelsTemplate(
                    WWW_ROOT . $dataNoModel['template']
                );

                $this->PrintLogic->formatPrintLine(
                    $this->request->action,
                    $glabelsData
                );

                $result = $this->PrintLogic->glabelsBatchPrint();

                if ($result['return_value'] == 0) {
                    $printer = $this->PrintLabel->getLabelPrinterById($glabelsData['printer']);
                    $result = $this->PrintLogic->sendPdfToLpr(
                        $printer['Printer']['queue_name']
                    );
                }

                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to printer";
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred: ";
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }

                $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->set('formName', $arrayKey);
                $this->Flash->error('Invalid data');
            }
        }

        $conditions = ['conditions' =>
            [
                "Setting.name LIKE 'custom_print_%'"
            ]
        ];

        $custom_prints = $this->Setting->find('all', $conditions);

        foreach ($custom_prints as $key => $customPrint) {
            $custom_prints[$key]['Setting']['decoded'] = json_decode($customPrint['Setting']['comment'], true);
        }

        $printers = $this->PrintLabel->getLabelPrinters(
            $this->request->controller,
            $this->request->action
        );

        $this->set(compact('custom_prints'));
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
    }

    /**
     * sampleLabels
     * @return mixed
     */
    public function sampleLabels()
    {
        $maxShippingLabels = $this->getSetting('MaxShippingLabels');

        list($glabelsTemplateFullPath, $glabelsExampleImage)
        = $this->PrintLabel->getGlabelsDetail($this->request->action);

        $printers = $this->PrintLabel->getLabelPrinters($this->request->controller, $this->request->action);

        $sequence = $this->PrintLabel->createSequenceList(
            $maxShippingLabels,
            1,
            [
                50, 60, 80, 100, 200
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

                $this->PrintLabel->save($saveData);

                $glabelsData = $dataNoModel + $saveData;

                $this->loadModel('Printer');

                $printer = $this->Printer->find(
                    'first',
                    [
                        'conditions' => [
                            'Printer.id' => $glabelsData['printer']
                        ]
                    ]
                );

                $printerFriendlyName = $printer['Printer']['name'];

                $glabelsData['printer'] = $printer['Printer']['queue_name'];

                unset($glabelsData['print_data']);

                $this->PrintLogic->setGlabelsTemplate(
                    $glabelsTemplateFullPath
                );

                $this->PrintLogic->formatPrintLine($this->request->action, $glabelsData);

                $result = $this->PrintLogic->glabelsBatchPrint();

                if ($result['return_value'] == 0) {
                    $result = $this->PrintLogic->sendPdfToLpr(
                        $printer['Printer']['queue_name']
                    );
                }
                if ($result['return_value'] == 0) {
                    $message = "Successfully sent label to <strong>" . $printerFriendlyName . '</strong>';
                    $this->Flash->success($message);
                } else {
                    $message = "An error has occurred sending data to <strong>" . $printerFriendlyName . '</strong> : ';
                    $message .= $result['stderr'];
                    $this->Flash->error($message);
                }
                $this->redirect(['action' => 'completed', $this->PrintLabel->id]);
            } else {
                $this->Flash->error('Invalid data');
            }
        }

        $this->set(compact('sequence', 'glabelsExampleImage'));
        $this->set('printers', $printers['printers']);
        $this->set('default', $printers['default']);
    }

    /**
     * dayOfYear shows day_of_year.ctp but doesn't do much else
     * @return void
     */
    public function dayOfYear()
    {
    }
}