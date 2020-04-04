<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryStatus[]|\Cake\Collection\CollectionInterface $inventoryStatuses
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Inventory Status'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['controller' => 'Labels', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Label'), ['controller' => 'Labels', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('perms') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
        <th scope="col"><?= $this->Paginator->sort('allow_bulk_status_change') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($inventoryStatuses as $inventoryStatus) : ?>
        <tr>
            <td><?= $this->Number->format($inventoryStatus->id) ?></td>
            <td><?= $this->Number->format($inventoryStatus->perms) ?></td>
            <td><?= h($inventoryStatus->name) ?></td>
            <td><?= h($inventoryStatus->comment) ?></td>
            <td><?= h($inventoryStatus->allow_bulk_status_change) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $inventoryStatus->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inventoryStatus->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inventoryStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryStatus->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
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
