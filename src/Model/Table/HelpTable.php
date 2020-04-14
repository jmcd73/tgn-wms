<?php
declare(strict_types=1);

namespace App\Model\Table;

use \Parsedown;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Help Model
 *
 * @method \App\Model\Entity\Help newEmptyEntity()
 * @method \App\Model\Entity\Help newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Help[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Help get($primaryKey, $options = [])
 * @method \App\Model\Entity\Help findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Help patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Help[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Help|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Help saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Help[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Help[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Help[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Help[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class HelpTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('help');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('TgnUtils');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('controller_action')
            ->maxLength('controller_action', 60)
            ->requirePresence('controller_action', 'create')
            ->notEmptyString('controller_action')
            ->add('controller_action', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('markdown_document')
            ->maxLength('markdown_document', 100)
            ->allowEmptyString('markdown_document');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['controller_action']));

        return $rules;
    }

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
        $markdown = sprintf('<strong>%s</strong> file does not exist. Please edit this link to point to a valid markdown file', $mdDocumentPath);

        if ($markdownFile->exists()) {
            $fileContents = str_replace(
                '(images/',
                '(/docs/help/images/',
                $markdownFile->read()
            );

            $parsedown = new Parsedown();

            $markdown = $parsedown->text($fileContents);
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
}