<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Core\Configure;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * KeepRefrigerated Form.
 */
class KeepRefrigeratedForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param  \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('copies', 'integer')
        ->addField('printer', 'integer');
    }

    /**
     * Form validation builder
     *
     * @param  \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) : Validator
    {
        return $validator->numeric('copies', 'Please enter the number of copies to print')
        ->notEmptyString('copies', 'Please enter the number of copies to print')
        ->numeric('printer', 'Select a printer')
        ->lessThan(
            'copies',
            Configure::read('MAX_COPIES'),
            'Total copies should be less than ' . Configure::read('MAX_COPIES')
        )
        ->notEmptyString('printer', 'Select a printer');
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param  array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }
}