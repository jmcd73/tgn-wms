<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductType $productType
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Product Type'), ['action' => 'edit', $productType->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Product Type'), ['action' => 'delete', $productType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productType->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Product Type'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['controller' => 'InventoryStatuses', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Inventory Status'), ['controller' => 'InventoryStatuses', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['controller' => 'Labels', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Label'), ['controller' => 'Labels', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Production Lines'), ['controller' => 'ProductionLines', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Production Line'), ['controller' => 'ProductionLines', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Shifts'), ['controller' => 'Shifts', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Shift'), ['controller' => 'Shifts', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Shipments'), ['controller' => 'Shipments', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Shipment'), ['controller' => 'Shipments', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="productTypes view large-9 medium-8 columns content">
    <h3><?= h($productType->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Inventory Status') ?></th>
                <td><?= $productType->has('inventory_status') ? $this->Html->link($productType->inventory_status->name, ['controller' => 'InventoryStatuses', 'action' => 'view', $productType->inventory_status->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($productType->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Code Prefix') ?></th>
                <td><?= h($productType->code_prefix) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Storage Temperature') ?></th>
                <td><?= h($productType->storage_temperature) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Code Regex') ?></th>
                <td><?= h($productType->code_regex) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Code Regex Description') ?></th>
                <td><?= h($productType->code_regex_description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Serial Number Format') ?></th>
                <td><?= h($productType->serial_number_format) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($productType->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Location Id') ?></th>
                <td><?= $this->Number->format($productType->location_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Next Serial Number') ?></th>
                <td><?= $this->Number->format($productType->next_serial_number) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $productType->active ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Enable Pick App') ?></th>
                <td><?= $productType->enable_pick_app ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Locations') ?></h4>
        <?php if (!empty($productType->locations)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Location') ?></th>
                    <th scope="col"><?= __('Pallet Capacity') ?></th>
                    <th scope="col"><?= __('Is Hidden') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($productType->locations as $locations): ?>
                <tr>
                    <td><?= h($locations->id) ?></td>
                    <td><?= h($locations->location) ?></td>
                    <td><?= h($locations->pallet_capacity) ?></td>
                    <td><?= h($locations->is_hidden) ?></td>
                    <td><?= h($locations->description) ?></td>
                    <td><?= h($locations->created) ?></td>
                    <td><?= h($locations->modified) ?></td>
                    <td><?= h($locations->product_type_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Locations', 'action' => 'view', $locations->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Locations', 'action' => 'edit', $locations->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Locations', 'action' => 'delete', $locations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locations->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($productType->items)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Code') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Quantity') ?></th>
                    <th scope="col"><?= __('Trade Unit') ?></th>
                    <th scope="col"><?= __('Pack Size Id') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col"><?= __('Consumer Unit') ?></th>
                    <th scope="col"><?= __('Brand') ?></th>
                    <th scope="col"><?= __('Variant') ?></th>
                    <th scope="col"><?= __('Unit Net Contents') ?></th>
                    <th scope="col"><?= __('Unit Of Measure') ?></th>
                    <th scope="col"><?= __('Days Life') ?></th>
                    <th scope="col"><?= __('Min Days Life') ?></th>
                    <th scope="col"><?= __('Item Comment') ?></th>
                    <th scope="col"><?= __('Print Template Id') ?></th>
                    <th scope="col"><?= __('Carton Label Id') ?></th>
                    <th scope="col"><?= __('Pallet Label Copies') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($productType->items as $items): ?>
                <tr>
                    <td><?= h($items->id) ?></td>
                    <td><?= h($items->active) ?></td>
                    <td><?= h($items->code) ?></td>
                    <td><?= h($items->description) ?></td>
                    <td><?= h($items->quantity) ?></td>
                    <td><?= h($items->trade_unit) ?></td>
                    <td><?= h($items->pack_size_id) ?></td>
                    <td><?= h($items->product_type_id) ?></td>
                    <td><?= h($items->consumer_unit) ?></td>
                    <td><?= h($items->brand) ?></td>
                    <td><?= h($items->variant) ?></td>
                    <td><?= h($items->unit_net_contents) ?></td>
                    <td><?= h($items->unit_of_measure) ?></td>
                    <td><?= h($items->days_life) ?></td>
                    <td><?= h($items->min_days_life) ?></td>
                    <td><?= h($items->item_comment) ?></td>
                    <td><?= h($items->print_template_id) ?></td>
                    <td><?= h($items->carton_label_id) ?></td>
                    <td><?= h($items->pallet_label_copies) ?></td>
                    <td><?= h($items->created) ?></td>
                    <td><?= h($items->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Labels') ?></h4>
        <?php if (!empty($productType->labels)): ?>
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
                <?php foreach ($productType->labels as $labels): ?>
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
        <?php if (!empty($productType->pallets)): ?>
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
                <?php foreach ($productType->pallets as $pallets): ?>
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
    <div class="related">
        <h4><?= __('Related Production Lines') ?></h4>
        <?php if (!empty($productType->production_lines)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Printer Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($productType->production_lines as $productionLines): ?>
                <tr>
                    <td><?= h($productionLines->id) ?></td>
                    <td><?= h($productionLines->active) ?></td>
                    <td><?= h($productionLines->printer_id) ?></td>
                    <td><?= h($productionLines->name) ?></td>
                    <td><?= h($productionLines->product_type_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'ProductionLines', 'action' => 'view', $productionLines->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'ProductionLines', 'action' => 'edit', $productionLines->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'ProductionLines', 'action' => 'delete', $productionLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productionLines->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Shifts') ?></h4>
        <?php if (!empty($productType->shifts)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Shift Minutes') ?></th>
                    <th scope="col"><?= __('Comment') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('For Prod Dt') ?></th>
                    <th scope="col"><?= __('Start Time') ?></th>
                    <th scope="col"><?= __('Stop Time') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($productType->shifts as $shifts): ?>
                <tr>
                    <td><?= h($shifts->id) ?></td>
                    <td><?= h($shifts->name) ?></td>
                    <td><?= h($shifts->shift_minutes) ?></td>
                    <td><?= h($shifts->comment) ?></td>
                    <td><?= h($shifts->created) ?></td>
                    <td><?= h($shifts->modified) ?></td>
                    <td><?= h($shifts->active) ?></td>
                    <td><?= h($shifts->for_prod_dt) ?></td>
                    <td><?= h($shifts->start_time) ?></td>
                    <td><?= h($shifts->stop_time) ?></td>
                    <td><?= h($shifts->product_type_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Shifts', 'action' => 'view', $shifts->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Shifts', 'action' => 'edit', $shifts->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Shifts', 'action' => 'delete', $shifts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shifts->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Shipments') ?></h4>
        <?php if (!empty($productType->shipments)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Operator Id') ?></th>
                    <th scope="col"><?= __('Truck Registration Id') ?></th>
                    <th scope="col"><?= __('Shipper') ?></th>
                    <th scope="col"><?= __('Con Note') ?></th>
                    <th scope="col"><?= __('Shipment Type') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col"><?= __('Destination') ?></th>
                    <th scope="col"><?= __('Pallet Count') ?></th>
                    <th scope="col"><?= __('Shipped') ?></th>
                    <th scope="col"><?= __('Time Start') ?></th>
                    <th scope="col"><?= __('Time Finish') ?></th>
                    <th scope="col"><?= __('Time Total') ?></th>
                    <th scope="col"><?= __('Truck Temp') ?></th>
                    <th scope="col"><?= __('Dock Temp') ?></th>
                    <th scope="col"><?= __('Product Temp') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($productType->shipments as $shipments): ?>
                <tr>
                    <td><?= h($shipments->id) ?></td>
                    <td><?= h($shipments->operator_id) ?></td>
                    <td><?= h($shipments->truck_registration_id) ?></td>
                    <td><?= h($shipments->shipper) ?></td>
                    <td><?= h($shipments->con_note) ?></td>
                    <td><?= h($shipments->shipment_type) ?></td>
                    <td><?= h($shipments->product_type_id) ?></td>
                    <td><?= h($shipments->destination) ?></td>
                    <td><?= h($shipments->pallet_count) ?></td>
                    <td><?= h($shipments->shipped) ?></td>
                    <td><?= h($shipments->time_start) ?></td>
                    <td><?= h($shipments->time_finish) ?></td>
                    <td><?= h($shipments->time_total) ?></td>
                    <td><?= h($shipments->truck_temp) ?></td>
                    <td><?= h($shipments->dock_temp) ?></td>
                    <td><?= h($shipments->product_temp) ?></td>
                    <td><?= h($shipments->created) ?></td>
                    <td><?= h($shipments->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Shipments', 'action' => 'view', $shipments->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Shipments', 'action' => 'edit', $shipments->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Shipments', 'action' => 'delete', $shipments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipments->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
