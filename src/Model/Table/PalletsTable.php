<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

/**
 * Pallets Model
 *
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\BelongsTo $ProductionLines
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\PrintersTable&\Cake\ORM\Association\BelongsTo $Printers
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ShipmentsTable&\Cake\ORM\Association\BelongsTo $Shipments
 * @property \App\Model\Table\InventoryStatusesTable&\Cake\ORM\Association\BelongsTo $InventoryStatuses
 * @property \App\Model\Table\ProductTypesTable&\Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \App\Model\Table\CartonsTable&\Cake\ORM\Association\HasMany $Cartons
 *
 * @method \App\Model\Entity\Pallet newEmptyEntity()
 * @method \App\Model\Entity\Pallet newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pallet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pallet get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pallet findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pallet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pallet[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pallet|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pallet saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pallet[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pallet[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pallet[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pallet[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
 */
class PalletsTable extends Table
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

        $this->setTable('pallets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TgnUtils');
        $this->addBehavior('CounterCache', [
            'Shipments' => ['pallet_count'],
        ]);

        $this->belongsTo('ProductionLines', [
            'foreignKey' => 'production_line_id',
            'propertyName' => 'production_lines',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
            'propertyName' => 'items',
        ]);
        $this->belongsTo('Printers', [
            'foreignKey' => 'printer_id',
            'propertyName' => 'printers',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
        ]);
        $this->belongsTo('Shipments', [
            'foreignKey' => 'shipment_id',
        ]);
        $this->belongsTo('InventoryStatuses', [
            'foreignKey' => 'inventory_status_id',
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
        ]);
        $this->hasMany('Cartons', [
            'foreignKey' => 'pallet_id',
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
            ->scalar('item')
            ->maxLength('item', 10)
            ->requirePresence('item', 'create')
            ->notEmptyString('item');

        $validator
            ->scalar('description')
            ->maxLength('description', 50)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        /*    $validator
               ->scalar('best_before')
               ->maxLength('best_before', 10)
               ->requirePresence('best_before', 'create')
               ->notEmptyString('best_before'); */

        $validator
            ->date('bb_date')
            ->requirePresence('bb_date', 'create')
            ->notEmptyDate('bb_date');

        $validator
            ->scalar('gtin14')
            ->maxLength('gtin14', 14)
            ->requirePresence('gtin14', 'create')
            ->notEmptyString('gtin14');

        $validator
            ->integer('qty')
            ->requirePresence('qty', 'create')
            ->notEmptyString('qty');

        $validator
            ->scalar('qty_previous')
            ->maxLength('qty_previous', 255)
            ->requirePresence('qty_previous', 'create')
            ->notEmptyString('qty_previous');
        /*
                $validator
                    ->dateTime('qty_modified')
                    ->requirePresence('qty_modified', 'create')
                    ->notEmptyDateTime('qty_modified'); */

        $validator
            ->scalar('pl_ref')
            ->maxLength('pl_ref', 10)
            ->requirePresence('pl_ref', 'create')
            ->notEmptyString('pl_ref')
            ->add('pl_ref', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('sscc')
            ->maxLength('sscc', 18)
            ->requirePresence('sscc', 'create')
            ->notEmptyString('sscc')
            ->add('sscc', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('batch')
            ->maxLength('batch', 6)
            ->requirePresence('batch', 'create')
            ->notEmptyString('batch');

        $validator
            ->scalar('printer')
            ->maxLength('printer', 50)
            ->requirePresence('printer', 'create')
            ->notEmptyString('printer');

        $validator
            ->dateTime('print_date')
            ->requirePresence('print_date', 'create')
            ->notEmptyDateTime('print_date');

        $validator
            ->dateTime('cooldown_date')
            ->allowEmptyDateTime('cooldown_date');

        /*    $validator
               ->integer('min_days_life')
               ->requirePresence('min_days_life', 'create')
               ->notEmptyString('min_days_life'); */

        $validator
            ->scalar('production_line')
            ->maxLength('production_line', 45)
            ->requirePresence('production_line', 'create')
            ->notEmptyString('production_line');

        /*     $validator
                ->scalar('inventory_status_note')
                ->maxLength('inventory_status_note', 100)
                ->requirePresence('inventory_status_note', 'create')
                ->notEmptyString('inventory_status_note');

            $validator
                ->dateTime('inventory_status_datetime')
                ->requirePresence('inventory_status_datetime', 'create')
                ->notEmptyDateTime('inventory_status_datetime'); */

        /*    $validator
               ->boolean('ship_low_date')
               ->requirePresence('ship_low_date', 'create')
               ->notEmptyString('ship_low_date');

           $validator
               ->boolean('picked')
               ->requirePresence('picked', 'create')
               ->notEmptyString('picked'); */

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
        $rules->add($rules->isUnique(['pl_ref']));
        $rules->add($rules->isUnique(['sscc']));
        $rules->add($rules->existsIn(['production_line_id'], 'ProductionLines'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['printer_id'], 'Printers'));
        // $rules->add($rules->existsIn(['location_id'], 'Locations'));
        // $rules->add($rules->existsIn(['shipment_id'], 'Shipments'));
        // $rules->add($rules->existsIn(['inventory_status_id'], 'InventoryStatuses'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));

        return $rules;
    }

    /**
     * locationSpaceUsageOptions method
     * @param string $filter string of either 'all' or 'available'
     * @param string $productTypeId if productTypeId is all then no filter other wise pass in ID
     * @param array ExtraOptions $extraOptions some more conditions to add to $options array
     * @return array returns an option array configured correctly to find location availability
     */
    public function locationSpaceUsageOptions($filter, $productTypeId = 'all')
    {
        /*  $this->virtualFields['Pallets'] = 'COUNT(Pallets.id)';
         $this->virtualFields['hasSpace'] = 'COUNT(Pallets.id) < Locations.pallet_capacity';
         $this->virtualFields['LocationId'] = 'Locations.id';
         $this->virtualFields['pallet_capacity'] = 'Locations.pallet_capacity';
         $this->virtualFields['Location'] = 'Locations.location';

         $options = [
             'recursive' => -1,
             'fields' => [
                 'COUNT(Pallets.id) AS Pallet__Pallets',
                 'COUNT(Pallets.id) < Locations.pallet_capacity as Pallet__hasSpace',
                 'Locations.id  AS Pallet__LocationId',
                 'Locations.pallet_capacity AS Pallet__pallet_capacity',
                 'Locations.location AS Pallet__Location',
             ],
             'joins' => [
                 [
                     'table' => 'shipments',
                     'alias' => 'Shipment',
                     'type' => 'LEFT',
                     'conditions' => [
                         'Pallets.shipment_id = Shipments.id',
                         'Shipments.shipped' => 0,
                     ],
                 ],
                 [
                     'table' => 'locations',
                     'alias' => 'Location',
                     'type' => 'RIGHT',
                     'conditions' => [
                         '( 	Pallets.location_id = Locations.id AND
                             Pallets.location_id <> 0 AND
                             Pallets.inventory_status_id <> 2 AND
                             Pallets.picked <> true ) AND
                         (
                             ( Pallets.shipment_id = 0 ) OR
                             ( Pallets.shipment_id <> 0 AND Shipments.shipped IS NOT NULL))',
                     ],
                 ],
             ],
             'order' => [
                 'Locations.location' => 'ASC',
             ],
             'group' => [
                 'Locations.id',
             ],
         ];

         $having = [
             'having' => [
                 'Locations.pallet_capacity > COUNT(Pallets.id)',
             ],
         ];

         if ($productTypeId !== 'all') {
             $options['conditions'] = [
                 'Locations.product_type_id' => $productTypeId,
             ];
         }

         if ($filter === 'available') {
             $options += $having;
         }
         if ($extraOptions) {
             $options += $extraOptions;
         }

         return $options; */

        $query = $this->find();

        $query->join(
            [
                'S' => [
                    'table' => 'shipments',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Pallets.shipment_id = S.id',
                        'S.shipped' => 0,
                    ],
                ],
                'L' => [
                    'table' => 'locations',
                    'type' => 'RIGHT',
                    'conditions' => [
                        '( 	Pallets.location_id = L.id AND
                        Pallets.location_id <> 0 AND
                        Pallets.inventory_status_id <> 2 AND
                        Pallets.picked <> true ) AND
                    (
                        ( Pallets.shipment_id = 0 ) OR
                        ( Pallets.shipment_id <> 0 AND S.shipped IS NOT NULL))',
                    ],
                ],
            ]
        );

        $query->select([
            'Pallet__Pallets' => 'COUNT(Pallets.id)',
            'Pallet__hasSpace' => 'COUNT(Pallets.id) < L.pallet_capacity',
            'Pallet__LocationId' => 'L.id',
            'Pallet__pallet_capacity' => 'L.pallet_capacity',
            'Pallet__Location' => 'L.location',
        ])->group(
            [
                'L.id',
            ]
        )->orderAsc('L.location');

        if ($filter === 'available') {
            $query->having([
                'L.pallet_capacity > COUNT(Pallets.id)',
            ]);
        }

        if (is_numeric($productTypeId)) {
            $query->where([
                'L.product_type_id' => $productTypeId,
            ]);
        }
        $this->log(print_r(get_defined_vars(), true));
        return $query;
    }

    /**
     * @param array $queryDate from shift Report form
     *
     * @return array
     */
    public function shiftReport($queryDate = null)
    {
        $shift_model = TableRegistry::getTableLocator()->get('Shifts');

        $shifts = $shift_model->find('all', [
            'conditions' => [
                'active' => 1,
                'for_prod_dt' => 0,
            ], ]);

        $reports = [];
        $xml_shift_report = [];
        $ctr = 0;

        //$this->log(print_r($shifts->toArray(), true));

        foreach ($shifts as $shift) {
            $start_time = $shift['start_time'];
            $minutes = $shift['shift_minutes'];

            $start_date_time = $queryDate . ' ' . $start_time;

            $end_date_time = $this->addMinutesToDateTime($start_date_time, $minutes);

            $stop_time = $shift->stop_time;

            $productTypeId = $shift->product_type_id;

            $shift_report = $this->getShiftReport(
                $queryDate,
                $start_date_time,
                $end_date_time,
                $productTypeId,
                $shift
            );

            $cartons_report = $this->getCartonsBetweenDateTimes($start_date_time, $end_date_time, $productTypeId);
            //$cartons_report = [];

            $reports[$ctr] = $shift_report;
            $reports[$ctr]['Cartons'] = $cartons_report;
            $reports[$ctr]['@shift_name'] = $shift['Shift']['name'];
            $reports[$ctr]['@start_time'] = $start_time;
            $reports[$ctr]['@stop_time'] = $stop_time;
            $reports[$ctr]['@start_date_time'] = $start_date_time;
            $reports[$ctr]['@end_date_time'] = $end_date_time;

            $xml_shift_report = array_merge(
                $xml_shift_report,
                $shift_report['report']
            );

            // $this-> log(['ctr' => $ctr, 'reports' => $reports]);

            $ctr++;
        }

        return [
            'reports' => $reports,
            'xml_shift_report' => $xml_shift_report,
        ];
    }

    /**
     * @param string $date Date
     * @param string $start_date_time Start Date Time
     * @param string $end_date_time End Date Time
     * @param int $productTypeId Product Type ID
     * @param array $shift Shift array
     * @return array
     */
    public function getShiftReport(
        $date,
        $start_date_time,
        $end_date_time,
        $productTypeId,
        $shift
    ) {
        $options = [
            'contain' => [
                'Items',
                'Cartons',
            ],
            'fields' => [
                'Pallets.production_line',
                'Pallets.created',
                'Pallets.id',
                'Pallets.item',
                'Pallets.description',
                'Pallets.qty',
                'Items.quantity',
            ],
            'order' => [
                'Pallets.production_line',
                'Pallets.created',
            ],
            'conditions' => [
                'Pallets.created >= "' . $start_date_time . '"',
                'Pallets.created <= "' . $end_date_time . '"',
                'Pallets.product_type_id' => $productTypeId,
                'Pallets.qty !=' => 0,
            ],
        ];

        $pallets = $this->find('all', $options);

        $pallets = $pallets->toArray();

        $report = [];
        $record_num = 0;
        $changed_product = true;
        $total = 0;
        $next_pallet = false;
        $current_item = '';
        $array_keys = array_keys($pallets);

        $last = end($array_keys);
        $this->log(print_r($pallets, true));

        foreach ($pallets as $key => $pallet) {
            $line = $pallet['production_line'];
            $item = $pallet['item'];

            if ($current_item !== $line . $item) {
                $changed_product = true;
                $record_num++;
                $index = $key - 1;
                if (isset($pallets[$index])) {
                    $report[$record_num - 1]['last_pallet'] = $pallets[$index]['Pallet']['created'];

                    $report[$record_num - 1]['run_time'] = $this->getDateTimeDiff($report[$record_num - 1]['first_pallet'], $report[$record_num - 1]['last_pallet']);

                    $report[$record_num - 1]['pallets'] = $this->palletsDotCartons(
                        $report[$record_num - 1]['carton_total'],
                        $report[$record_num - 1]['standard_pl_qty']
                    );
                }

                $current_item = $line . $item;
            }
            if ($changed_product) {
                $report[$record_num]['report_date'] = $date;
                $report[$record_num]['shift_id'] = $shift['Shift']['id'];
                $report[$record_num]['shift'] = $shift['Shift']['name'];
                $report[$record_num]['standard_pl_qty'] = $pallet['items']['quantity'];
                $report[$record_num]['production_line'] = $pallet['production_line'];
                $report[$record_num]['item'] = $pallet['item'];
                $report[$record_num]['description'] = $pallet['description'];
                $report[$record_num]['first_pallet'] = $pallet['created'];
                $report[$record_num]['carton_total'] = $pallet['qty'];
                $changed_product = false;
            } else {
                $report[$record_num]['carton_total'] += $pallet['qty'];
            }

            if ($key === $last) {
                $report[$record_num]['last_pallet'] = $pallet['created'];

                $report[$record_num]['run_time'] = $this->getDateTimeDiff($report[$record_num]['first_pallet'], $report[$record_num]['last_pallet']);

                $report[$record_num]['pallets'] = $this->palletsDotCartons(
                    $report[$record_num]['carton_total'],
                    $report[$record_num]['standard_pl_qty']
                );
            }
        }

        return ['report' => $report, 'shift' => $shift];
    }

    /**
     * This returns a if given a carton count it will divide the
     * carton count by the quantity per pallet to get cartons
     * and then also get the left over
     * e.g.
     * given 100 cartons and a qty_per_pallet of 40
     * returns 2.20
     *
     * @param int $cartons Count of cartons
     * @param int $qty_per_pallet the quantity per pallet for that item
     *
     * @return mixed
     */
    public function palletsDotCartons($cartons, $qty_per_pallet)
    {
        $pallets = $cartons / $qty_per_pallet;

        $mod = $cartons % $qty_per_pallet;
        if ($mod !== 0) {
            $pallets = intval($pallets) . '.' . $mod;
        }

        return $pallets;
    }

    /**
     * @param null $startDateTime Start Datetime
     * @param null $endDateTime End Datetime
     * @param int $productTypeId Product Type ID
     * @return array
     */
    public function getCartonsBetweenDateTimes($startDateTime = null, $endDateTime = null, $productTypeId = null)
    {
        $query = $this->find();

        $matchingPallets = $query->select(
            [
                'Pallets.id',
                'ProductionLines.name',
                'Pallets.item_id',
                'Pallets.description',
                'Pallets.item',
                'Pallets.qty_modified',
                'Pallets.qty',
                'Pallets.qty_previous',
                'Items.code',
                'Pallets.pl_ref',
                'Pallets.bb_date',
                'Pallets.print_date',
                'Locations.location',
                'Shipments.shipper',
                'Shipments.shipped',
                'Items.quantity',
                'cartonRecordCount' => $query->func()->count('c.id'),
            ]
        )
        ->join(
            [
                'c' => [
                    'table' => 'cartons',
                    'type' => 'LEFT',
                    'conditions' => [
                        'c.pallet_id = Pallets.id',
                    ],
                ],
            ],
        )->contain([
            'Items',
            'Shipments',
            'Locations',
            'ProductionLines',
        ])->where([
            'AND' => [
                'Pallets.product_type_id' => $productTypeId,
                'OR' => [
                    'Shipments.shipped IS NULL',
                    'Shipments.shipped' => 0,
                ],
                'OR' => [
                    [
                        'Pallets.print_date >=' => $startDateTime,
                        'Pallets.print_date <=' => $endDateTime,
                    ],
                    [
                        'Pallets.qty_modified >=' => $startDateTime,
                        'Pallets.qty_modified <=' => $endDateTime,
                    ],
                ],
            ],
        ])->having([
            'OR' => [
                'cartonRecordCount > 1',
                'Items.quantity <> Pallets.qty',
            ],
        ])->group([
            'Pallets.id',
        ], );

        $palletIds = $this->find()->select(['id' => 'Pallets__id'])->from(['sub' => $matchingPallets]);
        $cartons = $this->Cartons->find()->contain([
            'Pallets' => [
                'Items',
                'ProductionLines',
            ],
        ])->where(
            ['pallet_id IN' => $palletIds]
        );
        return $cartons->toArray();
    }

    /**
     * @param array $passed_args args as array
     *
     *
     * @return mixed
     */
    public function formatLookupActionConditions($passed_args = [])
    {
        $options = [];

        foreach ($this->_stripBlankValues($passed_args) as $arg_key => $args) {
            // only interested in Lookup.xxx not page=2 etc
            if (strpos($arg_key, 'Lookup_') !== false) {
                $search_value = str_replace('Lookup_', '', $arg_key);
                switch ($search_value) {
                    case 'item_id_select':
                        $options[] = ['Pallets.item' => $args];
                        break;
                    case 'print_date':
                        $options[] = [$search_value . ' LIKE ' => $args . '%'];
                        break;
                    default:
                        $options[] = [$search_value => $args];
                        break;
                }
            }
        }

        return $options;
    }

    /**
     * @param array $data $this->data array
     * @return array
     */
    protected function _stripBlankValues($data)
    {
        return Hash::filter($data);
    }

    /**
     * @param array $passed_args passed from Pallets/lookup view / action
     * @return mixed
     */
    public function formatLookupRequestData($passed_args = [])
    {
        $data_array = [];
        foreach ($this->_stripBlankValues($passed_args) as $arg_key => $args) {
            if (strpos($arg_key, 'Lookup_') !== false) {
                //Lookup_bb_date
                $search_value = str_replace('Lookup_', '', $arg_key);
                $data_array['Lookup'][$search_value] = $args;
            }
        }

        return $data_array;
    }

    /**
     * @param string $term Snippet of batch no. to search for
     * @return mixed
     */
    public function batchLookup($term)
    {
        $options = [
            'fields' => [
                'DISTINCT(Pallet.batch) as batch',
                'Pallet.print_date',
            ],
            'conditions' => [
                'Pallet.batch LIKE' => '%' . $term . '%',
            ],
            'group' => [
                'Pallet.batch',
            ],
            'recursive' => -1,
        ];

        $query = $this->find();

        $batches = $query->distinct(['batch'])->select(['batch', 'print_date'])
            ->where(['batch LIKE' => '%' . $term . '%'])->toArray();
        // $this->log(print_r($batches, true));
        $batches = Hash::map($batches, '{n}', [$this, 'formatBatch']);

        return $batches;
    }

    /**
     * @param array $data $this->data
     * @return array
     */
    public function formatBatch($data)
    {
        $date = Date::parse($data['print_date']);
        return [
            'value' => $data['batch'],
            'label' => $data['batch'] . ' - ' . $date->format('D d/m/Y'),
        ];
    }

    /**
     * @param string $term snippet of pallet reference from any part of pl_ref
     * @return mixed
     */
    public function palletReferenceLookup($term)
    {
        $cond = ['Pallets.pl_ref LIKE' => '%' . $term . '%'];

        $options = [
            'conditions' => [
                'Pallets.pl_ref IS NOT NULL',
                'Pallets.pl_ref !=' => '',
                $cond,
            ],
            'order' => [
                'Pallets.pl_ref' => 'ASC',
            ],
        ];
        $pl_ref = $this->find('all', $options)->toArray();

        $this->log(print_r($pl_ref, true));

        $pl_refs = Hash::map($pl_ref, '{n}', [$this, 'formatLookup']);

        return $pl_refs;
    }

    /**
     * Format for a Javascript control somewhere
     * @param array $pl_data Pallet Data array
     * @return array
     */
    public function formatLookup($pl_data)
    {
        return [
            'label' => $pl_data['code_desc'],
            'value' => $pl_data['pl_ref'],
        ];
    }

    /**
     * @param array $filter ?
     * @param int $productTypeId Product Type ID
     * @return mixed
     */
    public function getAvailableLocations($filter, $productTypeId)
    {
        $query = $this->locationSpaceUsageOptions($filter, $productTypeId);

        $available = $query->toArray();
        $this->log('Available: ' . print_r($available, true));
        $availableLocations = Hash::combine($available, '{n}.Pallet.LocationId', '{n}.Pallet.Location', $groupPath = null);

        return $availableLocations;
    }

    /**
     * @param array $contain the contain options [ Model => [ Model2 ]]
     * @return mixed
     */
    public function getViewOptions($contain = [])
    {
        $view_perms = $this->getViewPermNumber('view_in_stock');

        $options = [
            'conditions' => [
                'OR' => [
                    // not shipped
                    'Shipments.shipped' => 0,
                    'Pallets.shipment_id' => 0,
                ],
                'NOT' => [
                    // must have a location i.e. its been put-away
                    'Pallets.location_id' => 0,
                ],
                'AND' => [
                    'OR' => [
                        'InventoryStatuses.perms & ' . $view_perms,
                        'InventoryStatuses.id IS NULL',
                    ],
                ],
            ],
            /*     'order' => [
                // sort qad code
                'Pallets.item' => 'ASC',
                // oldest first
                'Pallets.pl_ref' => 'ASC',
            ],*/
            'contain' => $contain,
        ];

        return $options;
    }

    /**
     * @return mixed
     */
    public function getFilterValues()
    {
        $options = $this->getViewOptions($contain = ['Shipments', 'InventoryStatuses']);

        $options['fields'] = [
            'Pallets.item_id',
            'item_code_desc' => 'CONCAT(Pallets.item, " - ",  Pallets.description, " (", COUNT(Pallets.item_id), ")")',
        ];
        $options['group'] = [
            'Pallets.item_id',
        ];

        $options['keyField'] = 'item_id';
        $options['valueField'] = 'item_code_desc';

        $item_codes_list = $this->find('list', $options)->toArray();

        // creates this array
        // [58510] => 58510 - HOMEBRAND SPD 4KG
        // [58549] => 58549 - WOW SELECT OLIVE 500G
        // [60002] => 60002 - HA CANOLA OIL 20L
        // [60004] => 60004 - HA COTTON OIL 20L
        // add the oil and marg search prefixes

        $productTypes = $this->Items->ProductTypes->find(
            'list',
            [
                'conditions' => [
                    'ProductTypes.active' => 1,
                ],
                'recursive' => -1,
            ]
        );

        $prependTypes = [];
        foreach ($productTypes as $key => $pt) {
            $prependTypes['product-type-' . $key] = $pt;
        }

        $prepend = $prependTypes + ['low_dated' => 'Low Dated'];

        // the above add the 5 and 6 to end of array so use
        // ksort to sort to
        // [5] => Marg
        // [6] => Oil
        // [5xxxx] ...
        // [6xxxx] ...
        //ksort($item_codes, SORT_REGULAR);

        return $prepend + $item_codes_list;
    }

    /**
     * getViewPermNumber returns the perm number when given the text
     * make globally available to all models
     * @param array $perm Perm
     * @return mixed
     */
    public function getViewPermNumber($perm = null)
    {
        $perms = Configure::read('StockViewPerms');
        $key = array_search($perm, array_column($perms, 'slug'));

        return $perms[$key]['value'];
    }

    /**
    * @param array $pallets array of pallets from ->find call
    *
    * @return mixed
    */
    public function getDontShipCount($pallets = [])
    {
        $dont_ship_count = 0;

        foreach ($pallets as $pallet) {
            if ($pallet['dont_ship']) {
                $dont_ship_count++;
            }
        }

        return $dont_ship_count;
    }

    /**
     * @param int $id ProductType ID
     * @return mixed
     */
    public function getProductType($palletId)
    {
        $options = [
            'conditions' => [
                'P.id' => $palletId,
            ],
            'join' => [
                'I' => [
                    'table' => 'items',
                    'type' => 'INNER',
                    'conditions' => [
                        'I.product_type_id = ProductTypes.id',
                    ],
                ],
                'P' => [
                    'table' => 'pallets',
                    'type' => 'INNER',
                    'conditions' => [
                        'P.item_id = I.id',
                    ],
                ],
            ],
        ];

        $product_type = $this->Items->ProductTypes->find('all', $options)->first()->toArray();

        return $product_type;
    }

    /**
    * @throws CakeException
    * @param bool $created set to true if new DB record created
    * @param array $options Options array
    * @return void
    * Cake\ORM\Table::afterSave(Event $event, EntityInterface $entity, ArrayObject $options)¶
    */
    public function afterSave(Event $event, EntityInterface $entity, $options = [])
    {
        $isNew = $entity->isNew();

        // pallet table fields are keys, carton table fields are values
        $fields = [
            'qty' => 'count',
            'print_date' => 'production_date',
            'bb_date' => 'best_before',
            'id' => 'pallet_id',
        ];

        if ($isNew) {
            $cartonRecord = [];
            foreach ($fields as $palletField => $cartonField) {
                $cartonRecord[$cartonField] = $entity->get($palletField);
            }

            /*  $cartonQty = $this->data[$this->alias]['qty'];
             $productionDate = $this->data[$this->alias]['print_date'];
             $bb_date = $this->data[$this->alias]['bb_date'];

             $formattedDate = $this->formatLabelDates(
                 strtotime($productionDate),
                 [
                     'production_date' => 'Y-m-d',
                 ]
             ); */

            $carton = $this->Cartons->newEntity($cartonRecord);

            if (!$this->Cartons->save($carton)) {
                throw new Exception('Could not save Carton record in Pallet.php afterSave method');
            }
        }
    }
}