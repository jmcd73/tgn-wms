<?php

/**
 * @var \App\View\AppView                                                 $this
 * @var \App\Model\Entity\Shipment[]|\Cake\Collection\CollectionInterface $shipments
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<?php foreach ($productTypes as $key => $productType) : ?>
    <li class="nav-item">
        <?= $this->Html->link('Add ' . $productType, ['action' => 'process', 'add-shipment', $key], ['class' => 'nav-link']); ?>
    </li>

<?php endforeach; ?>
<?php if ($showMixed) : ?>
    <li class="nav-item">
        <?= $this->Html->link('Add Mixed', ['action' => 'process', 'add-shipment'], ['class' => 'nav-link']); ?>
    </li>
<?php endif; ?>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped shipments">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('shipped') ?></th>
            <th scope="col"><?= $this->Paginator->sort('shipper') ?></th>
            <th scope="col"><?= $this->Paginator->sort('product_type_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('destination') ?></th>
            <th scope="col"><?= $this->Paginator->sort('pallet_count', 'Pallets') ?></th>

            <th scope="col"><?= $this->Paginator->sort('modified', 'Last updated') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shipments as $shipment) : ?>
            <tr>

                <td class="text-center">
                    <?php $icon = $shipment->shipped === true ? 'toggle-on' : 'toggle-off';
                    echo $this->Form->postLink(
                        $this->Html->icon($icon),
                        [
                            'action' => 'toggleShipped',
                            $shipment->id,
                        ],
                        [
                            'escape' => false,
                            'class' => 'btn',
                        ],
                        __('Are you sure you want to toggle shipped state # %s?', $shipment->id)
                    );
                    ?></td>
                <td><?= h($shipment->shipper) ?></td>
                <td><?= $shipment->has('product_type') ? h($shipment->product_type->name) : 'Mixed' ?>
                </td>
                <td><?= h($shipment->destination) ?></td>
                <td><?= $this->Number->format($shipment->pallet_count) ?></td>

                <td><?= h($shipment->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('PDF'), ['action' => 'pdfPickList', $shipment->id], [
                        'title' => __('PDF Pick List'),
                        'target' => '_blank',
                        'class' => 'pdf btn btn-secondary btn-sm',
                    ]) ?>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shipment->id], ['title' => __('View'), 'class' => 'view btn btn-secondary btn-sm']) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'process', 'edit-shipment', $shipment->id], ['title' => __('Edit'), 'class' => 'edit btn btn-secondary btn-sm']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shipment->id], [
                        'confirm' => __('Are you sure you want to delete # {0}?', $shipment->id), 'title' => __('Delete'),
                        'class' => 'delete btn btn-danger btn-sm',
                    ]) ?>
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