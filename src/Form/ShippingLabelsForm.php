<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * ShippingLabels Form.
 */
class ShippingLabelsForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        /*
        printer
copies
sequence-start
sequence-end
state
address
reference
*/
        return $schema->addField('printer', 'string')
        ->addField('copies', 'string')
        ->addField('sequence-start', 'string')
        ->addField('sequence-end', 'string')
        ->addField('state', 'string')
        ->addField('address', 'string')
        ->addField('reference', 'string');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator):Validator
    {
        $validator->notBlank('printer', 'Please select a printer')
        ->notBlank('copies', 'Please specify the copies to print')
        ->notBlank('sequence-start', 'Please specify a start number')
        ->notBlank('sequence-end', 'Please enter the end number')
        ->notBlank('state', 'Please enter a state')->allowEmpty('state')
        ->notBlank('reference', 'Please enter a reference')->allowEmpty('reference')
        ->notBlank('address', 'Please enter an address')->allowEmpty('address');

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