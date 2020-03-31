<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 */
class Setting extends AppModel
{
    /**
     * Display field
     * @var string
     */
    public $displayField = 'name';

    /**
     * @param string $settingName setting name
     * @param int $companyPrefix the GS1 company prefix
     *
     * @return string a number with leading zeros
     */
    public function getReferenceNumber($settingName, $companyPrefix)
    {
        $next_val = $this->getSetting($settingName) + 1;

        $companyPrefixLength = strlen($companyPrefix);

        $fmt = '%0' . (16 - $companyPrefixLength) . 'd';

        $saveThis = [
            'id' => $this->settingId,
            'setting' => $next_val,
        ];

        $this->save($saveThis, false);

        return sprintf($fmt, $next_val);
    }

    public function getCompanyPrefix()
    {
        return $this->getSetting(Configure::read('SSCC_COMPANY_PREFIX'));
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'qty' => [
            'isNumeric' => [
                'rule' => ['numeric'],
                'message' => 'This must be a number',
            ],
        ],
        'name' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'isUnique' => [
                'rule' => 'isUnique',
                'message' => 'The setting name must be unique',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'setting' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
    ];
}