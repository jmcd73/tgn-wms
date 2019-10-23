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


    public $actsAs = [
        'Tree',
        'FileUpload.FileUpload' => [
            'forceWebroot' => true, //if false, files will be upload to the exact path of uploadDir
            'fields' => [
                'name' => 'file_template',
                'type' => 'type',
                'size' => 'size'
            ],
            'uploadFormFields' => [
                'file_template',
                'example_image'
            ],
            'allowedTypes' => [
                'jpg' => ['image/jpeg', 'image/pjpeg'],
                'jpeg' => ['image/jpeg', 'image/pjpeg'],
                'gif' => ['image/gif'],
                'png' => ['image/png', 'image/x-png'],
                'glabels' => ['application/x-gzip', 'application/octet-stream']
            ],
            'fileVar' => 'file_template_upload',
            'required' => false, //default is false, if true a validation error would occur if a file wsan't uploaded.
            'maxFileSize' => false, //bytes OR false to turn off maxFileSize (default false)
            'unique' => true, //filenames will overwrite existing files of the same name. (default true)
            'fileNameFunction' => false //execute the Sha1 function on a filename before saving it (default false)
        ]
    ];

    /**
     * @param array $options
     */
    /*
    public function beforeSave($options = [])
    {
    $fileName = $this->data["PrintTemplate"]['file_template']['name'];
    $deleteFileTemplate =  isset($this->data["PrintTemplate"]['delete_file_template']) ?
    (bool) $this->data["PrintTemplate"]['delete_file_template'] : false ;

    if ($fileName && !$deleteFileTemplate) {

    if ($this->id) {
    $this->fileTemplateName = $this->findById($this->id);
    $previousFileName = $this->fileTemplateName["PrintTemplate"]['file_template'];
    if ($previousFileName !== $fileName) {
    $this->deleteFileTemplate($previousFileName);
    }
    }

    $uploadFolder = WWW_ROOT . Configure::read('GLABELS_ROOT');
    $targetFolder = new Folder($uploadFolder, true, 0777);
    $tmpName = $this->data["PrintTemplate"]['file_template']['tmp_name'];
    $fileName = $this->data["PrintTemplate"]['file_template']['name'];
    $targetName = $targetFolder->path . DS . $fileName;

    if (move_uploaded_file($tmpName, $targetName)) {
    chmod($targetName, 0777);
    $this->data['PrintTemplate']['file_template'] = $fileName;
    } else {

    throw new CakeException('Failed to move uploaded file to ' . $fileName);

    };

    } else {
    unset($this->data['PrintTemplate']['file_template']);
    }

    if (!empty($this->id) && $deleteFileTemplate) {
    $this->fileTemplateName = $this->findById($this->id);

    $this->deleteFileTemplate(
    $this->fileTemplateName['PrintTemplate']['file_template']
    );

    $this->data['PrintTemplate']['file_template'] = '';

    }

    return true;

    }*/

    /**
     * @param $cascade
     */
    /*
    public function beforeDelete($cascade = true)
    {
    $this->fileTemplateName = $this->findById($this->id);
    return true;

    }*/

    /**
     * @param $fileName
     */
    public function deleteFileTemplate($fileName)
    {

        $fileToDelete = WWW_ROOT . Configure::read('GLABELS_ROOT') . DS . $fileName;

        $file = new File($fileToDelete);
        $file->delete();
    }

    /*public function afterDelete()
    {
    // /var/www/wms/app/webroot//files/templates/

    $fileName = $this->fileTemplateName['PrintTemplate']['file_template'];
    $this->deleteFileTemplate($fileName);
    }*/

/**
 * Use database config
 *
 * @var string
 */

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
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
            'unique' => [
                'rule' => 'isUnique',
                'message' => 'Name must be unique'
            ]
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
                'allowEmpty' => true
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ]
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
            'counterQuery' => ''
        ],
        'ChildTemplate' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'parent_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => ['lft' => "ASC"],
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
    ];

    public $belongsTo = [
        'ParentTemplate' => [
            'className' => 'PrintTemplate',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];
}
