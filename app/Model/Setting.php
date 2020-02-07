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
     * @param string $refname setting name
     * @param string $productType 'sscc'
     * @return string a number with leading zeros
     */
    public function getReferenceNumber($refname, $productType = null)
    {
        $ref = $this->find(
            'first',
            [
                'conditions' => [
                    'name' => $refname,
                ],
            ]
        );

        $next_val = $ref['Setting']['setting'] + 1;

        switch ($productType) {
            case 'sscc':
                $fmt = '%09d';
                break;
            default:
                break;
        }

        $this->id = $ref['Setting']['id'];

        $this->saveField('setting', $next_val, false);

        return sprintf($fmt, $next_val);
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