<?php
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Help Model
 *
 */
class Help extends AppModel
{

    /**
     * useTable
     * @var string
     */
    public $useTable = 'help';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    /**
     * @param string $rootPath Root Path to Doc root
     * @return mixed
     */
    public function setDocumentationRoot($rootPath)
    {
        $docRoot = new Folder($rootPath);

        return $docRoot;
    }

    /**
     * @param string $mdDocumentPath Mark down path
     * @return mixed
     */
    public function getMarkdown($mdDocumentPath)
    {
        $markdownFile = new File($mdDocumentPath);
        $markdown = sprintf("<strong>%s</strong> file does not exist. Please edit this link to point to a valid markdown file", $mdDocumentPath);

        if ($markdownFile->exists()) {
            $fileContents = str_replace(
                '(images/',
                '(/docs/help/images/',
                $markdownFile->read()
            );

            $Parsedown = new Parsedown();

            $markdown = $Parsedown->text($fileContents);
            $markdownFile->close();
        }

        return $markdown;
    }

    /**
     * @param string $rootPath path to markdown files
     * @return mixed
     */
    public function listMdFiles($rootPath)
    {
        $docRootFolder = $this->setDocumentationRoot($rootPath);
        $files = $docRootFolder->find('.*\.md');
        $fileList = [];
        foreach ($files as $file) {
            $file = new File($rootPath . DS . $file);

            $fileList[] = $file->name;
        }

        return $fileList;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'controller' => [
            'notBlank' => [
                'rule' => ['notBlank']
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ]
        ]
    ];
}