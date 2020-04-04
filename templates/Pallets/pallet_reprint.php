<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6">
            <h3><?=__('Reprint Label'); ?></h3>
            <dl class="dl-horizontal">
                <dt><?=__('Item'); ?></dt>
                <dd>
                    <?=h($pallet['item']); ?>
                </dd>
                <dt><?=__('Description'); ?></dt>
                <dd>
                    <?=h($pallet['description']); ?>
                </dd>
                <dt><?=__('Best Before'); ?></dt>
                <dd>
                    <?=h($pallet['best_before']); ?>
                </dd>
                <dt><?=__('Gtin14'); ?></dt>
                <dd>
                    <?=h($pallet['gtin14']); ?>
                </dd>
                <dt><?=__('Qty'); ?></dt>
                <dd>
                    <?=h($pallet['qty']); ?>
                </dd>
                <dt><?=__('Pl Ref'); ?></dt>
                <dd>
                    <?=h($pallet['pl_ref']); ?>
                </dd>
                <dt><?=__('Sscc'); ?></dt>
                <dd>
                    <?=h($pallet['sscc']); ?>
                </dd>
                <dt><?=__('Batch'); ?></dt>
                <dd>
                    <?=h($pallet['batch']); ?>
                </dd>
                <dt><?=__('Print Date'); ?></dt>
                <dd>
                    <?=h($pallet['print_date']); ?>
                </dd>
            </dl>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6">
            <?=$this->Form->create($pallet); ?>
            <?=$this->Form->hidden('Pallet.id') ?>

            <h4 class="tpad">Printer</h4>

            <?=$this->Form->control(
    'printer_id',
    [
        'type' => 'radio',
        'default' => $printers['default'] ? $printers['default'] : '',
        'options' => $printers['printers'],
        'legend' => false,
    ]
); ?>
            <h4 class="tpad">Label Copies</h4>
            <?= $this->Form->control(
    'copies',
    [
        'type' => 'radio',
        'legend' => false,
        'options' => $labelCopiesList,
        'default' => $inputDefaultCopies,
    ]
); ?>
            <?php echo $this->Form->control('refer', [
                'type' => 'hidden',
                'value' => $refer,
            ]); ?>
            <?=$this->Form->end([
                'label' => 'Reprint',
                'bootstrap-type' => 'primary',
                'bootstrap-size' => 'lg',
                'class' => 'tpad',
            ]); ?>
        </div>
    </div>
</div>