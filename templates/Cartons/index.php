<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Carton[]|\Cake\Collection\CollectionInterface $cartons
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Carton'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>

<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('pallet_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('count') ?></th>
        <th scope="col"><?= $this->Paginator->sort('best_before') ?></th>
        <th scope="col"><?= $this->Paginator->sort('production_date') ?></th>
        <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($cartons as $carton) : ?>
        <tr>
            <td><?= $this->Number->format($carton->id) ?></td>
            <td><?= $carton->has('pallet') ? $this->Html->link($carton->pallet->id, ['controller' => 'Pallets', 'action' => 'view', $carton->pallet->id]) : '' ?></td>
            <td><?= $this->Number->format($carton->count) ?></td>
            <td><?= h($carton->best_before) ?></td>
            <td><?= h($carton->production_date) ?></td>
            <td><?= $carton->has('item') ? $this->Html->link($carton->item->id, ['controller' => 'Items', 'action' => 'view', $carton->item->id]) : '' ?></td>
            <td><?= h($carton->created) ?></td>
            <td><?= h($carton->modified) ?></td>
            <td><?= $carton->has('user') ? $this->Html->link($carton->user->id, ['controller' => 'Users', 'action' => 'view', $carton->user->id]) : '' ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $carton->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $carton->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $carton->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carton->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
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
