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

<div class="container">

    <div class="col-md-8">

        <?= $this->Form->create(null, [
            'horizontal' => true,
        ]);?>
        <?= $this->Form->control('sending_co', [
            'id' => 'sending_co',
            'type' => 'hidden',
            'value' => $companyName,
        ]);?>

        <h4>Crossdock Labels</h4>

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
            'autocomplete' => 'off',
        ]); ?>
        <?= $this->Form->control('address', [
            'id' => 'address',
            'label' => 'Send To',
            'data-submit_url' => $submit_url,
            'placeholder' => 'Enter send to',
        ]); ?>
        <p><strong>Example:</strong> Woolworths, Laverton Nth</p>
        <?= $this->Form->control('booked_date', [
            'id' => 'booked_date',
            'label' => 'Booking Date',
            'placeholder' => 'Enter booking date',
            'maxlength' => 48,
            'size' => 48,
            'autocomplete' => 'off',
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

        <?= $this->Form->end([
            'label' => 'Print',
            'bootstrap-type' => 'primary',
        ]); ?>
    </div>
    <div class="col-md-3">
        <h4>Example</h4>
        <?= $this->Html->image($template->image, ['class' => 'img-responsive']); ?>
    </div>
</div>
</div>