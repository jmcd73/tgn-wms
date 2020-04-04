<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Label $label
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Label'), ['action' => 'edit', $label->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Label'), ['action' => 'delete', $label->id], ['confirm' => __('Are you sure you want to delete # {0}?', $label->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Label'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
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

<div class="labels view large-9 medium-8 columns content">
    <h3><?= h($label->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Production Line') ?></th>
                <td><?= $label->has('production_line') ? $this->Html->link($label->production_line->name, ['controller' => 'ProductionLines', 'action' => 'view', $label->production_line->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Item') ?></th>
                <td><?= h($label->item) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($label->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Item') ?></th>
                <td><?= $label->has('item') ? $this->Html->link($label->item->id, ['controller' => 'Items', 'action' => 'view', $label->item->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Best Before') ?></th>
                <td><?= h($label->best_before) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Gtin14') ?></th>
                <td><?= h($label->gtin14) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty Previous') ?></th>
                <td><?= h($label->qty_previous) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pl Ref') ?></th>
                <td><?= h($label->pl_ref) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sscc') ?></th>
                <td><?= h($label->sscc) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Batch') ?></th>
                <td><?= h($label->batch) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Printer') ?></th>
                <td><?= $label->has('printer') ? $this->Html->link($label->printer->name, ['controller' => 'Printers', 'action' => 'view', $label->printer->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Production Line') ?></th>
                <td><?= h($label->production_line) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Location') ?></th>
                <td><?= $label->has('location') ? $this->Html->link($label->location->id, ['controller' => 'Locations', 'action' => 'view', $label->location->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Shipment') ?></th>
                <td><?= $label->has('shipment') ? $this->Html->link($label->shipment->id, ['controller' => 'Shipments', 'action' => 'view', $label->shipment->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Inventory Status') ?></th>
                <td><?= $label->has('inventory_status') ? $this->Html->link($label->inventory_status->name, ['controller' => 'InventoryStatuses', 'action' => 'view', $label->inventory_status->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Inventory Status Note') ?></th>
                <td><?= h($label->inventory_status_note) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $label->has('product_type') ? $this->Html->link($label->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $label->product_type->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($label->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty User Id') ?></th>
                <td><?= $this->Number->format($label->qty_user_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty') ?></th>
                <td><?= $this->Number->format($label->qty) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Min Days Life') ?></th>
                <td><?= $this->Number->format($label->min_days_life) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Bb Date') ?></th>
                <td><?= h($label->bb_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty Modified') ?></th>
                <td><?= h($label->qty_modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Print Date') ?></th>
                <td><?= h($label->print_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Cooldown Date') ?></th>
                <td><?= h($label->cooldown_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Inventory Status Datetime') ?></th>
                <td><?= h($label->inventory_status_datetime) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($label->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($label->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Ship Low Date') ?></th>
                <td><?= $label->ship_low_date ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Picked') ?></th>
                <td><?= $label->picked ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
</div>
