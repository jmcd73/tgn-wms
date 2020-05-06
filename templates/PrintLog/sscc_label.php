<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <h3><?=__('Reprint Label'); ?></h3>
            <dl class="row">
                <!-- <dt class="col-sm-3"><?=__('Id'); ?></dt>
                    <dd class="col-sm-9">
                <?=h($pallet['id']); ?>

                    </dd> -->
                <dt class="col-sm-3"><?=__('Item'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['item']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Description'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['description']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Best Before'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['bb_date']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Gtin14'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['gtin14']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Qty'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['qty']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Pl Ref'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['pl_ref']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Sscc'); ?></dt>
                <dd class="col-sm-9">
                    <?= h($pallet['sscc']); ?>
                </dd>
                <dt class="col-sm-3"><?=__('Batch'); ?></dt>
                <dd class="col-sm-9">
                    <?=h($pallet['batch']); ?>

                </dd>
                <dt class="col-sm-3"><?=__('Print Date'); ?></dt>
                <dd class="col-sm-9">
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
            <?= $this->Form->submit('Print'); ?>
            <?=$this->Form->end(); ?>
        </div>
    </div>
</div>