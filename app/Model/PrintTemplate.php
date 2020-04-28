<?php
App::uses('AppModel', 'Model');

/**
 * PrintTemplate Model
 *
 * @property Item $Item
 */
class PrintTemplate extends AppModel
{
    /**
     * @var array
     */
    /*
    [file_template] => Array
    (
    [name] => 100x50sample.glabels
    [type] => application/octet-stream
    [tmp_name] => /tmp/phpV7gTKu
    [error] => 0
    [size] => 11601
    )

    )
     */

    /**
     * method beforeSave
     *
     * @param array $options Options array from ->save
     */
    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $result) {
            if (
                isset($result['PrintTemplate']['print_controller']) &&
                !empty($result['PrintTemplate']['print_controller']) &&
                isset($result['PrintTemplate']['print_action']) &&
                !empty($result['PrintTemplate']['print_action'])
            ) {
                $results[$key]['PrintTemplate']['controller_action'] =
                    $result['PrintTemplate']['print_controller'] . '::' .
                    $result['PrintTemplate']['print_action'];
            }
        }

        return $results;
    }

    public $actsAs = [
        'Tree',
        'FileUpload.FileUpload' => [
            //if false, files will be upload to the exact path of uploadDir

            'forceWebroot' => true,
            'fields' => [
                'name' => 'file_template',
                'type' => 'type',
                'size' => 'size',
            ],
            'uploadFormFields' => [
                'file_template',
                'example_image',
            ],
            'allowedTypes' => [
                'jpg' => ['image/jpeg', 'image/pjpeg'],
                'jpeg' => ['image/jpeg', 'image/pjpeg'],
                'gif' => ['image/gif'],
                'png' => ['image/png', 'image/x-png'],
                'glabels' => ['application/x-gzip', 'application/octet-stream'],
            ],
            'fileVar' => 'file_template_upload',

            //required - default is false, if true a validation error would occur if a file wsan't uploaded.

            'required' => false,

            //maxFileSize bytes OR false to turn off maxFileSize (default false)

            'maxFileSize' => false,

            //unique - filenames will overwrite existing files of the same name. (default true)

            'unique' => true,

            //fileNameFunction - execute the Sha1 function on a filename before saving it (default false)

            'fileNameFunction' => false,
        ],
    ];

    /**
     * @param bool $cascade Cascade
     */
    public function beforeDelete($cascade = true)
    {
        $this->fileTemplateName = $this->findById($this->id);

        return true;
    }

    /**
     * @param string $fileName file name to delete
     * @return void
     */
    public function deleteFileTemplate($fileName)
    {
        $fileToDelete = WWW_ROOT . Configure::read('GLABELS_ROOT') . DS . $fileName;

        $file = new File($fileToDelete);
        $file->delete();
    }

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'unique' => [
                'rule' => 'isUnique',
                'message' => 'Name must be unique',
            ],
        ],
        /*'print_action' => [
        'notBlank' => [
        'rule' => ['notBlank']
        ]
        ],*/
        'text_template' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
    ];

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'Item' => [
            'className' => 'Item',
            'foreignKey' => 'print_template_id',
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
        'CartonLabel' => [
            'className' => 'Item',
            'foreignKey' => 'carton_label_id',
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
        'ChildTemplate' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'parent_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => ['lft' => 'ASC'],
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
        'ParentTemplate' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ],
    ];
}