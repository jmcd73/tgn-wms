<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <?=$this->Form->create($shippingLabel, [
                'align' => 'horizontal',
            ]);?>
            <?=$this->Form->control(
                'printer',
                [
                    'legend' => false,
                    'label' => 'Printer',
                    'type' => 'radio',
                    'inline' => true,
                    'id' => 'printer',
                    'options' => $printers['printers'],
                    'default' => $printers['default'] ? $printers['default'] : '',
                ]
            )?>

            <?=$this->Form->control('copies', [
                'options' => [1 => 'One', 2 => 'Two'],
                'legend' => false,
                'label' => 'Copies',
                'type' => 'radio',
                'default' => 1,
                'inline' => true,
            ]);?>

            <?=$this->Form->control('sequence-start', [
                'label' => 'Start',
                'options' => $sequence,
            ]);?>

            <?=$this->Form->control('sequence-end', [
                'label' => 'End',
                'options' => $sequence,
            ]);?>


            <?=$this->Form->control('state', [
                'label' => 'State or Destination',
                'empty' => '(select or enter a custom destination)',
                'placeholder' => 'Enter the state or destination title',
            ]);?>
            <?=$this->Form->control('address', [
                'maxLength' => 48,
                'size' => 48,
                'placeholder' => 'Enter the address',
            ]);?>
            <?=$this->Form->control('reference', [
                'maxLength' => 20,
                'size' => 20,
                'placeholder' => 'SO-M000056',
            ]);?>
            <?= $this->Form->submit('Print');?>
            <?=$this->Form->end();?>
        </div>
        <div class="col-3">
            <?= $this->element('printImage/card', [
                'name' => $template->details['name'],
                'description' => $template->details['description'],
                'image' => $template->image,
            ]); ?>

        </div>
    </div>
</div>
</div>