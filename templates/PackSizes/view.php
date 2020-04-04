<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PackSize $packSize
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Pack Size'), ['action' => 'edit', $packSize->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Pack Size'), ['action' => 'delete', $packSize->id], ['confirm' => __('Are you sure you want to delete # {0}?', $packSize->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pack Sizes'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Pack Size'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="packSizes view large-9 medium-8 columns content">
    <h3><?= h($packSize->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Pack Size') ?></th>
                <td><?= h($packSize->pack_size) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Comment') ?></th>
                <td><?= h($packSize->comment) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($packSize->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($packSize->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($packSize->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($packSize->items)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Code') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Quantity') ?></th>
                    <th scope="col"><?= __('Trade Unit') ?></th>
                    <th scope="col"><?= __('Pack Size Id') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col"><?= __('Consumer Unit') ?></th>
                    <th scope="col"><?= __('Brand') ?></th>
                    <th scope="col"><?= __('Variant') ?></th>
                    <th scope="col"><?= __('Unit Net Contents') ?></th>
                    <th scope="col"><?= __('Unit Of Measure') ?></th>
                    <th scope="col"><?= __('Days Life') ?></th>
                    <th scope="col"><?= __('Min Days Life') ?></th>
                    <th scope="col"><?= __('Item Comment') ?></th>
                    <th scope="col"><?= __('Print Template Id') ?></th>
                    <th scope="col"><?= __('Carton Label Id') ?></th>
                    <th scope="col"><?= __('Pallet Label Copies') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($packSize->items as $items): ?>
                <tr>
                    <td><?= h($items->id) ?></td>
                    <td><?= h($items->active) ?></td>
                    <td><?= h($items->code) ?></td>
                    <td><?= h($items->description) ?></td>
                    <td><?= h($items->quantity) ?></td>
                    <td><?= h($items->trade_unit) ?></td>
                    <td><?= h($items->pack_size_id) ?></td>
                    <td><?= h($items->product_type_id) ?></td>
                    <td><?= h($items->consumer_unit) ?></td>
                    <td><?= h($items->brand) ?></td>
                    <td><?= h($items->variant) ?></td>
                    <td><?= h($items->unit_net_contents) ?></td>
                    <td><?= h($items->unit_of_measure) ?></td>
                    <td><?= h($items->days_life) ?></td>
                    <td><?= h($items->min_days_life) ?></td>
                    <td><?= h($items->item_comment) ?></td>
                    <td><?= h($items->print_template_id) ?></td>
                    <td><?= h($items->carton_label_id) ?></td>
                    <td><?= h($items->pallet_label_copies) ?></td>
                    <td><?= h($items->created) ?></td>
                    <td><?= h($items->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
