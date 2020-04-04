<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Locations'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['controller' => 'Labels', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Label'), ['controller' => 'Labels', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="locations view large-9 medium-8 columns content">
    <h3><?= h($location->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Location') ?></th>
                <td><?= h($location->location) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($location->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($location->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pallet Capacity') ?></th>
                <td><?= $this->Number->format($location->pallet_capacity) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type Id') ?></th>
                <td><?= $this->Number->format($location->product_type_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($location->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($location->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Is Hidden') ?></th>
                <td><?= $location->is_hidden ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Product Types') ?></h4>
        <?php if (!empty($location->product_types)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Inventory Status Id') ?></th>
                    <th scope="col"><?= __('Location Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Code Prefix') ?></th>
                    <th scope="col"><?= __('Storage Temperature') ?></th>
                    <th scope="col"><?= __('Code Regex') ?></th>
                    <th scope="col"><?= __('Code Regex Description') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Next Serial Number') ?></th>
                    <th scope="col"><?= __('Serial Number Format') ?></th>
                    <th scope="col"><?= __('Enable Pick App') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($location->product_types as $productTypes): ?>
                <tr>
                    <td><?= h($productTypes->id) ?></td>
                    <td><?= h($productTypes->inventory_status_id) ?></td>
                    <td><?= h($productTypes->location_id) ?></td>
                    <td><?= h($productTypes->name) ?></td>
                    <td><?= h($productTypes->code_prefix) ?></td>
                    <td><?= h($productTypes->storage_temperature) ?></td>
                    <td><?= h($productTypes->code_regex) ?></td>
                    <td><?= h($productTypes->code_regex_description) ?></td>
                    <td><?= h($productTypes->active) ?></td>
                    <td><?= h($productTypes->next_serial_number) ?></td>
                    <td><?= h($productTypes->serial_number_format) ?></td>
                    <td><?= h($productTypes->enable_pick_app) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'ProductTypes', 'action' => 'view', $productTypes->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'ProductTypes', 'action' => 'edit', $productTypes->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'ProductTypes', 'action' => 'delete', $productTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productTypes->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Labels') ?></h4>
        <?php if (!empty($location->labels)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Production Line Id') ?></th>
                    <th scope="col"><?= __('Item') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Item Id') ?></th>
                    <th scope="col"><?= __('Best Before') ?></th>
                    <th scope="col"><?= __('Bb Date') ?></th>
                    <th scope="col"><?= __('Gtin14') ?></th>
                    <th scope="col"><?= __('Qty User Id') ?></th>
                    <th scope="col"><?= __('Qty') ?></th>
                    <th scope="col"><?= __('Qty Previous') ?></th>
                    <th scope="col"><?= __('Qty Modified') ?></th>
                    <th scope="col"><?= __('Pl Ref') ?></th>
                    <th scope="col"><?= __('Sscc') ?></th>
                    <th scope="col"><?= __('Batch') ?></th>
                    <th scope="col"><?= __('Printer Id') ?></th>
                    <th scope="col"><?= __('Print Date') ?></th>
                    <th scope="col"><?= __('Cooldown Date') ?></th>
                    <th scope="col"><?= __('Min Days Life') ?></th>
                    <th scope="col"><?= __('Production Line') ?></th>
                    <th scope="col"><?= __('Location Id') ?></th>
                    <th scope="col"><?= __('Shipment Id') ?></th>
                    <th scope="col"><?= __('Inventory Status Id') ?></th>
                    <th scope="col"><?= __('Inventory Status Note') ?></th>
                    <th scope="col"><?= __('Inventory Status Datetime') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Ship Low Date') ?></th>
                    <th scope="col"><?= __('Picked') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($location->labels as $labels): ?>
                <tr>
                    <td><?= h($labels->id) ?></td>
                    <td><?= h($labels->production_line_id) ?></td>
                    <td><?= h($labels->item) ?></td>
                    <td><?= h($labels->description) ?></td>
                    <td><?= h($labels->item_id) ?></td>
                    <td><?= h($labels->best_before) ?></td>
                    <td><?= h($labels->bb_date) ?></td>
                    <td><?= h($labels->gtin14) ?></td>
                    <td><?= h($labels->qty_user_id) ?></td>
                    <td><?= h($labels->qty) ?></td>
                    <td><?= h($labels->qty_previous) ?></td>
                    <td><?= h($labels->qty_modified) ?></td>
                    <td><?= h($labels->pl_ref) ?></td>
                    <td><?= h($labels->sscc) ?></td>
                    <td><?= h($labels->batch) ?></td>
                    <td><?= h($labels->printer_id) ?></td>
                    <td><?= h($labels->print_date) ?></td>
                    <td><?= h($labels->cooldown_date) ?></td>
                    <td><?= h($labels->min_days_life) ?></td>
                    <td><?= h($labels->production_line) ?></td>
                    <td><?= h($labels->location_id) ?></td>
                    <td><?= h($labels->shipment_id) ?></td>
                    <td><?= h($labels->inventory_status_id) ?></td>
                    <td><?= h($labels->inventory_status_note) ?></td>
                    <td><?= h($labels->inventory_status_datetime) ?></td>
                    <td><?= h($labels->created) ?></td>
                    <td><?= h($labels->modified) ?></td>
                    <td><?= h($labels->ship_low_date) ?></td>
                    <td><?= h($labels->picked) ?></td>
                    <td><?= h($labels->product_type_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Labels', 'action' => 'view', $labels->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Labels', 'action' => 'edit', $labels->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Labels', 'action' => 'delete', $labels->id], ['confirm' => __('Are you sure you want to delete # {0}?', $labels->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Pallets') ?></h4>
        <?php if (!empty($location->pallets)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Production Line Id') ?></th>
                    <th scope="col"><?= __('Item') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Item Id') ?></th>
                    <th scope="col"><?= __('Best Before') ?></th>
                    <th scope="col"><?= __('Bb Date') ?></th>
                    <th scope="col"><?= __('Gtin14') ?></th>
                    <th scope="col"><?= __('Qty User Id') ?></th>
                    <th scope="col"><?= __('Qty') ?></th>
                    <th scope="col"><?= __('Qty Previous') ?></th>
                    <th scope="col"><?= __('Qty Modified') ?></th>
                    <th scope="col"><?= __('Pl Ref') ?></th>
                    <th scope="col"><?= __('Sscc') ?></th>
                    <th scope="col"><?= __('Batch') ?></th>
                    <th scope="col"><?= __('Printer') ?></th>
                    <th scope="col"><?= __('Printer Id') ?></th>
                    <th scope="col"><?= __('Print Date') ?></th>
                    <th scope="col"><?= __('Cooldown Date') ?></th>
                    <th scope="col"><?= __('Min Days Life') ?></th>
                    <th scope="col"><?= __('Production Line') ?></th>
                    <th scope="col"><?= __('Location Id') ?></th>
                    <th scope="col"><?= __('Shipment Id') ?></th>
                    <th scope="col"><?= __('Inventory Status Id') ?></th>
                    <th scope="col"><?= __('Inventory Status Note') ?></th>
                    <th scope="col"><?= __('Inventory Status Datetime') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Ship Low Date') ?></th>
                    <th scope="col"><?= __('Picked') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($location->pallets as $pallets): ?>
                <tr>
                    <td><?= h($pallets->id) ?></td>
                    <td><?= h($pallets->production_line_id) ?></td>
                    <td><?= h($pallets->item) ?></td>
                    <td><?= h($pallets->description) ?></td>
                    <td><?= h($pallets->item_id) ?></td>
                    <td><?= h($pallets->best_before) ?></td>
                    <td><?= h($pallets->bb_date) ?></td>
                    <td><?= h($pallets->gtin14) ?></td>
                    <td><?= h($pallets->qty_user_id) ?></td>
                    <td><?= h($pallets->qty) ?></td>
                    <td><?= h($pallets->qty_previous) ?></td>
                    <td><?= h($pallets->qty_modified) ?></td>
                    <td><?= h($pallets->pl_ref) ?></td>
                    <td><?= h($pallets->sscc) ?></td>
                    <td><?= h($pallets->batch) ?></td>
                    <td><?= h($pallets->printer) ?></td>
                    <td><?= h($pallets->printer_id) ?></td>
                    <td><?= h($pallets->print_date) ?></td>
                    <td><?= h($pallets->cooldown_date) ?></td>
                    <td><?= h($pallets->min_days_life) ?></td>
                    <td><?= h($pallets->production_line) ?></td>
                    <td><?= h($pallets->location_id) ?></td>
                    <td><?= h($pallets->shipment_id) ?></td>
                    <td><?= h($pallets->inventory_status_id) ?></td>
                    <td><?= h($pallets->inventory_status_note) ?></td>
                    <td><?= h($pallets->inventory_status_datetime) ?></td>
                    <td><?= h($pallets->created) ?></td>
                    <td><?= h($pallets->modified) ?></td>
                    <td><?= h($pallets->ship_low_date) ?></td>
                    <td><?= h($pallets->picked) ?></td>
                    <td><?= h($pallets->product_type_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Pallets', 'action' => 'view', $pallets->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Pallets', 'action' => 'edit', $pallets->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Pallets', 'action' => 'delete', $pallets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pallets->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
