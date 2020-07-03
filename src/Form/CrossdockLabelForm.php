<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * CrossdockLabel Form.
 */
class CrossdockLabelForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addFields([
            'sending_co' => 'string',
            'purchase_order' => 'string',
            'address' => 'address',
            'booked_date' => 'date',
            'sequence-start' => 'integer',
            'sequence-end' => 'integer',
            'copies' => 'integer',
        ]);
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notBlank('purchase_order', 'Please enter a purchase order')
            ->integer('sequence-end')
            ->integer('sequence-start');
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