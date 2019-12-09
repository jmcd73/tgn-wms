<?php
App::uses('AppModel', 'Model');
App::uses('CakeText', 'Utility');

/**
 * Printer Model
 *
 */
class Printer extends AppModel
{
    /**
     * getCupsURL
     * Return the Docker specific port for CUPS
     * or the default if there is no CUPS_PORT variable
     * @param Request $request Cakephp request
     * @return string
     * phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
     */
    public function getCupsURL($request)
    {
        $getEnv = getenv("CUPS_PORT");

        // if its not in a docker container then
        // return the default port
        $cupsPort = $getEnv === false ? 631 : $getEnv;

        // $request->is('ssl') ? 'https' : 'http';
        // scheme must be https to add printers
        $scheme = 'https';
        $host = $request->host();
        $hostPart = explode(":", $host)[0];

        return sprintf('%s://%s:%s', $scheme, $hostPart, $cupsPort);
    }

    // phpcs:enable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps

    /**
     * Get Local Printer List
     * @return mixed
     */
    public function getLocalPrinterList()
    {
        ob_start();
        passthru("lpstat -a");
        $var = ob_get_contents();
        ob_end_clean(); //Use this instead of ob_flush()

        $printerLine = array_filter(explode("\n", $var));

        $printerList = [];

        foreach ($printerLine as $printer) {
            $printerList[] = explode(" ", $printer)[0];
        }

        return $printerList;
    }

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * beforeSave method
     *
     * @param array $options array of options
     * @return void
     */
    public function beforeSave($options = [])
    {
        $defaultActions = $this->data[$this->alias]['set_as_default_on_these_actions'];
        if (!empty($defaultActions)) {
            $this->data['Printer']['set_as_default_on_these_actions'] = implode("\n", $defaultActions);
        }
    }

    /**
     * afterFind
     * @param array $results results of find
     * @param bool $primary Primary model or call from another
     * @return mixed
     */
    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['set_as_default_on_these_actions'])) {
                $defaultActions = $val[$this->alias]['set_as_default_on_these_actions'];
                $results[$key][$this->alias]['set_as_default_on_these_actions'] = explode("\n", $defaultActions);
            }
        }

        return $results;
    }

    /**
     * isControllerActionDuplicated validation method
     * @param array $check fieldName => fieldValue
     * @param array $options array of options
     * @return bool
     */
    public function isControllerActionDuplicated($check, $options)
    {
        $soptions = [
            'conditions' => [
                'Printer.active' => 1
            ]
        ];

        if (isset($this->data['Printer']['id'])) {
            $soptions['conditions']['NOT']['Printer.id'] = $this->data['Printer']['id'];
        }

        $allFields = $this->find('all', $soptions);

        $matched = [];

        foreach ($check['set_as_default_on_these_actions'] as $checkThis) {
            foreach ($allFields as $field) {
                if (
                    is_array($field['Printer']['set_as_default_on_these_actions']) &&
                    in_array(
                        $checkThis,
                        $field['Printer']['set_as_default_on_these_actions']
                    )
                ) {
                    if (isset($matched[$field['Printer']['id']]['duplicates'])) {
                        array_push($matched[$field['Printer']['id']]['duplicates'], $checkThis);
                    } else {
                        $matched[$field['Printer']['id']] = [
                            'duplicates' => [$checkThis]
                        ];
                    }
                    $matched[$field['Printer']['id']]['printer'] = $field["Printer"]['name'];
                }
            }
        }
        $msg = '';
        $ctr = 0;
        foreach ($matched as $match) {
            if ($ctr > 0) {
                $msg .= ' ';
            }
            $msg = 'You need to edit "';
            $msg .= $match['printer'] . '" and remove ' . CakeText::toList($match['duplicates']);
        }

        $this->validator()->getField('set_as_default_on_these_actions')
            ->getRule('noDups')->message
        = $msg;

        return count($matched) === 0;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'notBlank' => [
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'queue_name' => [
            'notBlank' => [
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'set_as_default_on_these_actions' => [
            'noDups' => [
                'rule' => ['isControllerActionDuplicated'],
                'message' => "This controller / action is already specified in another printer"
            ]
        ]
    ];
}