<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h3>Custom Label Print</h3>
        </div>
    </div>
    <div class="row">
        <?php foreach ($customPrints as $key_val => $cust_print): ?>
        <?php $decodedData = $cust_print['decoded']; ?>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <?=
                    $this->Html->image(
                        $decodedData['image'],
                        [
                            'alt' => $decodedData['description'],
                            'class' => 'card-img-top mb-3',
                        ]
                    ); ?>

                    <h5 class="text-uppercase"><?=$decodedData['description']; ?></h5>
                    <?=
                    $this->Form->create(
                        $forms[$cust_print['id']],
                        [
                            'url' => [
                                'controller' => 'PrintLabels',
                                'action' => 'customPrint', ],
                            'id' => 'CustomPrint' . $cust_print['id'],
                        ]
                    ); ?>
                    <?=
                    $this->Form->control(
                        'printer',
                        [
                            'options' => $printers['printers'],
                            'default' => $printers['default'] ? $printers['default'] : '',
                            'empty' => '(select printer)',
                        ]
                    ); ?>
                    <?=
                    $this->Form->hidden(
                        'name',
                        [
                            'value' => $cust_print['name'],
                        ]
                    );?>

                    <?=$this->Form->hidden('id', ['value' => $cust_print['id']]); ?>
                    <?=
                    $this->Form->control(
                        'copies',
                        [
                            'label' => 'Enter quantity to print',
                        ]
                    ); ?>
                    <?=$this->Form->hidden('template', [
                        'value' => $decodedData['template'], ]); ?>
                    <?=$this->Form->hidden('code', [
                        'value' => $decodedData['code'], ]); ?>
                    <?php if (isset($cust_print['decoded']['csv'])): ?>
                    <?php foreach ($cust_print['decoded']['csv'] as $key => $csv): ?>
                    <?=$this->Form->hidden(
                            'csv.' . $key,
                            ['value' => $csv]
                        ); ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?=$this->Form->submit('Print'); ?>
                    <?=$this->Form->end(); ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

</div>