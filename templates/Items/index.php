<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Item'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
</li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('code') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
            <th scope="col"><?= $this->Paginator->sort('trade_unit') ?></th>
            <th scope="col"><?= $this->Paginator->sort('pack_size_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('product_type_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('consumer_unit') ?></th>
            <th scope="col"><?= $this->Paginator->sort('brand') ?></th>
            <th scope="col"><?= $this->Paginator->sort('variant') ?></th>
            <th scope="col"><?= $this->Paginator->sort('unit_net_contents') ?></th>
            <th scope="col"><?= $this->Paginator->sort('unit_of_measure') ?></th>
            <th scope="col"><?= $this->Paginator->sort('days_life') ?></th>
            <th scope="col"><?= $this->Paginator->sort('min_days_life') ?></th>
            <th scope="col"><?= $this->Paginator->sort('pallet_template_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('carton_template_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('pallet_label_copies') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) : ?>
        <tr>
            <td><?= $this->Number->format($item->id) ?></td>
            <td><?= h($item->active) ?></td>
            <td><?= h($item->code) ?></td>
            <td><?= h($item->description) ?></td>
            <td><?= $this->Number->format($item->quantity) ?></td>
            <td><?= h($item->trade_unit) ?></td>
            <td><?= $item->has('pack_size') ? $this->Html->link($item->pack_size->pack_size, ['controller' => 'PackSizes', 'action' => 'view', $item->pack_size->id]) : '' ?>
            </td>
            <td><?= $item->has('product_type') ? $this->Html->link($item->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $item->product_type->id]) : '' ?>
            </td>
            <td><?= h($item->consumer_unit) ?></td>
            <td><?= h($item->brand) ?></td>
            <td><?= h($item->variant) ?></td>
            <td><?= $this->Number->format($item->unit_net_contents) ?></td>
            <td><?= h($item->unit_of_measure) ?></td>
            <td><?= $this->Number->format($item->days_life) ?></td>
            <td><?= $this->Number->format($item->min_days_life) ?></td>
            <td><?= $item->has('print_template') ? $this->Html->link($item->print_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $item->print_template->id]) : '' ?>
            </td>
            <td><?= $item->has('carton_template') ? $this->Html->link($item->carton_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $item->carton_template->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($item->pallet_label_copies) ?></td>
            <td><?= h($item->created) ?></td>
            <td><?= h($item->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $item->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mb-1']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
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