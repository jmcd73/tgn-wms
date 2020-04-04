<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Pallet'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Production Lines'), ['controller' => 'ProductionLines', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Production Line'), ['controller' => 'ProductionLines', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Printers'), ['controller' => 'Printers', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Printer'), ['controller' => 'Printers', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Shipments'), ['controller' => 'Shipments', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Shipment'), ['controller' => 'Shipments', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['controller' => 'InventoryStatuses', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Inventory Status'), ['controller' => 'InventoryStatuses', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Cartons'), ['controller' => 'Cartons', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Carton'), ['controller' => 'Cartons', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('production_line_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('best_before') ?></th>
            <th scope="col"><?= $this->Paginator->sort('bb_date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('gtin14') ?></th>
            <th scope="col"><?= $this->Paginator->sort('qty_user_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('qty') ?></th>
            <th scope="col"><?= $this->Paginator->sort('qty_previous') ?></th>
            <th scope="col"><?= $this->Paginator->sort('qty_modified') ?></th>
            <th scope="col"><?= $this->Paginator->sort('pl_ref') ?></th>
            <th scope="col"><?= $this->Paginator->sort('sscc') ?></th>
            <th scope="col"><?= $this->Paginator->sort('batch') ?></th>
            <th scope="col"><?= $this->Paginator->sort('printer_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('print_date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('cooldown_date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('min_days_life') ?></th>
            <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('shipment_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('inventory_status_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('inventory_status_note') ?></th>
            <th scope="col"><?= $this->Paginator->sort('inventory_status_datetime') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col"><?= $this->Paginator->sort('ship_low_date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('picked') ?></th>
            <th scope="col"><?= $this->Paginator->sort('product_type_id') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pallets as $pallet) : ?>
        <tr>
            <td><?= $this->Number->format($pallet->id) ?></td>
            <td><?= $pallet->has('production_lines') ? $this->Html->link($pallet->production_lines->name, ['controller' => 'ProductionLines', 'action' => 'view', $pallet->production_lines->id]) : '' ?>
            </td>
            <td><?= h($pallet->description) ?></td>
            <td><?= $pallet->has('items') ? $this->Html->link($pallet->items->code, ['controller' => 'Items', 'action' => 'view', $pallet->items->id]) : '' ?>
            </td>
            <td><?= h($pallet->best_before) ?></td>
            <td><?= h($pallet->bb_date) ?></td>
            <td><?= h($pallet->gtin14) ?></td>
            <td><?= $this->Number->format($pallet->qty_user_id) ?></td>
            <td><?= $this->Number->format($pallet->qty) ?></td>
            <td><?= h($pallet->qty_previous) ?></td>
            <td><?= h($pallet->qty_modified) ?></td>
            <td><?= h($pallet->pl_ref) ?></td>
            <td><?= h($pallet->sscc) ?></td>
            <td><?= h($pallet->batch) ?></td>
            <td><?=  $this->Html->link($pallet->printer, ['controller' => 'Printers', 'action' => 'view', $pallet->printer_id]) ?>
            </td>
            <td><?= h($pallet->print_date) ?></td>
            <td><?= h($pallet->cooldown_date) ?></td>
            <td><?= $this->Number->format($pallet->min_days_life) ?></td>
            <td><?= $pallet->has('location') ? $this->Html->link($pallet->location->id, ['controller' => 'Locations', 'action' => 'view', $pallet->location->id]) : '' ?>
            </td>
            <td><?= $pallet->has('shipment') ? $this->Html->link($pallet->shipment->id, ['controller' => 'Shipments', 'action' => 'view', $pallet->shipment->id]) : '' ?>
            </td>
            <td><?= $pallet->has('inventory_status') ? $this->Html->link($pallet->inventory_status->name, ['controller' => 'InventoryStatuses', 'action' => 'view', $pallet->inventory_status->id]) : '' ?>
            </td>
            <td><?= h($pallet->inventory_status_note) ?></td>
            <td><?= h($pallet->inventory_status_datetime) ?></td>
            <td><?= h($pallet->created) ?></td>
            <td><?= h($pallet->modified) ?></td>
            <td><?= h($pallet->ship_low_date) ?></td>
            <td><?= h($pallet->picked) ?></td>
            <td><?= $pallet->has('product_type') ? $this->Html->link($pallet->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $pallet->product_type->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $pallet->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pallet->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pallet->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>