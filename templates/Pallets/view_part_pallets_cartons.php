<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="pallets container index">

    <h3><?php echo __('Pallets'); ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                <th><?php echo $this->Paginator->sort('description'); ?></th>
                <th><?php echo $this->Paginator->sort('inventory_status_id'); ?></th>
                <th style="padding-left: 0px; padding-right: 0px; padding-top: 0px; padding-bottom: 0px;">
                    <table class="table table-condensed" style="margin-bottom: 0px;">

                        <thead>
                            <tr>
                                <th colspan="3" style="border-bottom: 0px; border-top: 0px;">Cartons</th>
                            </tr>
                            <tr class="small">
                                <th style="border-bottom: 0px;">Prod Date</th>
                                <th style="border-bottom: 0px;">Best Before</th>
                                <th style="border-bottom: 0px;">#</th>
                            </tr>
                        </thead>
                    </table>
                </th>
                <th><?php echo $this->Paginator->sort('qty'); ?></th>
                <th><?php echo $this->Paginator->sort('quantity', 'Full PL Qty'); ?></th>

                <th><?php echo $this->Paginator->sort('print_date'); ?></th>
                <th><?php echo $this->Paginator->sort('bb_date', 'Best before'); ?></th>
                <th><?php echo $this->Paginator->sort('shipment_id'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pallets as $pallet): ?>
            <tr>
                <td><?php echo h($pallet['pl_ref']); ?></td>
                <td><?php echo h($pallet['items']['code']); ?></td>
                <td><?php echo h($pallet['description']); ?></td>
                <td><?= $pallet->has('inventory_status') ? $pallet->inventory_status->name : ''; ?></td>
                <td style="padding-left: 0px; padding-right: 0px; padding-top: 0px; padding-bottom: 0px;">
                    <table class="cartons table small table-striped"
                        style="margin-bottom: 0px; background-color: inherit;">

                        <tbody>
                            <?php foreach ($pallet['cartons'] as $carton):?>
                            <tr>
                                <td><?= h($carton['production_date']); ?></td>
                                <td><?= h($carton['best_before']); ?></td>
                                <td><?= $carton['count']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </td>
                <td>
                    <?php echo h($pallet['qty']); ?>
                </td>
                <td>
                    <?php echo h($pallet['items']['quantity']); ?>
                </td>

                <td><?php echo h($pallet['print_date']); ?></td>
                <td><?php echo h($pallet['bb_date']); ?></td>
                <td><?= $pallet->has('shipment') ? $pallet->shipment->shipper : ''; ?></td>
                <td class="actions">
                    <?=
                    $this->Html->link(
                        __('View'),
                        [
                            'action' => 'view',
                            $pallet['id'],
                        ],
                        [
                            'class' => 'btn btn-link btn-xs view',
                        ]
                    ); ?>
                    <?=
                    $this->Html->link(
                        __('Edit'),
                        [
                            'controller' => 'Cartons',
                            'action' => 'editPalletCartons',
                            $pallet['id'],
                        ],
                        [
                            'class' => 'btn btn-link btn-xs edit',
                        ]
                    ); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <?php echo $this->Paginator->counter(
                        'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}'
                    ); ?>
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