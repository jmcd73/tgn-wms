<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \App\Model\Table\MenusTable&\Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \App\Model\Table\MenusTable&\Cake\ORM\Association\HasMany $ChildMenus
 *
 * @method \App\Model\Entity\Menu newEmptyEntity()
 * @method \App\Model\Entity\Menu newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \App\Model\Entity\Menu findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Menu[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Menu|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Menu saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class MenusTable extends Table
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

        $this->setTable('menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentMenus', [
            'className' => 'Menus',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Menus',
            'foreignKey' => 'parent_id',
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
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->boolean('divider')
            ->requirePresence('divider', 'create')
            ->notEmptyString('divider');

        $validator
            ->boolean('header')
            ->requirePresence('header', 'create')
            ->notEmptyString('header');

        $validator
            ->boolean('admin_menu')
            ->requirePresence('admin_menu', 'create')
            ->notEmptyString('admin_menu');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 45)
            ->allowEmptyString('description');

        $validator
            ->scalar('url')
            ->maxLength('url', 254)
            ->allowEmptyString('url');

        $validator
            ->scalar('options')
            ->maxLength('options', 254)
            ->allowEmptyString('options');

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title');

        $validator
            ->scalar('bs_url')
            ->maxLength('bs_url', 255)
            ->requirePresence('bs_url', 'create')
            ->notEmptyString('bs_url');

        $validator
            ->scalar('extra_args')
            ->maxLength('extra_args', 255)
            ->allowEmpty('extra_args');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));

        return $rules;
    }
}