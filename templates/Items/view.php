<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Items'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Item'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Pack Sizes'), ['controller' => 'PackSizes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Pack Size'), ['controller' => 'PackSizes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Print Templates'), ['controller' => 'PrintTemplates', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Print Template'), ['controller' => 'PrintTemplates', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Cartons'), ['controller' => 'Cartons', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Carton'), ['controller' => 'Cartons', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="items view large-9 medium-8 columns content">
    <h3><?= h($item->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Code') ?></th>
                <td><?= h($item->code) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($item->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Trade Unit') ?></th>
                <td><?= h($item->trade_unit) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pack Size') ?></th>
                <td><?= $item->has('pack_size') ? $this->Html->link($item->pack_size->id, ['controller' => 'PackSizes', 'action' => 'view', $item->pack_size->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $item->has('product_type') ? $this->Html->link($item->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $item->product_type->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Consumer Unit') ?></th>
                <td><?= h($item->consumer_unit) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Brand') ?></th>
                <td><?= h($item->brand) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Variant') ?></th>
                <td><?= h($item->variant) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Unit Of Measure') ?></th>
                <td><?= h($item->unit_of_measure) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Print Template') ?></th>
                <td><?= $item->has('print_template') ? $this->Html->link($item->print_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $item->print_template->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($item->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Quantity') ?></th>
                <td><?= $this->Number->format($item->quantity) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Unit Net Contents') ?></th>
                <td><?= $this->Number->format($item->unit_net_contents) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Days Life') ?></th>
                <td><?= $this->Number->format($item->days_life) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Min Days Life') ?></th>
                <td><?= $this->Number->format($item->min_days_life) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Carton Label Id') ?></th>
                <td><?= $this->Number->format($item->carton_template_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pallet Label Copies') ?></th>
                <td><?= $this->Number->format($item->pallet_label_copies) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($item->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($item->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $item->active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4><?= __('Item Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($item->item_comment)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Cartons') ?></h4>
        <?php if (!empty($item->cartons)): ?>
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
                <?php foreach ($item->cartons as $cartons): ?>
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
    <div class="related">
        <h4><?= __('Related Pallets') ?></h4>
        <?php if (!empty($item->pallets)): ?>
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
                <?php foreach ($item->pallets as $pallets): ?>
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