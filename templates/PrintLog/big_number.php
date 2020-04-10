<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="container">

    <div class="row">
        <div class="col-4">
            <?=
            $this->Form->create(null)
            ?>
            <?= $this->Form->control('printerId', [
                'type' => 'hidden',
                'value' => $printerId,
            ]); ?>
            <?= $this->Form->control('printer', [
                'type' => 'hidden',

                'value' => $printer,
            ]); ?>
            <?php
            for ($i = 1; $i <= 99; $i++) {
                $options_a[$i] = $i;
            }
            ?>
            <?=
            $this->Form->control('number', [
                'label' => 'The number you want to see on the label',
                'options' => $options_a,
                'type' => 'select',
            ]);
            ?>
            <?=
            $this->Form->control('quantity', [
                'options' => $options_a,
                'type' => 'select',
            ]);
            ?>
            <?=
            $this->Form->button('Send to printer');
            ?>
            <?= $this->Form->end(); ?>
        </div>
        <div class="col">
            <?= $this->element('printImage/card', [
                'name' => $printTemplate['name'],
                'description' => $printTemplate['description'],
                'image' => '/' . $glabelsRoot . '/' . $exampleImage,
            ]); ?>
        </div>
    </div>
</div>