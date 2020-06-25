<?php

use Cake\Core\Configure;

?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="row">
    <div class="col-md-6">
        <?= $this->Form->create($form, ['align' => 'horizontal']); ?>
        <span id="error"></span>
        <?= $this->Form->control('printer', [
            'type' => 'radio',
            'inline' => true,
            'label' => 'Printer',
            'legend' => false,
            'options' => $printers['printers'],
            'default' => $printers['default'] ? $printers['default'] : '',
        ]); ?>
        <?= $this->Form->control('copies', [
            'placeholder' => 'Enter a number',
        ]); ?>
        <?= $this->Form->control('companyName', [
            'maxlength' => 48,
            'size' => 48,

            'default' => $companyName,
            'placeholder' => 'Company Name',
        ]); ?>
        <?= $this->Form->control('productName', [
            'maxlength' => 48,
            'size' => 48,

            'placeholder' => 'Product Name',
        ]); ?>
        <?= $this->Form->control('productDescription', [
            'maxlength' => 48,
            'size' => 48,

            'placeholder' => 'Product Description',
        ]); ?>
        <?= $this->Form->control('genericLine1', [
            'label' => 'Line 1',
            'maxlength' => 48,
            'size' => 48,

            'placeholder' => 'Line 1',
        ]); ?>
        <?= $this->Form->control('genericLine2', [
            'label' => 'Line 2',
            'maxlength' => 48,
            'size' => 48,

            'placeholder' => 'Line 2',
        ]); ?>
        <?= $this->Form->control('genericLine3', [
            'label' => 'Line 3',
            'maxlength' => 48,
            'size' => 48,

            'placeholder' => 'Line 3',
        ]); ?>
        <?= $this->Form->control('genericLine4', [
            'label' => 'Line 4',
            'maxlength' => 48,
            'size' => 48,

            'placeholder' => 'Line 4',
        ]); ?>
        <?= $this->Form->submit('Print'); ?>
        <?= $this->Form->end(); ?>
    </div>
    <div class="col-md-4">
        <?= $this->element('printImage/card', [
            'name' => $template->details['name'],
            'description' => $template->details['description'],
            'image' => $template->image,
        ]); ?>

    </div>
</div>