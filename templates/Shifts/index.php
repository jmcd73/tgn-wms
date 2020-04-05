<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shift[]|\Cake\Collection\CollectionInterface $shifts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Shift'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('shift_minutes') ?></th>
        <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('active') ?></th>
        <th scope="col"><?= $this->Paginator->sort('for_prod_dt') ?></th>
        <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
        <th scope="col"><?= $this->Paginator->sort('stop_time') ?></th>
        <th scope="col"><?= $this->Paginator->sort('product_type_id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($shifts as $shift) : ?>
        <tr>
            <td><?= $this->Number->format($shift->id) ?></td>
            <td><?= h($shift->name) ?></td>
            <td><?= $this->Number->format($shift->shift_minutes) ?></td>
            <td><?= h($shift->comment) ?></td>
            <td><?= h($shift->created) ?></td>
            <td><?= h($shift->modified) ?></td>
            <td><?= h($shift->active) ?></td>
            <td><?= h($shift->for_prod_dt) ?></td>
            <td><?= h($shift->start_time) ?></td>
            <td><?= h($shift->stop_time) ?></td>
            <td><?= $shift->has('product_type') ? $this->Html->link($shift->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $shift->product_type->id]) : '' ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $shift->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shift->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shift->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shift->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
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
