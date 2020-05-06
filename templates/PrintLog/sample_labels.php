<?php
    echo $this->Html->script(
    [
        'bootstrap-datepicker.min',
        'samples',
    ],
    ['block' => 'from_view']
);

    $this->Html->css(['bootstrap-datepicker3.min'], ['inline' => false]);
?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">

    <div class="row">
        <div class="col-4">
            <?php echo $this->Form->create($form); ?>
            <?=$this->Form->hidden('code', ['name' => 'code', 'value' => 'sample']);?>
            <?=
            $this->Form->control(
                'printer',
                [
                    'options' => $printers['printers'],
                    'default' => $printers['default'] ? $printers['default'] : '',
                ]
            );?>
            <?=
                $this->Form->control('copies', [
                    'options' => $sequence,
                    'label' => [
                        'text' => 'How many labels?',
                    ],
                ]);?>
            <?php
                echo $this->Form->control('productName', [
                    'label' => [
                        'text' => 'Product Name (24 Characters max)',
                    ],
                    'maxLength' => 24,
                ]);?>
            <?php
                echo $this->Form->control('batch', [
                    'label' => [
                        'text' => 'Batch (' . substr($this->Time->format(time(), '%Y%j'), 3) . 'XX) where XX is batch No. of the day',
                    ],
                    'placeholder' => substr($this->Time->format(time(), '%Y%j'), 3) . 'XX',
                ]);?>
            <?php
                echo $this->Form->control('manufactureDate', [
                    'label' => [
                        'text' => 'Manufacturing Date (dd/mm/yyyy)',
                    ],
                    'class' => 'form-control datepicker',
                    'autocomplete' => 'off',
                    'default' => date('d/m/Y'),
                ]);?>


            <?php
            echo $this->Form->control('bestBefore', [
                'class' => 'form-control datepicker',
                'autocomplete' => 'off',
                'label' => [
                    'text' => 'Best Before Date (dd/mm/yyyy)',
                ],
            ]);?>
            <?php
            echo $this->Form->control('comment', [
                'label' => [
                    'text' => 'Comment (36 Characters max)',
                ],
                'maxLength' => 36,
            ]);?>
            <?= $this->Form->submit('Print', [
                'id' => 'print1',
                'label' => 'Print',
                'bootstrap-type' => 'primary',
                'data-toggle' => 'modal',
                'data-target' => '#samplePrintModal',
            ]); ?>
            <?=$this->Form->end();?>
        </div>
        <div class="col-md-4">

            <?= $this->element('printImage/card', [
                'name' => $template->details['name'],
                'description' => $template->details['description'],
                'image' => $template->image,
            ]); ?>
        </div> <!-- col-md-3 -->
    </div>
</div>

<?= $this->element('modals/sample_label_modal'); ?>