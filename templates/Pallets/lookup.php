<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->Html->css([
    'bootstrap-datepicker3.min',
], ['inline' => false]); ?>
<?php $this->Html->script(
    [
        'bootstrap-datepicker.min',
        'locales/bootstrap-datepicker.en-AU.min',
        'typeahead.bundle.min',
        'edit-modal',
        'lookup',
    ],
    [
        'inline' => false,
        'block' => 'from_view',
    ]
); ?>



<!-- start sidebar -->
<?php $this->start('tb_actions'); ?>
<h4><?php echo __('Search'); ?></h4>
<?php echo $this->Form->create(
    $searchForm,
    [
        'valueSources' => ['query', 'context'],
        'class' => 'mb-2',
        'id' => 'searchForm',
        'url' => [
            'controller' => 'Pallets',
            'action' => 'lookupSearch',
        ],
    ]
); ?>

<?php
echo $this->Form->control(
    'item_id_select',
    [
        'label' => false,
        'inline' => true,
        'placeholder' => 'Item Code',
        'data-submit_url' => $this->Url->build([
            'controller' => $this->request->getParam('controller'),
            'action' => 'itemLookup',
        ]),
        'type' => 'text',
        'id' => 'item_id_select',
        'empty' => true,
    ]
);
//echo $this->Form->hidden('Skip.item_id', ['id' => 'item_id']);

echo $this->Form->control(
    'bb_date',
    [
        'label' => 'Best Before',
        'type' => 'date',
        'placeholder' => 'Best Before',
        'id' => 'bb_date',
    ]
);

echo $this->Form->control(
    'pl_ref',
    [
        'id' => 'pl_ref',
        'label' => false,
        'data-submit_url' => $this->Url->build([
            'controller' => $this->request->getParam('controller'),
            'action' => 'palletReferenceLookup',
        ]),
        'type' => 'text',
        'empty' => true,
        'class' => 'typeahead form-control',
        'placeholder' => 'Pallet Ref.',
        'div' => [
            'class' => 'form-group col-md-j8',
        ],
    ]
);

echo $this->Form->control(
    'batch',
    [
        'id' => 'batch',
        'data-submit_url' => $this->Url->build([
            'controller' => $this->request->getParam('controller'),
            'action' => 'batchLookup',
        ]),
        'type' => 'text',
        'label' => false,
        'empty' => true,
        'placeholder' => 'Batch No.',
    ]
);
echo $this->Form->control(
    'inventory_status_id',
    [
        'type' => 'select',
        'options' => $statuses,
        'empty' => '(Status)',
        'label' => false,
    ]
);
echo $this->Form->control(
    'production_date',
    [
        'id' => 'production_date',
        'class' => 'mb-3',
        'label' => "Production Date",
        'placeholder' => 'Manuf. Date',
    ]
);
echo $this->Form->control(
    'location_id',
    [
        'type' => 'select',
        'options' => $locations,
        'empty' => '(Location)',
        'label' => false,
        'placeholder' => 'Location',
    ]
);
echo $this->Form->control(
    'shipment_id',
    [
        'type' => 'select',
        'class' => 'form-control',
        'options' => $shipments,
        'empty' => '(Shipment)',
        'label' => false,
    ]
);
?>

<?php echo $this->Form->submit('Search'); ?>

<?php
echo $this->Form->button('Reset', [
    'class' => 'mt-3 btn btn-secondary',
    'type' => 'reset',
    'id' => 'resetButton',
    'label' => false,
]);
echo $this->Form->end();
?>


<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<div class="col">' . $this->fetch('tb_actions') . '</div>'); ?>

<!-- end sidebar -->
<div class="row">
    <div class="col">
        <h3>
            <?= __('Search Results'); ?>
            <?= $this->Html->badge($this->Paginator->counter('{{count}}')); ?>
        </h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('description'); ?></th>
                    <th><?php echo $this->Paginator->sort('production_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('bb_date', 'Best Before'); ?></th>
                    <th><?php echo $this->Paginator->sort('qty'); ?></th>
                    <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                    <th><?php echo $this->Paginator->sort('batch'); ?></th>
                    <th><?php echo $this->Paginator->sort('inventory_status_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('location_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('shipment_id'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pallets) : ?>

                    <?php foreach ($pallets as $pallet) : ?>
                        <tr <?php
                            if ($pallet['dont_ship']) {
                                echo 'class="lowdate"';
                            }
                            ?>>

                            <td><?php echo h($pallet['item']); ?></td>
                            <td><?php echo h($pallet['description']); ?></td>
                            <td><?php echo h($pallet['production_date']->i18nFormat(null, $user->timezone)); ?></td>
                            <td><?php echo h($pallet['bb_date']->i18nFormat(null, $user->timezone)); ?></td>
                            <td><?php echo h($pallet['qty']); ?></td>
                            <td><?php echo h($pallet['pl_ref']); ?></td>
                            <td><?php echo h($pallet['batch']); ?></td>
                            <td><?= $pallet->has('inventory_status') ? h($pallet->inventory_status->name) : ''; ?></td>
                            <td><?= $pallet->has('location') ? h($pallet->location->location) : ''; ?></td>
                            <td><?= $pallet->has('shipment') ?
                                    $this->Html->link(
                                        h($pallet->shipment->shipper),
                                        [
                                            'controller' => 'shipments',
                                            'action' => 'view',
                                            $pallet->shipment->id,
                                        ]
                                    ) : '';
                                ?></td>
                            <td class="actions">
                            <?= $this->Html->link(
                                    __('Edit'),
                                    [
                                        'controller' => 'Pallets', 'action' => 'modifyPallet', $pallet['id']
                                    ],
                                    [   'title' => 'Edit status, batch, quantity, cartons, dates',
                                        'class' => 'btn edit btn-sm mb-1 btn-warning']
                                ); ?>
                                <?= $this->Html->link(
                                    __('Label'),
                                    [
                                        'controller' => 'Pallets', 'action' => 'sendFile', $pallet['id'], '?' => [
                                            'download' => 0
                                        ]
                                    ],
                                    [
                                        'title' => "Click to download a pallet label",
                                        'target' => '_blank',
                                        'class' => 'btn label btn-sm mb-1 btn-secondary'
                                    ]
                                ); ?>
                              
                                <?php echo $this->Html->link(__('View'), ['action' => 'view', $pallet['id']], ['class' => 'btn btn-info btn-sm mb-1 view  mb-1 btn-sm']); ?>
                                <?php echo $this->Html->link(__('Reprint'), ['controller' => 'PrintLog', 'action' => 'palletLabelReprint', $pallet['id']], ['class' => 'btn  mb-1  btn-secondary reprint btn-sm']); ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11">
                            <div class="text-center">
                                <h3><?= __('Clear the search form and try again'); ?></h3>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
        <div class="pagination pagination-large">
            <ul class="pagination">
                <?php
                echo $this->Paginator->first('&laquo; first', ['escape' => false, 'tag' => 'li']);
                echo $this->Paginator->prev('&lsaquo; ' . __('previous'), ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
                echo $this->Paginator->numbers(['separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1, 'ellipsis' => null]);
                echo $this->Paginator->next(__('next') . ' &rsaquo;', ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
                echo $this->Paginator->last('last &raquo;', ['escape' => false, 'tag' => 'li']);
                ?>
            </ul>
        </div>
    </div>
</div>

<?php echo $this->element('modals/pallet_cartons_edit_modal'); ?>