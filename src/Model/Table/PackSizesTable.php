<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PackSizes Model
 *
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\HasMany $Items
 *
 * @method \App\Model\Entity\PackSize newEmptyEntity()
 * @method \App\Model\Entity\PackSize newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PackSize[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PackSize get($primaryKey, $options = [])
 * @method \App\Model\Entity\PackSize findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PackSize patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PackSize[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PackSize|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PackSize saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PackSize[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PackSize[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PackSize[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PackSize[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PackSizesTable extends Table
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

        $this->setTable('pack_sizes');
        $this->setDisplayField('pack_size');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Items', [
            'foreignKey' => 'pack_size_id',
        ]);
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
            ->scalar('pack_size')
            ->maxLength('pack_size', 30)
            ->requirePresence('pack_size', 'create')
            ->notEmptyString('pack_size');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 100)
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

        return $validator;
    }
}