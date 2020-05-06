<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?= $this->Form->create($form); ?>
            <span id="error"></span>

            <?= $this->Form->control('printer', [
                'placeholder' => 'Enter a number',
                'type' => 'radio',
                'inline' => true,
                'label' => 'Printer',
                'legend' => false,
                'options' => $printers['printers'],
                'default' => $printers['default'] ? $printers['default'] : '',
            ]); ?>
            <?= $this->Form->control('copies', [
                'placeholder' => 'Enter a number',
                'class' => 'mb-4',
            ]); ?>

            <?= $this->Form->button('Submit'); ?>
            <?= $this->Form->end(); ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?= $this->element('printImage/card', [
                'name' => $template->details->name,
                'description' => $template->details->description,
                'image' => $template->image,
            ]); ?>
        </div>
    </div>
</div>