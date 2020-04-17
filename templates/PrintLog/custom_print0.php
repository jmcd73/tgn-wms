<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="row">
    <div class="col">
        <?= $this->Form->create($form); ?>

        <?= $this->Form->control('printer', [
            'options' => $printers['printers'],
            'default' => $printers['default'],
            'empty' => true,
        ]); ?>
        <?= $this->Form->control('copies'); ?>

        <?= $this->Form->submit(); ?>
        <?= $this->Form->end(); ?>
    </div>
    <div class="col">
        <?= $this->element('printImage/card', [
            'name' => $template->details->name,
            'description' => $template->details->description,
            'image' => $template->image,
        ]); ?>
    </div>
</div>