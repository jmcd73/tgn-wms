<?php

App::uses('AppModel', 'Model');
App::import('Vendor', 'BarcodeValidator', [
    'file' => 'imelgrat' . DS . 'barcode-validator' . DS . 'src' . DS . 'barcode-validator.php',
]);

// vendors/imelgrat/barcode-validator/src/barcode-validator.php
/**
 * Item Model
 *
 */
class Item extends AppModel
{
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->virtualFields['name'] = sprintf(
            'CONCAT(%s.code, " - ", %s.description)',
            $this->alias,
            $this->alias
        );
    }

    /**
     * Display field
     *
     * @param in $productTypeId Product Type ID
     * @return array
     */
    public function getPalletPrintItems($productTypeId)
    {
        $options = [
            'conditions' => [
                'NOT' => [
                    'active' => 0,
                ],
                'product_type_id' => $productTypeId,
            ],
            'order' => [
                'code' => 'ASC',
            ],
            'recursive' => -1,
        ];

        return $this->find('list', $options);
    }

    /**
     * @var array
     */
    /*  public $virtualFields = [
         'name' => 'CONCAT(Item.code, " - ", Item.description)',
     ]; */
    /**
     * @var string
     */
    public $displayField = 'name';

    /**
     * @param string $term Item snippet to lookup
     * @return mixed
     */
    public function itemLookup($term)
    {
        $options = [
            'recursive' => -1,
            'conditions' => [
                'Item.id IN (SELECT Pallet.item_id from pallets as Pallet)',
                'Item.code LIKE' => '%' . $term . '%',
            ],
            'fields' => [
                'Item.id',
                'Item.code',
                'Item.name',
                'Item.trade_unit',
            ],
            'order' => [
                'Item.code' => 'ASC',
            ],
        ];

        $items = $this->find('all', $options);

        $items = Hash::map($items, '{n}.Item', [$this, 'fmtItem']);

        return $items;
    }

    /**
     * @param array $data Array of data to format
     * @return array data to return to a javascript control somewhere
     */
    public function fmtItem($data)
    {
        return [
            'label' => $data['name'],
            'value' => $data['code'],
            'trade_unit' => $data['trade_unit'],
            'id' => $data['id'],
        ];
    }

    /**
     * @param array $check Check array field / value
     * @return bool
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

    public function isValidConsumerUnit($check)
    {
        return BarcodeValidator::IsValidEAN13(array_values($check)[0]);
    }

    public function isValidTradeUnit($check)
    {
        return BarcodeValidator::IsValidEAN14(array_values($check)[0]);
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
                'message' => 'This Item code already exists. Item codes must be unique.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'item_code' => [
                'rule' => 'checkItemCodeIsValid',
                'message' => 'validation message',
            ],
            /* 'length' => array(
            'rule' => array('lengthBetween', 5,5),
            'message' => "Item code must be 5 digits long"
            ), */
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'description' => [
            'lengthBetween' => [
                'rule' => ['lengthBetween', 5, 32],
                'message' => 'Must be between 5 and 32 characters long',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'quantity' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],

        'item' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'days_life' => [
            'numbersOnly' => [
                'rule' => ['numeric'],
                'message' => 'Days life is needed to calculate best before',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],

        'print_template_id' => [
            'printTemplate' => [
                'rule' => 'notBlank',
                'message' => 'All products require a pallet label print template',
            ],
        ],
        'consumer_unit' => [
            'consumerUnit' => [
                'rule' => 'isValidConsumerUnit',
                'message' => 'Must be a valid barcode',
                'allowEmpty' => true,
            ],
        ],
        'trade_unit' => [
            'tradeUnit' => [
                'rule' => 'notBlank',
                'message' => 'TUN Barcode is mandatory',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'isValidBarcode' => [
                'rule' => 'isValidTradeUnit',
                'message' => 'Must be a valid barcode',
            ],
        ],
        'pack_size_id' => [
            'packSizeId' => [
                'rule' => 'notBlank',
                'message' => 'Pack Size is mandatory',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'product_type_id' => [
            'productTypeId' => [
                'rule' => 'notBlank',
                'message' => 'Product Type is mandatory',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
    ];
    /**
     * @var array
     */
    public $hasMany = [
        'Pallet' => [
            'className' => 'Pallet',
            'foreignKey' => 'item_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ],
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
            'order' => '',
        ],
        'PrintTemplate' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'print_template_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
        'CartonLabel' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'carton_label_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
        'ProductType' => [
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
    ];
}