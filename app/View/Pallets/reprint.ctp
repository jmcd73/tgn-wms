<div class="container">

    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6">
            <h3><?=__('Reprint Label'); ?></h3>
            <dl class="dl-horizontal">
                    <!-- <dt><?=__('Id'); ?></dt>
                    <dd>
                <?=h($pallet['Pallet']['id']); ?>

                    </dd> -->
                <dt><?=__('Item'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['item']); ?>

                </dd>
                <dt><?=__('Description'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['description']); ?>

                </dd>
                <dt><?=__('Best Before'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['best_before']); ?>

                </dd>
                <dt><?=__('Gtin14'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['gtin14']); ?>

                </dd>
                <dt><?=__('Qty'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['qty']); ?>

                </dd>
                <dt><?=__('Pl Ref'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['pl_ref']); ?>

                </dd>
                <dt><?=__('Sscc'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['sscc']); ?>

                </dd>
                <dt><?=__('Batch'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['batch']); ?>

                </dd>
                <dt><?=__('Print Date'); ?></dt>
                <dd>
                    <?=h($pallet['Pallet']['print_date']); ?>

                </dd>

            </dl>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6">
            <?=$this->Form->create('Pallet'); ?>
            <?=$this->Form->hidden('Pallet.id') ?>

            <h4 class="tpad">Printer</h4>

            <?=$this->Form->input(
    'printer_id', [
        'type' => 'radio',
        'default' => $printers['default'] ? $printers['default'] : '',
        'options' => $printers['printers'],
        'legend' => false
    ]
); ?>
             <h4 class="tpad">Label Copies</h4>
            <?=
$this->Form->input(
    'copies', [
        'type' => 'radio',
        'legend' => false,
        'options' => $labelCopiesList,
        'default' => $inputDefaultCopies
    ]);
?>
<?php
    echo $this->Form->input('refer', [
        'type' => 'hidden',
        'value' => $refer
    ]);
?>
            <?=$this->Form->end([
    'label' => 'Reprint',
    'bootstrap-type' => 'primary',
    'bootstrap-size' => 'lg',
    'class' => 'tpad'
]); ?>
        </div>
    </div>
</div>
