<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validation;
use Cake\Validation\Validator;
use Psr\Http\Message\UploadedFileInterface;

/**
 * PrintTemplates Model
 *
 * @property \App\Model\Table\PrintTemplatesTable&\Cake\ORM\Association\BelongsTo $ParentPrintTemplates
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\PrintTemplatesTable&\Cake\ORM\Association\HasMany $ChildPrintTemplates
 * @method \App\Model\Entity\PrintTemplate newEmptyEntity()
 * @method \App\Model\Entity\PrintTemplate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PrintTemplate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PrintTemplate get($primaryKey, $options = [])
 * @method \App\Model\Entity\PrintTemplate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PrintTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PrintTemplate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PrintTemplate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrintTemplate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrintTemplate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintTemplate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintTemplate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintTemplate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class PrintTemplatesTable extends Table
{
    /**
     * Initialize method
     *
     * @param  array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('print_templates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('TgnUtils');

        $this->belongsTo('ParentPrintTemplates', [
            'className' => 'PrintTemplates',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'pallet_template_id',
        ]);
        $this->hasMany('CartonTemplates', [
            'className' => 'Items',
            'foreign_key' => 'carton_template_id',
        ]);
        $this->hasMany('ChildPrintTemplates', [
            'className' => 'PrintTemplates',
            'foreignKey' => 'parent_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param  \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->allowEmptyString('description');

        $validator
            ->scalar('text_template')
            ->maxLength('text_template', 2000)
            ->allowEmptyString('text_template');

        $validator
            ->scalar('file_template')
            ->maxLength('file_template', 200)
            ->allowEmptyFile('file_template');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('is_file_template')
            ->allowEmptyFile('is_file_template');

        $validator
            ->scalar('controller_action')
            ->maxLength('controller_action', 50)
            ->allowEmptyString('controller_action');

        $validator
            ->scalar('example_image')
            ->maxLength('example_image', 200)
            ->allowEmptyFile('example_image');

        $validator
            ->scalar('file_template_type')
            ->maxLength('file_template_type', 200);

        $validator
            ->integer('file_template_size');

        $validator
            ->integer('example_image_size')
            ->allowEmptyFile('example_image_size');

        $validator
            ->scalar('example_image_type')
            ->maxLength('example_image_type', 200)
            ->allowEmptyFile('example_image_type');

        $validator
            ->boolean('show_in_label_chooser')
            ->allowEmptyString('show_in_label_chooser');

        $validator
            ->scalar('replace_tokens')
            ->maxLength('replace_tokens', 2000)
            ->allowEmptyString('replace_tokens');

        $validator
            ->allowEmptyFile('upload_file_template')
            ->uploadedFile('upload_file_template', [
                'types' => ['application/gzip', 'text/xml'], // only PNG image files
                'minSize' => 800, // Min 1 KB
                'maxSize' => 1024 * 1024, // Max 1 MB
            ])
         /*    ->add('upload_file_template', 'minImageSize', [
                'rule' => ['imageSize', [
                    // Min 10x10 pixel
                    'width' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                    'height' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                ]],
            ]) */
        /*     ->add('upload_file_template', 'maxImageSize', [
                'rule' => ['imageSize', [
                    // Max 100x100 pixel
                    'width' => [Validation::COMPARE_LESS_OR_EQUAL, 3000],
                    'height' => [Validation::COMPARE_LESS_OR_EQUAL, 3000],
                ]],
            ]) */
            ->add('upload_file_template', 'filename', [
                'rule' => function (UploadedFileInterface $file) {
                    // filename must not be a path
                    $filename = $file->getClientFilename();
                    if (strcmp(basename($filename), $filename) === 0) {
                        return true;
                    }

                    return false;
                },
            ])
            ->add('upload_file_template', 'extension', [
                'rule' => ['extension', ['glabels']], // .png file extension only
            ]);

        $validator->allowEmptyFile('upload_example_image')
    ->uploadedFile('upload_example_image', [
        'types' => ['image/png'], // only PNG image files
        'minSize' => 1024, // Min 1 KB
        'maxSize' => 1024 * 1024, // Max 1 MB
    ])
    ->add('upload_example_image', 'minImageSize', [
        'rule' => ['imageSize', [
            // Min 10x10 pixel
            'width' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
            'height' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
        ]],
    ])
    ->add('upload_example_image', 'maxImageSize', [
        'rule' => ['imageSize', [
            // Max 100x100 pixel
            'width' => [Validation::COMPARE_LESS_OR_EQUAL, 3000],
            'height' => [Validation::COMPARE_LESS_OR_EQUAL, 3000],
        ]],
    ])
    ->add('upload_example_image', 'filename', [
        'rule' => function (UploadedFileInterface $file) {
            // filename must not be a path
            $filename = $file->getClientFilename();
            if (strcmp(basename($filename), $filename) === 0) {
                return true;
            }

            return false;
        },
    ])
    ->add('upload_example_image', 'extension', [
        'rule' => ['extension', ['png']], // .png file extension only
    ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param  \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['parent_id'], 'ParentPrintTemplates'));

        return $rules;
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        //tog($event, $entity, $options);
    }
}