<?php
App::uses('AppModel', 'Model');
/**
 * Carton Model
 *
 * @property Pallet $Pallet
 */
class Carton extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'best_before';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'count' => [
            'naturalNumber' => [
                'rule' => ['naturalNumber', true],
                //'message' => 'Your custom message here',
                 'allowEmpty' => true
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'pallet_id' => [
            'notShipped' => [
                'rule' => 'notShipped',
                'message' => 'You cannot modify cartons on a pallet that has already been shipped'
            ]
        ],
        'production_date' => [
            'date' => [
                'rule' => ['date'],
                //'message' => 'Your custom message here',
                 'allowEmpty' => true
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'uniqueDate' => [
                'rule' => 'isUniqueDate',
                'message' => "A date should only appear once for each pallet"
            ]
        ]
    ];

    /**
     * @param array $check check array for pallet_id
     * @return bool
     */
    public function notShipped($check)
    {
        $palletId = array_values($check)[0];

        $pallet = $this->Pallet->find(
            'first',
            [
                'conditions' => [
                    'Pallet.id' => $palletId
                ],
                'contain' => [
                    'Shipment'
                ]
            ]
        );

        $this->log(['notShipped' => $pallet]);

        return $pallet['Shipment']['shipped'] !== true;
    }

    /**
     * isUniqueDate
     * @param array $check  [ fieldName => fieldValue ]
     * @return bool
     */
    public function isUniqueDate($check)
    {
        $conditions = [
            'pallet_id' => $this->data['Carton']['pallet_id']
        ] + $check;

        if (isset($this->data['Carton']['id']) && is_numeric($this->data['Carton']['id']) && $this->data['Carton']['id'] > 0) {
            return $this->find(
                'count',
                [
                    'conditions' => $conditions + ['NOT' => ['id' => $this->data['Carton']['id']]],
                    'recursive' => -1
                ]
            ) == 0;
        }
        $conditions = [
            'pallet_id' => $this->data['Carton']['pallet_id']
        ] + $check;

        $count = $this->find(
            'count',
            [
                'conditions' => $conditions,
                'recursive' => -1
            ]
        );

        return $count == 0;
    }

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Pallet' => [
            'className' => 'Pallet',
            'foreignKey' => 'pallet_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];
}