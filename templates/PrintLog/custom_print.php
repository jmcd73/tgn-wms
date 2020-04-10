<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h3>Custom Label Print</h3>
        </div>
    </div>
    <div class="row">
        <?php foreach ($customPrints as $customPrint): ?>
        <?php $formName = $customPrint['formName']; ?>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <?=
                    $this->Html->image(
                        $customPrint['comment']['image'],
                        [
                            'alt' => $customPrint['comment']['description'],
                            'class' => 'card-img-top mb-3',
                        ]
                    ); ?>

                    <h5 class="text-uppercase"><?=$customPrint['comment']['description']; ?></h5>
                    <?=
                    $this->Form->create(
                        $forms[$formName],
                        [
                            'method' => 'POST',
                            'valueSources' => ['context'],

                            'id' => $formName,
                        ]
                    ); ?>
                    <?= $this->Form->hidden('formName', [
                        'value' => $formName,
                    ]); ?>
                    <?=
                    $this->Form->control(
                        $formName . '.printer',
                        [
                            'options' => $printers['printers'],
                            'default' => $printers['default'] ? $printers['default'] : '',
                            'empty' => '(select printer)',
                        ]
                    ); ?>
                    <?=
                    $this->Form->hidden(
                        $formName . '.name',
                        [
                            'value' => $customPrint['name'],
                        ]
                    );?>
                    <?=$this->Form->hidden($formName . '.id', ['value' => $customPrint['id']]); ?>
                    <?=
                    $this->Form->control(
                        $formName . '.copies',
                        [
                            'label' => 'Enter quantity to print',
                            'id' => 'copies-' . $customPrint['id'],
                        ]
                    ); ?>
                    <?=$this->Form->hidden($formName . '.template', [
                        'value' => $customPrint['comment']['template'], ]); ?>
                    <?=$this->Form->hidden($formName . '.code', [
                        'value' => $customPrint['comment']['code'], ]); ?>
                    <?php if (isset($customPrint['comment']['csv'])): ?>
                    <?php foreach ($customPrint['comment']['csv'] as $key => $csv): ?>
                    <?=$this->Form->hidden(
                            $formName . '.csv.' . $key,
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