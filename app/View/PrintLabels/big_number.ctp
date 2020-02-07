<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-lg-offset-2 col-lg-8 col-md-8">
            <h3>Big Numbers on a 100 x 200 Label</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-lg-offset-2 col-lg-3 col-md-3">
            <?=
            $this->Form->create(null, [
                'class' => 'form-horizontal',
            ])
            ?>
            <?= $this->Form->input('printerId', [
                'type' => 'hidden',
                'value' => $printerId,
            ]); ?>
            <?= $this->Form->input('printer', [
                'type' => 'hidden',

                'value' => $printer,
            ]); ?>
            <?php
            for ($i = 1; $i <= 99; $i++) {
                $options_a[$i] = $i;
            }
            ?>
            <?=
            $this->Form->input('number', [
                'label' => [
                    'text' => 'The number you want to see on the label',
                ],
                'options' => $options_a,
                'type' => 'select',
            ]);
            ?>
            <?=
            $this->Form->input('quantity', [
                'options' => $options_a,
                'type' => 'select',
                'label' => [
                    'text' => 'Quantity',
                ], ]);
            ?>
            <?=
            $this->Form->button('Send to printer', [
                'class' => 'btn btn-lg btn-primary',
            ]);
            ?>
            <?= $this->Form->end(); ?>
        </div>
        <div class="col-md-3 col-lg-3">
            <?= $this->Html->image('/' . $glabelsRoot . '/' . $exampleImage); ?>
            <small>Example</small>
        </div>
    </div>
</div>