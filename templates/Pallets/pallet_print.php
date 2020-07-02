<?php

use Cake\Utility\Inflector;

$this->Html->script(
    [
        'jquery.cookie',
        'pallet-print',
    ],
    [
        'inline' => false,
        'block' => 'from_view',
    ]
); ?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>

<h5><?php echo __('Select product type'); ?></h5>
<ul class="nav flex-column">
    <?php foreach ($productTypes as $key => $pt) : ?>
        <?php
        $linkActive = (isset($productType) && is_numeric($productType->id) && $productType->id === $key) ? 'active' : ''; ?>
        <li class="nav-item">
            <?php echo $this->Html->link($pt, [
                'action' => 'palletPrint',
                $key,
            ], ['class' => 'nav-link ' . $linkActive]); ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php if (isset($lastPrints) && ! $lastPrints->isEmpty() && $showLabelDownload) : ?>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="car-title"><?php echo __('Download Labels'); ?></h5>
            <p class="card-text"><?php echo __('{0} most recent', $lastPrintsCount); ?></p>
            <ul class="nav flex-column">
                <?php foreach ($lastPrints as $lastPrint) : ?>
                <?php $parts = explode('.', $lastPrint->pallet_label_filename); 
                $ext = end($parts); ?>
                    <?= $this->Html->tag(
                        'li',
                        $this->Html->link(
                            $lastPrint->item . ' - ' . $lastPrint->pl_ref,
                            ['action' => 'sendFile', $lastPrint->id],
                            ['class' => 'nav-link ' . $ext ]
                        ),
                        ['class' => 'nav-item']
                    ); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<div class="col">' . $this->fetch('tb_actions') . '</div>'); ?>
<?php if (!empty($productType)) : ?>
    <div class="row">
        <div class="col">
            <h3>
                <?= __('Print {0} Pallet Labels', Inflector::humanize($productType->name)); ?>
            </h3>
        </div>
    </div>
    <div class="row">
        <?php foreach ($forms  as $key => $palletForm) : ?>
            <?php $formName = $key; ?>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="card mb-4 mb-sm-4 mb-md-0">
                    <div class="card-body">
                        <?php echo $this->Form->create(
                            $palletForm,
                            [
                                'id' => $formName,
                                'class' => 'pallet-print',
                            ]
                        ); ?>
                        <?php echo $this->Form->hidden(
                            $formName . '-refer',
                            [
                                'value' => $refer,
                            ]
                        ); ?>
                        <?php echo $this->Form->hidden(
                            'formName',
                            [
                                'class' => 'formName',
                                'value' => $key,
                            ]
                        ); ?>
                        <?php echo $this->Form->control(
                            $formName . '-item',
                            [
                                'class' => 'item',
                                'empty' => true,
                                'label' => 'Item',
                                'options' => $items,
                                'data-queryurl' => $this->Url->build(['controller' => 'items', 'action' => 'getBatchList']),
                            ]
                        ); ?>
                        <?php echo $this->Form->control(
                            $formName . '-production_line',
                            [
                                'options' => $productionLines,
                                'empty' => true,
                                'label' => 'Production line',
                            ]
                        ); ?>
                        <?php echo $this->Form->hidden($formName . '-productType', ['value' => $productType->id, 'class' => 'productType']); ?>
                        <?php echo $this->Form->control($formName . '-part_pallet-' . $key, [
                            'label' => 'Part Pallet',
                            'type' => 'checkbox',
                            'data-queryurl' => $this->Url->build(['controller' => 'items', 'action' => 'product']),
                        ]); ?>
                        <?php echo $this->Form->control(
                            $formName . '-qty',
                            [
                                'class' => 'qty',
                                'label' => 'Quantity',
                                'type' => 'select',
                                'templates' => [
                                    'inputContainer' => '<div class="form-group tgn-qty {{type}}{{required}}">{{content}}{{help}}</div>',
                                ],
                            ]
                        ); ?>
                        <div class="row">
                            <div class="col">
                                <?php echo $this->Form->control(
                                    $formName . '-batch_no',
                                    [

                                        'label' => 'Batch No.' . $this->Html->tag('span',  'Example <strong>' . $exampleBatchNo . '</strong>', ['class' => 'secondary-text']),
                                        'class' => 'batch',
                                        'escape' => false

                                    ]
                                ); ?>

                            </div>
                        </div>

                        <?php echo $this->Form->button(
                            'Print...',
                            [
                                'class' => 'frm-print print btn btn-primary btn-lg col ' . $key,
                                'type' => 'button',
                                'data-formName' => $formName,
                                'data-toggle' => 'modal',
                                'data-target' => '#dialog',
                            ]
                        ); ?>
                        <?php echo $this->Form->end(); ?>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div> <!-- enn col-lg-6 -->

    <?= $this->element('modals/pallet_print_modal'); ?>
<?php endif; ?>