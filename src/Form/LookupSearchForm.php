<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * LookupSearch Form.
 */
class LookupSearchForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        $schema->addFields([
            'item_id_select' => ['type' => 'string'],
            'bb_date' => ['type' => 'date'],
            'pl_ref' => ['type' => 'string'],
            'batch' => ['type' => 'string'],
            'inventory_status_id' => ['type' => 'integer'],
            'print_date' => ['type' => 'date'],
            'location_id' => ['type' => 'integer'],
            'shipment_id' => ['type' => 'integer'],
        ]);
        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return $validator;
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }
}