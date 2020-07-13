<?php

/**
 * @var \App\View\AppView        $this
 * @var \App\Model\Entity\Pallet $pallet
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php if($user->role === 'admin'):?>
<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Pallets'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>
<?php endif; ?>

<div class="pallets view large-9 medium-8 columns content">
    <div class="row">
    <div class="col"><h3><?= h($pallet->pl_ref) ?></h3></div>
    </div>
    <div class="row">
        <div class="col"> <div class="table-responsive">
        <table class="table table-striped">

            <tr>
                <th scope="row"><?= __('Code') ?></th>
                <td><?= h($pallet->item) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= $pallet->has('items') ? $this->Html->link($pallet->items->description, ['controller' => 'Items', 'action' => 'view', $pallet->items->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Production Line') ?></th>
                <td><?= $pallet->has('production_lines') ? $this->Html->link($pallet->production_lines->name, ['controller' => 'ProductionLines', 'action' => 'view', $pallet->production_lines->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Gtin14') ?></th>
                <td><?= h($pallet->gtin14) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pl Ref') ?></th>
                <td><?= h($pallet->pl_ref) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sscc') ?></th>
                <td><?= h($this->Html->sscc($pallet->sscc)) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Batch') ?></th>
                <td><?= h($pallet->batch) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Printer') ?></th>
                <td><?= $pallet->has('printers') ? $this->Html->link($pallet->printers->name, ['controller' => 'Printers', 'action' => 'view', $pallet->printers->id]) : '' ?>
                </td>
            </tr>

            <tr>
                <th scope="row"><?= __('Location') ?></th>
                <td><?= $pallet->has('location') ? $this->Html->link($pallet->location->location, ['controller' => 'Locations', 'action' => 'view', $pallet->location->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Shipment') ?></th>
                <td><?= $pallet->has('shipment') ? $this->Html->link($pallet->shipment->shipper, ['controller' => 'Shipments', 'action' => 'view', $pallet->shipment->id]) : '' ?>
                </td>
            </tr>

        </table>
    </div></div>
        <div class="col">
        <div class="table-responsive">
        <table class="table table-striped">

        <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $pallet->has('product_type') ? $this->Html->link($pallet->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $pallet->product_type->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Qty on Pallet') ?></th>
                <td><?= $this->Number->format($pallet->qty) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Best before date') ?></th>
                <td><?= h($pallet->bb_date) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Production Date') ?></th>
                <td><?= h($pallet->production_date) ?></td>
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
           
        </table>
    </div>

        </div>

    </div>
   
    <div class="related">
        <h4><?= __('Related Cartons') ?></h4>
        <?php if (!empty($pallet->cartons)) : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('# Cartons') ?></th>
                        <th scope="col"><?= __('Best Before') ?></th>
                        <th scope="col"><?= __('Production Date') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                    </tr>
                    <?php foreach ($pallet->cartons as $cartons) : ?>
                        <tr>
                            <td><?= h($cartons->id) ?></td>
                            <td><?= h($cartons->count) ?></td>
                            <td><?= h($cartons->best_before) ?></td>
                            <td><?= h($cartons->production_date) ?></td>
                            <td><?= h($cartons->created) ?></td>
                            <td><?= h($cartons->modified) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>