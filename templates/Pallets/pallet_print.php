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

<?php $this->start('tb_actions');?>
<h5><?php echo __('Select product type'); ?></h5>
<ul class="nav flex-column">
    <?php foreach ($productTypes as $key => $pt): ?>
    <?php

        $linkActive = (isset($productType) && is_numeric($productType->id) && $productType->id === $key) ? 'active' : '';  ?>

    <li class="nav-item">
        <?php echo $this->Html->link($pt, [
            'action' => 'palletPrint',
            $key,
        ], ['class' => 'nav-link ' . $linkActive]); ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<div class="col">' . $this->fetch('tb_actions') . '</div>'); ?>
<?php if (empty($productType)): ?>
<p>Select a product type</p>
<?php else: ?>
<div <?= 'class="' . join(' ', [
    'container',
    $this->request->getParam('controller'),
    $this->request->getParam('action'),
]) . '"'; ?>>
    <div class="row">
        <div class="col">
            <h3>

                <?= __('Print {0} Pallet Labels', Inflector::humanize($productType->name)); ?>

                <?= $this->Html->link(
            $this->Html->icon('question-circle', [
                'iconSet' => 'far',
                'prefix' => 'fa',
            ]),
            [
                'controller' => 'pages',
                'action' => 'display',
                'pallet_print_help',
            ],
            [
                'escape' => false,
            ]
        ); ?></h3>
        </div>
    </div>
    <div class="row">
        <?php foreach ($forms  as $key => $palletForm): ?>
        <?php $formName = 'PalletLabel' . Inflector::humanize($key) . 'PalletPrintForm'; ?>
        <div class="col">
            <?php echo $this->Form->create(
    $palletForm,
    [
        'id' => $formName,
        'class' => 'pallet-print',
    ]
); ?>
            <?php echo $this->Form->hidden(
    'refer',
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
            <?php echo $this->Form->control('item', [
                'class' => 'item',
                'empty' => '(select)',
            ]); ?>
            <?php echo $this->Form->control(
                        'production_line',
                        [
                            'options' => $productionLines,
                            'empty' => '(select)',
                        ]
                    ); ?>
            <?php echo $this->Form->hidden('productType', ['value' => $productType->id, 'class' => 'productType']); ?>
            <?php echo $this->Form->control('part_pallet-' . $key, [
                'label' => 'Part Pallet',
                'type' => 'checkbox',
                'data-queryurl' => $this->Url->build(['controller' => 'items', 'action' => 'product']), ]); ?>
            <?php echo $this->Form->control(
                            'qty',
                            [
                                'class' => 'qty',
                                'type' => 'select',
                                'templates' => [
                                    'inputContainer' => '<div class="form-group tgn-qty {{type}}{{required}}">{{content}}{{help}}</div>',
                                ],
                            ]
                        ); ?>
            <?php echo $this->Form->control(
                    'batch_no',
                    [
                        'options' => $batch_nos,
                        'empty' => '(select)',
                    ]
                ); ?>
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
        </div> <!-- enn col-lg-6 -->
        <?php endforeach; ?>
    </div>
</div>

<?= $this->element('pallet_print_modal');?>
<?php endif;?>