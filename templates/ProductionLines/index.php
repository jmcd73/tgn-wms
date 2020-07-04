<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductionLine[]|\Cake\Collection\CollectionInterface $productionLines
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Production Line'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
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

<table class="table table-striped">
    <thead>
        <tr>
           
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('printer_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('product_type_id') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productionLines as $productionLine) : ?>
        <tr>
            <td><?= $this->Html->activeIcon($productionLine->active); ?></td>
            <td><?= $productionLine->has('printer') ? $this->Html->link($productionLine->printer->name, ['controller' => 'Printers', 'action' => 'view', $productionLine->printer->id]) : '' ?>
            </td>
            <td><?= h($productionLine->name) ?></td>
            <td><?= $productionLine->has('product_type') ? $this->Html->link($productionLine->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $productionLine->product_type->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $productionLine->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productionLine->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $productionLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productionLine->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
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