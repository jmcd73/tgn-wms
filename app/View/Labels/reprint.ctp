<div class="container">

    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6">
            <h3><?=__('Reprint Label'); ?></h3>
            <dl class="dl-horizontal">
                    <!-- <dt><?=__('Id'); ?></dt>
                    <dd>
                <?=h($label['Label']['id']); ?>

                    </dd> -->
                <dt><?=__('Item'); ?></dt>
                <dd>
                    <?=h($label['Label']['item']); ?>

                </dd>
                <dt><?=__('Description'); ?></dt>
                <dd>
                    <?=h($label['Label']['description']); ?>

                </dd>
                <dt><?=__('Best Before'); ?></dt>
                <dd>
                    <?=h($label['Label']['best_before']); ?>

                </dd>
                <dt><?=__('Gtin14'); ?></dt>
                <dd>
                    <?=h($label['Label']['gtin14']); ?>

                </dd>
                <dt><?=__('Qty'); ?></dt>
                <dd>
                    <?=h($label['Label']['qty']); ?>

                </dd>
                <dt><?=__('Pl Ref'); ?></dt>
                <dd>
                    <?=h($label['Label']['pl_ref']); ?>

                </dd>
                <dt><?=__('Sscc'); ?></dt>
                <dd>
                    <?=h($label['Label']['sscc']); ?>

                </dd>
                <dt><?=__('Batch'); ?></dt>
                <dd>
                    <?=h($label['Label']['batch']); ?>

                </dd>
                <dt><?=__('Print Date'); ?></dt>
                <dd>
                    <?=h($label['Label']['print_date']); ?>

                </dd>

            </dl>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6">
            <?=$this->Form->create('Label'); ?>
            <?=$this->Form->hidden('Label.id') ?>

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
