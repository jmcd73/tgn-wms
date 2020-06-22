<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <h3><?=__('Reprint Label'); ?></h3>
            <dl class="row">
                <dt class="col-sm-4"><?=__('Item'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['item']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Description'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['description']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Best Before'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['bb_date']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Gtin14'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['gtin14']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Qty'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['qty']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Pl Ref'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['pl_ref']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Sscc'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['sscc']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Batch'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['batch']); ?>
                </dd>
                <dt class="col-sm-4"><?=__('Print Date'); ?></dt>
                <dd class="col-sm-8">
                    <?=h($pallet['print_date']); ?>
                </dd>
            </dl>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6">
            <?=$this->Form->create($pallet); ?>
            <?=$this->Form->hidden('id') ?>
            <h4 class="tpad">Printer</h4>
            <?=
            $this->Form->control(
                'printer_id',
                [
                    'type' => 'radio',
                    'default' => $printers['default'] ? $printers['default'] : '',
                    'options' => $printers['printers'],
                    'legend' => false,
                ]
            ); ?>
            <h4 class="tpad">Label Copies</h4>
            <?=
            $this->Form->control(
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
            <?php echo $this->Form->submit('Reprint'); ?>

            <?=$this->Form->end(); ?>
        </div>
    </div>
</div>