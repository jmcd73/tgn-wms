<?php $this->Html->css(
    [
        'bootstrap-datepicker3.min',
    ],
    [
        'inline' => false,
    ]
);
?>
<?php $this->Html->script(
    [
        'bootstrap-datepicker.min',
        'locales/bootstrap-datepicker.en-AU.min',
        'typeahead.bundle.min',
        'moment-with-locales.min',
        'crossdock-labels',
    ],
    [
        'inline' => false,
        'block' => 'from_view',
    ]
);

$submit_url = $this->Url->build([
    'controller' => 'Shipments',
    'action' => 'destinationLookup',
]);

?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>


    <div class="row">
        <div class="col-md-4">
            <?= $this->Form->create($form);?>
            <?= $this->Form->control('sending_co', [
                'id' => 'sending_co',
                'type' => 'hidden',
                'value' => $companyName,
            ]);?>

            <?= $this->Form->control('printer', [
                'type' => 'radio',
                'legend' => false,
                'label' => 'Printer',
                'inline' => true,
                'options' => $printers['printers'],
                'default' => $printers['default'] ? $printers['default'] : '',
            ]) ?>

            <?= $this->Form->control('purchase_order', [
                'placeholder' => 'PO Number Here',
                'maxLength' => 20,
                'size' => 20,
            ]); ?>
            <?= $this->Form->control('address', [
                'id' => 'address',
                'label' => 'Send To',
                'data-submit_url' => $submit_url,
                'placeholder' => 'Enter send to',
                'templates' => [
                    'inputContainer' => '<div class="form-group mb-0 {{type}}{{required}}">{{content}}{{help}}</div>',
                ],
            ]); ?>
            <p><strong>Example:</strong> Woolworths, Laverton Nth</p>
            <?= $this->Form->control('booked_date', [
                'id' => 'booked_date',
                'label' => 'Booking Date',
                'placeholder' => 'Enter booking date',
                'maxlength' => 48,
                'size' => 48,
            ]); ?>

            <?= $this->Form->control('sequence-start', [
                'id' => 'sequence-start',
                'label' => 'Start',
                'options' => $sequence,
            ]); ?>
            <?= $this->Form->control('sequence-end', [
                'id' => 'sequence-end',
                'label' => 'End',
                'options' => $sequence,
                'empty' => '(select end)',
            ]); ?>
            <?=$this->Form->control('copies', [
                'options' => [1 => 'One', 2 => 'Two'],
                'legend' => false,
                'label' => 'Copies',
                'type' => 'radio',
                'default' => 1,
                'inline' => true,
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
</div>
