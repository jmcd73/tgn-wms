<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Items'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Item'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Pack Sizes'), ['controller' => 'PackSizes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Pack Size'), ['controller' => 'PackSizes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Print Templates'), ['controller' => 'PrintTemplates', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Print Template'), ['controller' => 'PrintTemplates', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Cartons'), ['controller' => 'Cartons', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Carton'), ['controller' => 'Cartons', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="items view large-9 medium-8 columns content">
    <h3><?= h($item->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $this->Html->activeIcon($item->active); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Code') ?></th>
                <td><?= h($item->code) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($item->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Trade Unit') ?></th>
                <td><?= h($item->trade_unit) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Consumer Unit') ?></th>
                <td><?= h($item->consumer_unit) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pack Size') ?></th>
                <td><?= $item->has('pack_size') ? $this->Html->link($item->pack_size->id, ['controller' => 'PackSizes', 'action' => 'view', $item->pack_size->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $item->has('product_type') ? $this->Html->link($item->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $item->product_type->id]) : '' ?>
                </td>
            </tr>
         
            <tr>
                <th scope="row"><?= __('Brand') ?></th>
                <td><?= h($item->brand) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Variant') ?></th>
                <td><?= h($item->variant) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Quantity Description') ?></th>
                <td><?= h($item->quantity_description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Unit Of Measure') ?></th>
                <td><?= h($item->unit_of_measure) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Print Template') ?></th>
                <td><?= $item->has('print_template') ? $this->Html->link($item->print_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $item->print_template->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($item->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Quantity') ?></th>
                <td><?= $this->Number->format($item->quantity) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Unit Net Contents') ?></th>
                <td><?= $this->Number->format($item->unit_net_contents) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Days Life') ?></th>
                <td><?= $this->Number->format($item->days_life) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Min Days Life') ?></th>
                <td><?= $this->Number->format($item->min_days_life) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Carton Label Id') ?></th>
                <td><?= $this->Number->format($item->carton_template_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pallet Label Copies') ?></th>
                <td><?= $this->Number->format($item->pallet_label_copies) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($item->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($item->modified) ?></td>
            </tr>

        </table>
    </div>
    <div class="row">
        <h4><?= __('Item Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($item->item_comment)); ?>
    </div>
</div>