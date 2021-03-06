<?php

/**
 * @var \App\View\AppView          $this
 * @var \App\Model\Entity\Shipment $shipment
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Shipment'), ['action' => 'process', 'edit-shipment', $shipment->id], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Form->postLink(__('Delete Shipment'), ['action' => 'delete', $shipment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipment->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Shipments'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="shipments view large-9 medium-8 columns content">
    <h3><?= h($shipment->shipper) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Shipped') ?></th>
                <td><?= $this->Html->activeIcon($shipment->shipped); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Shipper') ?></th>
                <td><?= h($shipment->shipper) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $shipment->has('product_type') ? h($shipment->product_type->name) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Destination') ?></th>
                <td><?= h($shipment->destination) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pallet Count') ?></th>
                <td><?= $this->Number->format($shipment->pallet_count) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($shipment->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($shipment->modified) ?></td>
            </tr>

        </table>
    </div>

    <div class="related">
        <h4><?= __('Related Pallets') ?></h4>
        <?php if (!empty($shipment->pallets)) : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        
                        <th scope="col"><?= __('Item') ?></th>
                        <th scope="col"><?= __('Description') ?></th>
                        <th scope="col"><?= __('Bb Date') ?></th>
                        <th scope="col"><?= __('Gtin14') ?></th>
                        <th scope="col"><?= __('Qty') ?></th>
                        <th scope="col"><?= __('Pl Ref') ?></th>
                        <th scope="col"><?= __('Sscc') ?></th>
                        <th scope="col"><?= __('Batch') ?></th>
                        <th scope="col"><?= __('Print Date') ?></th>
                        <th scope="col"><?= __('Location') ?></th>
                        <th scope="col"><?= __('Inventory Status Note') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($shipment->pallets as $pallets) : ?>
                        <tr>
                            <td><?= h($pallets->item) ?></td>
                            <td><?= h($pallets->description) ?></td>
                            <td><?= h($pallets->bb_date) ?></td>
                            <td><?= h($pallets->gtin14) ?></td>
                            <td><?= h($pallets->qty) ?></td>
                            <td><?= h($pallets->pl_ref) ?></td>
                            <td><?= h($pallets->sscc) ?></td>
                            <td><?= h($pallets->batch) ?></td>
                            <td><?= h($pallets->production_date) ?></td>
                            <td><?= $pallets->has('location') ? $pallets->location->location: '' ?></td>
                            <td><?= h($pallets->inventory_status_note) ?></td>
                            <td><?= h($pallets->created) ?></td>
                            <td><?= h($pallets->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Pallets', 'action' => 'view', $pallets->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>