<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PackSize[]|\Cake\Collection\CollectionInterface $packSizes
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Pack Size'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
       
        <th scope="col"><?= $this->Paginator->sort('pack_size') ?></th>
        <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($packSizes as $packSize) : ?>
        <tr>
            <td><?= h($packSize->pack_size) ?></td>
            <td><?= h($packSize->comment) ?></td>
            <td><?= h($packSize->created) ?></td>
            <td><?= h($packSize->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $packSize->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $packSize->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $packSize->id], ['confirm' => __('Are you sure you want to delete # {0}?', $packSize->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
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
