<?php

App::uses('AppModel', 'Model');

/**
 * Item Model
 *
 */
class Item extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */

    public function getPalletPrintItems($productTypeId)
    {

        $options = [
            'conditions' => [
                'NOT' => [
                    'active' => 0
                ],
                'product_type_id' => $productTypeId
            ],
            'order' => [
                'code' => 'ASC'
            ],
            'recursive' => -1
        ];

        return $this->find('list', $options);
    }

    /**
     * @var array
     */
    public $virtualFields = [
        'name' => 'CONCAT(Item.code, " - ", Item.description)'
    ];
    /**
     * @var string
     */
    public $displayField = 'name';

    /**
     * @param $term
     * @return mixed
     */
    public function item_lookup($term)
    {

        $options = [
            'recursive' => -1,
            'conditions' => [
                'Item.id IN (SELECT Label.item_id from labels as Label)',
                'Item.code LIKE' => '%' . $term . '%'
            ],
            'fields' => [
                'Item.id',
                'Item.code',
                'Item.name',
                'Item.trade_unit'
            ],
            'order' => [
                'Item.code' => 'ASC'
            ]
        ];

        $items = $this->find('all', $options);

        $items = Hash::map($items, '{n}.Item', [$this, 'fmt_item']);

        return $items;
    }

    /**
     * @param $data
     */
    public function fmt_item($data)
    {

        return [
            'label' => $data['name'],
            'value' => $data['code'],
            'trade_unit' => $data['trade_unit'],
            'id' => $data['id']
        ];
    }

    public function code_desc_pack()
    {
        $this->Behaviors->load('Containable');

        $options = [
            'contain' => ['PackSize' => [
                'fields' => ['id', 'pack_size']
            ]
            ],
            'conditions' => [
                'Item.active' => 1
            ],
            'order' => [
                'Item.code' => 'ASC'
            ],
            'fields' => [
                'Item.id',
                'CONCAT( Item.code, " - " , Item.description, " (", PackSize.pack_size , ")") as item_pack'
            ],
            'recursive' => -1
        ];

        $items_fmt = $this->Report->Item->find('all', $options);

        return Hash::combine($items_fmt, '{n}.Item.id', '{n}.{n}.item_pack');
    }

    /**
     * @param $check
     */
    public function checkItemCodeIsValid($check)
    {
        $field = array_keys($check)[0];
        $value = array_values($check)[0];

        //$this->find
        $productTypeId = $this->data['Item']['product_type_id'];
        $productType = $this->ProductType->findById($productTypeId);
        $codeRegex = $productType['ProductType']['code_regex'];
        $this->validator()->getField($field)
            ->getRule('item_code')->message
                = $productType['ProductType']['code_regex_description'];

        //$this->validator()->getField('password')
        // ->getRule('required')->message = 'This field cannot be left blank';
        return preg_match($codeRegex, $value) === 1;

    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'code' => [
            'isUnique' => [
                'rule' => ['isUnique'],
                'message' => 'This Item code already exists. Item codes must be unique.'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'item_code' => [
                'rule' => 'checkItemCodeIsValid',
                'message' => "validation message"
            ],
            /* 'length' => array(
            'rule' => array('lengthBetween', 5,5),
            'message' => "Item code must be 5 digits long"
            ), */
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'description' => [
            'lengthBetween' => [
                'rule' => ['lengthBetween', 5, 32],
                'message' => 'Must be between 5 and 32 characters long'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'quantity' => [
            'numeric' => [
                'rule' => ['numeric']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],

        'item' => [
            'notEmpty' => [
                'rule' => 'notBlank'
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'days_life' => [
            'numbersOnly' => [
                'rule' => ['numeric'],
                'message' => 'Days life is needed to calculate best before'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'print_template_id' => [
            'printTemplate' => [
                'rule' => 'notBlank',
                'message' => 'All products require a pallet label print template'
            ]
        ],
        'trade_unit' => [
            'tradeUnit' => [
                'rule' => 'notBlank',
                'message' => 'TUN Barcode is mandatory'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ],
        'pack_size_id' => [
            'packSizeId' => [
                'rule' => 'notBlank',
                'message' => 'Pack Size is mandatory'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]

        ],
        'product_type_id' => [
            'productTypeId' => [
                'rule' => 'notBlank',
                'message' => 'Product Type is mandatory'
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]

        ]
    ];
    /**
     * @var array
     */
    public $hasMany = [
        'Label' => [
            'className' => 'Label',
            'foreignKey' => 'item_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
    ];
    /**
     * @var array
     */
    public $belongsTo = [
        'PackSize' => [
            'className' => 'PackSize',
            'foreignKey' => 'pack_size_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'PrintTemplate' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'print_template_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'CartonLabel' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'carton_label_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'ProductType' => [
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

}
