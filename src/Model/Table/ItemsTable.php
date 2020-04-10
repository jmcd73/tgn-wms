<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \App\Model\Table\PackSizesTable&\Cake\ORM\Association\BelongsTo $PackSizes
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \App\Model\Table\PrintTemplatesTable&\Cake\ORM\Association\BelongsTo $PrintTemplates
 * @property \App\Model\Table\CartonsTable&\Cake\ORM\Association\HasMany $Cartons
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\Pallets.sTable&\Cake\ORM\Association\HasMany $Pallets.s
 *
 * @method \App\Model\Entity\Item newEmptyEntity()
 * @method \App\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TgnUtils');
        $this->belongsTo('PackSizes', [
            'foreignKey' => 'pack_size_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PrintTemplates', [
            'foreignKey' => 'pallet_template_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CartonTemplates', [
            'className' => 'PrintTemplates',
            'foreignKey' => 'carton_template_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Cartons', [
            'foreignKey' => 'item_id',
        ]);
        $this->hasMany('Pallets.s', [
            'foreignKey' => 'item_id',
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
            ->scalar('code')
            ->maxLength('code', 10)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 32)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->scalar('trade_unit')
            ->maxLength('trade_unit', 14)
            ->allowEmptyString('trade_unit');

        $validator
            ->scalar('consumer_unit')
            ->maxLength('consumer_unit', 14)
            ->allowEmptyString('consumer_unit');

        $validator
            ->scalar('brand')
            ->maxLength('brand', 32)
            ->allowEmptyString('brand');

        $validator
            ->scalar('variant')
            ->maxLength('variant', 32)
            ->allowEmptyString('variant');

        $validator
            ->integer('unit_net_contents')
            ->allowEmptyString('unit_net_contents');

        $validator
            ->scalar('unit_of_measure')
            ->maxLength('unit_of_measure', 4)
            ->allowEmptyString('unit_of_measure');

        $validator
            ->integer('days_life')
            ->allowEmptyString('days_life');

        $validator
            ->integer('min_days_life')
            ->requirePresence('min_days_life', 'create')
            ->notEmptyString('min_days_life');

        $validator
            ->scalar('item_comment')
            ->requirePresence('item_comment', 'create')
            ->notEmptyString('item_comment');

        $validator
            ->integer('pallet_label_copies')
            ->allowEmptyString('pallet_label_copies');

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
        $rules->add($rules->isUnique(['code']));
        $rules->add($rules->existsIn(['pack_size_id'], 'PackSizes'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));
        $rules->add($rules->existsIn(['pallet_template_id'], 'PrintTemplates'));
        $rules->add($rules->existsIn(['carton_template_id'], 'CartonLabels'));

        return $rules;
    }

    /**
     * @param string $term Item snippet to lookup
     * @return mixed
     */
    public function itemLookup($term)
    {
        $options = [
            'recursive' => -1,
            'conditions' => [
                'Items.id IN (SELECT Pallets.item_id from pallets as Pallets)',
                'Items.code LIKE' => '%' . $term . '%',
            ],
            'fields' => [
                'Items.id',
                'Items.code',
                'Items.description',
                'Items.trade_unit',
            ],
            'order' => [
                'Items.code' => 'ASC',
            ],
        ];

        $items = $this->find('all', $options)->toArray();

        $items = Hash::map($items, '{n}', [$this, 'fmtItem']);

        return $items;
    }

    /**
     * @param array $data Array of data to format
     * @return array data to return to a javascript control somewhere
     */
    public function fmtItem($data)
    {
        return [
            'label' => $data['description'],
            'value' => $data['code'],
            'trade_unit' => $data['trade_unit'],
            'id' => $data['id'],
        ];
    }

    /**
    * getPalletPrintItems - for Pallet print item display field
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
}