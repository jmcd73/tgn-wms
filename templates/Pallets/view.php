<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pallet $pallet
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Pallet'), ['action' => 'edit', $pallet->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Pallet'), ['action' => 'delete', $pallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pallet->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Pallet'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
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

<div class="pallets view large-9 medium-8 columns content">
    <h3><?= h($pallet->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Production Line') ?></th>
                <td><?= $pallet->has('production_lines') ? $this->Html->link($pallet->production_lines->name, ['controller' => 'ProductionLines', 'action' => 'view', $pallet->production_lines->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Item') ?></th>
                <td><?= h($pallet->item) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($pallet->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Item') ?></th>
                <td><?= $pallet->has('items') ? $this->Html->link($pallet->items->description, ['controller' => 'Items', 'action' => 'view', $pallet->items->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Best Before') ?></th>
                <td><?= h($pallet->best_before) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Gtin14') ?></th>
                <td><?= h($pallet->gtin14) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty Previous') ?></th>
                <td><?= h($pallet->qty_previous) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pl Ref') ?></th>
                <td><?= h($pallet->pl_ref) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sscc') ?></th>
                <td><?= h($pallet->sscc) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Batch') ?></th>
                <td><?= h($pallet->batch) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Printer') ?></th>
                <td><?= h($pallet->printer) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Printer') ?></th>
                <td><?= $pallet->has('printers') ? $this->Html->link($pallet->printers->name, ['controller' => 'Printers', 'action' => 'view', $pallet->printers->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Production Line') ?></th>
                <td><?= h($pallet->production_line) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Location') ?></th>
                <td><?= $pallet->has('location') ? $this->Html->link($pallet->location->id, ['controller' => 'Locations', 'action' => 'view', $pallet->location->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Shipment') ?></th>
                <td><?= $pallet->has('shipment') ? $this->Html->link($pallet->shipment->id, ['controller' => 'Shipments', 'action' => 'view', $pallet->shipment->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Inventory Status') ?></th>
                <td><?= $pallet->has('inventory_status') ? $this->Html->link($pallet->inventory_status->name, ['controller' => 'InventoryStatuses', 'action' => 'view', $pallet->inventory_status->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Inventory Status Note') ?></th>
                <td><?= h($pallet->inventory_status_note) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $pallet->has('product_type') ? $this->Html->link($pallet->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $pallet->product_type->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($pallet->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty User Id') ?></th>
                <td><?= $this->Number->format($pallet->qty_user_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty') ?></th>
                <td><?= $this->Number->format($pallet->qty) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Min Days Life') ?></th>
                <td><?= $this->Number->format($pallet->min_days_life) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Bb Date') ?></th>
                <td><?= h($pallet->bb_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty Modified') ?></th>
                <td><?= h($pallet->qty_modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Print Date') ?></th>
                <td><?= h($pallet->print_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Cooldown Date') ?></th>
                <td><?= h($pallet->cooldown_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Inventory Status Datetime') ?></th>
                <td><?= h($pallet->inventory_status_datetime) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($pallet->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($pallet->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Ship Low Date') ?></th>
                <td><?= $pallet->ship_low_date ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Picked') ?></th>
                <td><?= $pallet->picked ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Cartons') ?></h4>
        <?php if (!empty($pallet->cartons)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Pallet Id') ?></th>
                    <th scope="col"><?= __('Count') ?></th>
                    <th scope="col"><?= __('Best Before') ?></th>
                    <th scope="col"><?= __('Production Date') ?></th>
                    <th scope="col"><?= __('Item Id') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('User Id') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($pallet->cartons as $cartons): ?>
                <tr>
                    <td><?= h($cartons->id) ?></td>
                    <td><?= h($cartons->pallet_id) ?></td>
                    <td><?= h($cartons->count) ?></td>
                    <td><?= h($cartons->best_before) ?></td>
                    <td><?= h($cartons->production_date) ?></td>
                    <td><?= h($cartons->item_id) ?></td>
                    <td><?= h($cartons->created) ?></td>
                    <td><?= h($cartons->modified) ?></td>
                    <td><?= h($cartons->user_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Cartons', 'action' => 'view', $cartons->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Cartons', 'action' => 'edit', $cartons->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cartons', 'action' => 'delete', $cartons->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cartons->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>