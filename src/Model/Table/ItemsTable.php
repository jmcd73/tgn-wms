<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Lib\Utility\Barcode;
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
     * @param  array $config The configuration for the Table.
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
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->belongsTo('PrintTemplates', [
            'foreignKey' => 'pallet_template_id',
        ]);
        $this->belongsTo('CartonTemplates', [
            'className' => 'PrintTemplates',
            'foreignKey' => 'carton_template_id',
        ]);
        $this->hasMany('Cartons', [
            'foreignKey' => 'item_id',
        ]);
        $this->hasMany('Pallets', [
            'foreignKey' => 'item_id',
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
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->scalar('code')
            ->maxLength('code', 10)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'custom', [
                'rule' => [$this, 'isValidCode'],
                'message' => 'This code must comply with the product types code regex',
            ])
            ->add('code', 'unique', [
                'rule' => 'validateUnique',
                'message' => 'Item code must be unique',
                'provider' => 'table',
            ]);

        $validator
            ->scalar('description')
            ->maxLength('description', 32)
            ->requirePresence('description', 'create')
            ->notEmptyString('description')
            ->add('description', 'unique', [
                'rule' => 'validateUnique',
                'message' => 'Description must be unique',
                'provider' => 'table',
            ]);

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->scalar('trade_unit')
            ->maxLength('trade_unit', 14)
            ->allowEmptyString('trade_unit')
            // Use an array callable that is not in a provider
    ->add('trade_unit', 'custom', [
        'rule' => [$this, 'isBarcode'],
        'message' => 'Please enter a valid barcode',
    ]);

        $validator
            ->scalar('consumer_unit')
            ->maxLength('consumer_unit', 14)
            ->allowEmptyString('consumer_unit')
            ->add('consumer_unit', 'custom', [
                'rule' => [$this, 'isBarcode'],
                'message' => 'Please enter a valid barcode',
            ]);

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
            ->allowEmptyString('min_days_life');

        $validator
            ->scalar('item_comment')
            ->requirePresence('item_comment', 'create')
            ->allowEmptyString('item_comment');

        $validator
            ->integer('pallet_label_copies')
            ->allowEmptyString('pallet_label_copies');

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
        $rules->add($rules->isUnique(['code']));
        $rules->add($rules->existsIn(['pack_size_id'], 'PackSizes'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));
        $rules->add($rules->existsIn(['pallet_template_id'], 'PrintTemplates'));
        $rules->add($rules->existsIn(['carton_template_id'], 'CartonTemplates'));
        $rules->addDelete($rules->isNotLinkedTo(
            'Pallets',
            'item_id',
            'Items must have no associated pallets to enable deletion.'
        ));

        return $rules;
    }

    /**
     * @param  string $term Item snippet to lookup
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
     * @param  array $data Array of data to format
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
     * @param  in    $productTypeId Product Type ID
     * @return array
     */
    public function getPalletPrintItems($productTypeId): Query
    {
        $options = [
            'keyField' => 'id',
            'valueField' => 'code_desc',
            'conditions' => [
                'active' => 1,
                'product_type_id' => $productTypeId,
                'trade_unit IS NOT NULL',
                'trade_unit <>' => '',
            ],
            'order' => [
                'code' => 'ASC',
            ],
        ];

        return $this->find('list', $options);
    }

    public function isBarcode($value, $context)
    {
        return (new Barcode())->isValidBarcode($value);
    }

    public function isValidCode($value, $context)
    {
        $productType = $this->ProductTypes->get($context['data']['product_type_id']);
        if (preg_match($productType->code_regex, $value) === 1) {
            return  true;
        } else {
            return sprintf(
                'For %s product types. %s',
                $productType->name,
                $productType->code_regex_description
            );
        }
    }
}