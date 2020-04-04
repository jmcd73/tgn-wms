<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shipment[]|\Cake\Collection\CollectionInterface $shipments
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Shipment'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['controller' => 'Labels', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Label'), ['controller' => 'Labels', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('operator_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('truck_registration_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('shipper') ?></th>
        <th scope="col"><?= $this->Paginator->sort('con_note') ?></th>
        <th scope="col"><?= $this->Paginator->sort('shipment_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('product_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('destination') ?></th>
        <th scope="col"><?= $this->Paginator->sort('pallet_count') ?></th>
        <th scope="col"><?= $this->Paginator->sort('shipped') ?></th>
        <th scope="col"><?= $this->Paginator->sort('time_start') ?></th>
        <th scope="col"><?= $this->Paginator->sort('time_finish') ?></th>
        <th scope="col"><?= $this->Paginator->sort('time_total') ?></th>
        <th scope="col"><?= $this->Paginator->sort('truck_temp') ?></th>
        <th scope="col"><?= $this->Paginator->sort('dock_temp') ?></th>
        <th scope="col"><?= $this->Paginator->sort('product_temp') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($shipments as $shipment) : ?>
        <tr>
            <td><?= $this->Number->format($shipment->id) ?></td>
            <td><?= $this->Number->format($shipment->operator_id) ?></td>
            <td><?= $this->Number->format($shipment->truck_registration_id) ?></td>
            <td><?= h($shipment->shipper) ?></td>
            <td><?= h($shipment->con_note) ?></td>
            <td><?= h($shipment->shipment_type) ?></td>
            <td><?= $shipment->has('product_type') ? $this->Html->link($shipment->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $shipment->product_type->id]) : '' ?></td>
            <td><?= h($shipment->destination) ?></td>
            <td><?= $this->Number->format($shipment->pallet_count) ?></td>
            <td><?= h($shipment->shipped) ?></td>
            <td><?= h($shipment->time_start) ?></td>
            <td><?= h($shipment->time_finish) ?></td>
            <td><?= $this->Number->format($shipment->time_total) ?></td>
            <td><?= $this->Number->format($shipment->truck_temp) ?></td>
            <td><?= $this->Number->format($shipment->dock_temp) ?></td>
            <td><?= $this->Number->format($shipment->product_temp) ?></td>
            <td><?= h($shipment->created) ?></td>
            <td><?= h($shipment->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $shipment->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shipment->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shipment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipment->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
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
