<?php
/**
 * @var \App\View\AppView                                                $this
 * @var \App\Model\Entity\Printer[]|\Cake\Collection\CollectionInterface $printers
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Printer'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('Cups Admin'), $cupsUrl, ['class' => 'nav-link external', 'target' => '_blank']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('options') ?></th>
            <th scope="col"><?= $this->Paginator->sort('queue_name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('set_as_default_on_these_actions') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($printers as $printer) : ?>
        <tr>
            <td><?= $this->Number->format($printer->id) ?></td>
            <td><?= h($printer->active) ?></td>
            <td><?= h($printer->name) ?></td>
            <td><?= h($printer->options) ?></td>
            <td><?= h($printer->queue_name) ?></td>
            <td><?= $this->Text->toList(h($printer->array_of_actions)); ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $printer->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $printer->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $printer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printer->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
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
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>