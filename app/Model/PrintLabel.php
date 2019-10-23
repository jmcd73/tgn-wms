<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class PrintLabel extends AppModel
{
    /**
     * @var string
     */
    public $useTable = 'print_log';

    /**
     * @param array $options
     */
    public function beforeValidate($options = [])
    {
        $maxLabels = Configure::read('labelMaxCopies');
        $lessThanOrEqual = $this->validator()->getField('copies')
            ->getRule('lessThanOrEqual');
        $lessThanOrEqual->rule = ['comparison', 'less or equal', $maxLabels];
        $lessThanOrEqual->message = 'Must be less than or equal to ' . $maxLabels;
    }

    /**
     * getGlabelsDetail
     */
    public function getGlabelsDetail($action)
    {

        $printTemplateModel = ClassRegistry::init('PrintTemplate');

        $glabelsRoot = $this->getSetting("GLABELS_ROOT");

        $glabelsTemplate = $printTemplateModel->find(
            'first', [
                'conditions' => [
                    'PrintTemplate.print_action' => $action,
                    'PrintTemplate.active' => 1
                ]
            ]
        );

        $glabelsTemplateFullPath = WWW_ROOT . $glabelsRoot . DS .
            $glabelsTemplate['PrintTemplate']['file_template'];

        $glabelsExampleImage = DS . $glabelsRoot . DS .
            $glabelsTemplate['PrintTemplate']['example_image'];

        return [$glabelsTemplateFullPath, $glabelsExampleImage];

    }
    /**
     * create sequence list as needed in a list e.g.
     * [ "1" => "1", "2" => "2" ]
     * @param int $max high value
     * @param int $start low value
     * @param array $extraOptions values to add after high
     * @return array
     */
    public function createSequenceList($max, $start = 1, $extraOptions = [])
    {
        $sequence = [];
        for ($i = 1; $i <= $max; $i++) {
            $sequence[$i] = $i;
        }

        foreach ($extraOptions as $option) {
            if ($option > $max) {
                $sequence[$option] = $option;
            }
        }

        return $sequence;

    }
    /**
     * form print log data for print_log table
     * @param string $print_action result of $this->request->action or calling action
     * @param array $print_data print data to encode as json
     * @return array
     */
    public function formatPrintLogData($print_action, $print_data)
    {
        if (empty($print_action) || empty($print_data)) {
            throw new NotFoundException('Failed to specify a print_action and print_data');
        }
        return [
            'print_data' => json_encode($print_data),
            'print_action' => $print_action
        ];
    }

    /**
     * @var array
     */
    public $validate = [
        'printer' => [
            'notBlank' => [
                'rule' => 'notBlank',
                'message' => "Please specify a printer"
            ]
        ],
        'copies' => [
            'naturalNumber' => [
                'rule' => ['naturalNumber', false],
                'message' => 'Please enter a valid number'
            ],
            'lessThanOrEqual' => [
                'rule' => ['comparison', 'less or equal', 400],
                'message' => 'Must be less than or equal to 400'
            ]],
        'state' => [
            'checkStateNotBlank' => [
                'rule' => 'notBlank',
                'message' => 'Please enter a state or destination'
            ]
        ],
        'sequence-start' => [
            'checkStartEndCorrect' => [
                'rule' => 'checkStartEndCorrect',
                'message' => "Start should be less than or equal to End!"
            ]
        ],
        'sequence-end' => [
            'checkStartEndCorrect' => [
                'rule' => 'checkStartEndCorrect',
                'message' => "Start should be less than or equal to End!"
            ]
        ]
    ];

    /**
     * @param $value
     * @return mixed
     */
    public function checkStartEndCorrect($value)
    {
        $start = $this->data[$this->name]['sequence-start'];
        $end = $this->data[$this->name]['sequence-end'];

        return $start <= $end;
    }

    /**
     * @param $value
     */
    public function myNotEmpty($value)
    {
        return !empty($value) || is_numeric($value);
    }

    /**
     * @param $check
     * @return mixed
     */
    public function stateOrCustomDestination($check)
    {

        return $this->myNotEmpty(
            $this->data[$this->name]['customDestination']
        ) ||
        $this->myNotEmpty(
            $this->data[$this->name]['state']
        );
    }

}
