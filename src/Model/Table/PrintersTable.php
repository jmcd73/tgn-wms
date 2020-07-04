<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Http\ServerRequest;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;


/**
 * Printers Model
 *
 * @property \App\Model\Table\LabelsTable&\Cake\ORM\Association\HasMany $Labels
 * @property \App\Model\Table\PalletsTable&\Cake\ORM\Association\HasMany $Pallets
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\HasMany $ProductionLines
 *
 * @method \App\Model\Entity\Printer newEmptyEntity()
 * @method \App\Model\Entity\Printer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Printer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Printer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Printer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Printer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Printer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Printer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Printer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Printer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PrintersTable extends Table
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

        $this->setTable('printers');
        $this->setDisplayField('name');
        $this->addBehavior('TgnUtils');
        $this->setPrimaryKey('id');
       
        $this->hasMany('Pallets', [
            'foreignKey' => 'printer_id',
        ]);
        $this->hasMany('ProductionLines', [
            'foreignKey' => 'printer_id',
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
            ->allowEmptyString('active');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('options')
            ->maxLength('options', 100)
            ->allowEmptyString('options');

        $validator
            ->scalar('queue_name')
            ->maxLength('queue_name', 45)
            ->allowEmptyString('queue_name');

        $validator
            ->allowEmptyString('set_as_default_on_these_actions')
            ->add('set_as_default_on_these_actions', 'checkDups', [
                'rule' => 'checkActionsDups',
                'message' => 'No dups',
                'provider' => 'table'
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
        $rules->addDelete($rules->isNotLinkedTo(
            'ProductionLines', 'production_lines', 
            'Please unlinked printer from production lines before deleting this printer'
        ));
        $rules->addDelete($rules->isNotLinkedTo(
            'Pallets', 'printers', 
            'Printers can not be deleted when they have pallets associated with them'
        ));

        return $rules;
    }

    /**
     * 
     * @param \Cake\Http\ServerRequest $request 
     * @return string 
     */
    public function getCupsURL(ServerRequest $request): string
    {
        $cupsPort = getenv('CUPS_PORT');
        $webDir = getenv('WEB_DIR');


        // if its not in a docker container then
        // return the default port
        $cupsPort = $cupsPort === false ? 631 : $cupsPort;

        // $request->is('ssl') ? 'https' : 'http';
        // scheme must be https to add printers
        $scheme = 'https';
        $host = $request->host();
        $hostPart = explode(':', $host)[0];

        if($hostPart === 'localhost') {
            return sprintf('%s://%s:%s', $scheme, $hostPart, $cupsPort);
        } else {
            return sprintf('%s://%s/%s', $scheme, $host, $webDir . '/cups/');
        }
    }

    /**
     *
     * @param  \Cake\Event\Event                $event   Event
     * @param  \Cake\Datasource\EntityInterface $entity  EntityInterface
     * @param  array                            $options Options array
     * @return void
     * @throws \Cake\Core\Exception
     */
    public function beforeSave(Event $event, EntityInterface $entity, $options = [])
    {
      
    } 

    public function checkActionsDups($value, $context) {
        
        if ($context['newRecord']) {
            $options = [ 1 => 1 ]; 
        } else {
            $options = [ 'NOT' => [ 'id' => $context['data']['id']]];
        }

        $records = $this->find()->where($options)->toArray();
        
        $matches = [];

       
        if(is_array($value)) {
           $compare = $value ;
        } elseif (strlen($value) > 0) {
            $compare = explode("\n", $value);
        } else {
            return true;
        }

        foreach ($records as $record ) {
            if(strlen($record['set_as_default_on_these_actions']) > 0 ) {
                $actions = explode("\n", $record['set_as_default_on_these_actions']);
                $intersect = array_intersect($compare, $actions);
                if(count($intersect) > 0 ) {
                    $matches[] = [ 
                        'printer' => $record['name'],
                        'matches' => $intersect
                    ];
                }
             
            }
         
        }

        if(count($matches) > 0) {
            $msg = 'You need to remove ';
            foreach($matches as $match) {
                    $msg .= join(", ", $match['matches']) . ' from ' . $match['printer'] .'. ';
            }
            $msg .= " to add it as a default on this printer.";
            return $msg;
        }

        return true;
    }
}