<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductionLine $productionLine
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Production Line'), ['action' => 'edit', $productionLine->id], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Form->postLink(__('Delete Production Line'), ['action' => 'delete', $productionLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productionLine->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Production Lines'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Production Line'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Printers'), ['controller' => 'Printers', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Printer'), ['controller' => 'Printers', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="productionLines view large-9 medium-8 columns content">
    <h3><?= h($productionLine->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Printer') ?></th>
                <td><?= $productionLine->has('printer') ? $this->Html->link($productionLine->printer->name, ['controller' => 'Printers', 'action' => 'view', $productionLine->printer->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($productionLine->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $productionLine->has('product_type') ? $this->Html->link($productionLine->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $productionLine->product_type->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($productionLine->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $productionLine->active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Pallets') ?></h4>
        <?php if (!empty($productionLine->pallets)): ?>
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
                <?php foreach ($productionLine->pallets as $pallets): ?>
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
                    <td><?= h($pallets->production_date) ?></td>
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
                        <?= $this->Html->link(__('View'), ['controller' => 'Pallets', 'action' => 'view', $pallets->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Pallets', 'action' => 'edit', $pallets->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pallets', 'action' => 'delete', $pallets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pallets->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>