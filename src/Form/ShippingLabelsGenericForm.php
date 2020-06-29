<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * ShippingLabelsGeneric Form.
 */
class ShippingLabelsGenericForm extends Form
{
    protected $maxCopies = 1000;

    public function __construct(?EventManager $eventManager = null)
    {
        parent::__construct($eventManager);

        $this->maxCopies = Configure::read('MAX_COPIES');
    }

    /**
     * Builds the schema for the modelless form
     *
     * @param  \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('copies', 'integer', 'printer');
    }

    /**
     * Form validation builder
     *
     * @param  \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->notEmpty('printer', "Please select a printer")
            ->lessThanOrEqual('copies', $this->maxCopies, 'Copies must be no more than ' . $this->maxCopies);
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