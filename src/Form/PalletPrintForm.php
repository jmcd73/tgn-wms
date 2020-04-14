<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 *
 * @package App\Form
 */
class PalletPrintForm extends Form
{
    protected $formName = '';

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField($this->prependFormName('batch_no'), 'string')
        ->addField($this->prependFormName('item'), 'string')
        ->addField($this->prependFormName('production_line'), 'string');
    }

    public function prependFormName($fieldName) : string
    {
        if (!empty($this->formName)) {
            return $this->formName . '-' . $fieldName;
        }
        return $fieldName;
    }

    /**
     * setFormName
     *
     * Set form name so it can be used to prepend it to all fields
     * @param mixed $formName
     * @return void
     */
    public function setFormName($formName): PalletPrintForm
    {
        if (is_string($formName) && !empty($formName)) {
            $this->formName = $formName;
        }
        return $this;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator):Validator
    {
        $validator
        ->scalar($this->prependFormName('batch_no'), 'Please select a batch')
        ->requirePresence($this->prependFormName('batch_no'), 'Please select a batch')
        ->notEmptyString($this->prependFormName('batch_no'), 'Please select a batch')
        ->scalar($this->prependFormName('item'), 'Please select an Item')
        ->requirePresence($this->prependFormName('item'), 'Please select an Item')
        ->notEmptyString($this->prependFormName('item'), 'Please select an Item')
        ->scalar($this->prependFormName('production_line'), 'Please select a production line')
        ->requirePresence($this->prependFormName('production_line'), 'Please select a production line')
        ->notEmptyString($this->prependFormName('production_line'), 'Please select a production line');

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