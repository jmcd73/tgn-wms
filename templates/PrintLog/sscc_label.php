<div class="container">

    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6">
            <h3><?=__('Reprint Label'); ?></h3>
            <dl class="dl-horizontal">
                <!-- <dt><?=__('Id'); ?></dt>
                    <dd>
                <?=h($palletRecord['Pallet']['id']); ?>

                    </dd> -->
                <dt><?=__('Item'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['item']); ?>

                </dd>
                <dt><?=__('Description'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['description']); ?>

                </dd>
                <dt><?=__('Best Before'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['best_before']); ?>

                </dd>
                <dt><?=__('Gtin14'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['gtin14']); ?>

                </dd>
                <dt><?=__('Qty'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['qty']); ?>

                </dd>
                <dt><?=__('Pl Ref'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['pl_ref']); ?>

                </dd>
                <dt><?=__('Sscc'); ?></dt>
                <dd>
                    <?=$this->Html->sscc($palletRecord['Pallet']['sscc']); ?>
                </dd>
                <dt><?=__('Batch'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['batch']); ?>

                </dd>
                <dt><?=__('Print Date'); ?></dt>
                <dd>
                    <?=h($palletRecord['Pallet']['print_date']); ?>

                </dd>

            </dl>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6">
            <?=$this->Form->create('Pallet'); ?>
            <?=$this->Form->hidden('Pallet.id') ?>

            <h4 class="tpad">Printer</h4>

            <?=$this->Form->input(
    'printer_id',
    [
        'type' => 'radio',
        'default' => $printers['default'] ? $printers['default'] : '',
        'options' => $printers['printers'],
        'legend' => false,
    ]
); ?>
            <h4 class="tpad">Label Copies</h4>
            <?= $this->Form->input(
    'copies',
    [
        'type' => 'radio',
        'legend' => false,
        'options' => $labelCopiesList,
        'default' => $inputDefaultCopies,
    ]
); ?>
            <?php echo $this->Form->input('refer', [
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