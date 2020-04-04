<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Label[]|\Cake\Collection\CollectionInterface $labels
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Label'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Production Lines'), ['controller' => 'ProductionLines', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Production Line'), ['controller' => 'ProductionLines', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Printers'), ['controller' => 'Printers', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Printer'), ['controller' => 'Printers', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Shipments'), ['controller' => 'Shipments', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Shipment'), ['controller' => 'Shipments', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['controller' => 'InventoryStatuses', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Inventory Status'), ['controller' => 'InventoryStatuses', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('production_line_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('item') ?></th>
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
        <th scope="col"><?= $this->Paginator->sort('production_line') ?></th>
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
        <?php foreach ($labels as $label) : ?>
        <tr>
            <td><?= $this->Number->format($label->id) ?></td>
            <td><?= $label->has('production_line') ? $this->Html->link($label->production_line->name, ['controller' => 'ProductionLines', 'action' => 'view', $label->production_line->id]) : '' ?></td>
            <td><?= h($label->item) ?></td>
            <td><?= h($label->description) ?></td>
            <td><?= $label->has('item') ? $this->Html->link($label->item->id, ['controller' => 'Items', 'action' => 'view', $label->item->id]) : '' ?></td>
            <td><?= h($label->best_before) ?></td>
            <td><?= h($label->bb_date) ?></td>
            <td><?= h($label->gtin14) ?></td>
            <td><?= $this->Number->format($label->qty_user_id) ?></td>
            <td><?= $this->Number->format($label->qty) ?></td>
            <td><?= h($label->qty_previous) ?></td>
            <td><?= h($label->qty_modified) ?></td>
            <td><?= h($label->pl_ref) ?></td>
            <td><?= h($label->sscc) ?></td>
            <td><?= h($label->batch) ?></td>
            <td><?= $label->has('printer') ? $this->Html->link($label->printer->name, ['controller' => 'Printers', 'action' => 'view', $label->printer->id]) : '' ?></td>
            <td><?= h($label->print_date) ?></td>
            <td><?= h($label->cooldown_date) ?></td>
            <td><?= $this->Number->format($label->min_days_life) ?></td>
            <td><?= h($label->production_line) ?></td>
            <td><?= $label->has('location') ? $this->Html->link($label->location->id, ['controller' => 'Locations', 'action' => 'view', $label->location->id]) : '' ?></td>
            <td><?= $label->has('shipment') ? $this->Html->link($label->shipment->id, ['controller' => 'Shipments', 'action' => 'view', $label->shipment->id]) : '' ?></td>
            <td><?= $label->has('inventory_status') ? $this->Html->link($label->inventory_status->name, ['controller' => 'InventoryStatuses', 'action' => 'view', $label->inventory_status->id]) : '' ?></td>
            <td><?= h($label->inventory_status_note) ?></td>
            <td><?= h($label->inventory_status_datetime) ?></td>
            <td><?= h($label->created) ?></td>
            <td><?= h($label->modified) ?></td>
            <td><?= h($label->ship_low_date) ?></td>
            <td><?= h($label->picked) ?></td>
            <td><?= $label->has('product_type') ? $this->Html->link($label->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $label->product_type->id]) : '' ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $label->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $label->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $label->id], ['confirm' => __('Are you sure you want to delete # {0}?', $label->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
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
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>
