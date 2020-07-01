<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Locations'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="locations view large-9 medium-8 columns content">
    <h3><?= h($location->location) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Location') ?></th>
                <td><?= h($location->location) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($location->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($location->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pallet Capacity') ?></th>
                <td><?= $this->Number->format($location->pallet_capacity) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type Id') ?></th>
                <td><?= $this->Number->format($location->product_type_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($location->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($location->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Is Hidden') ?></th>
                <td><?= $location->is_hidden ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Product Types') ?></h4>
        <?php if (!empty($location->product_type)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Name') ?></th>
                    
                    <th scope="col"><?= __('Storage Temperature') ?></th>
                    <th scope="col"><?= __('Code Regex') ?></th>
                    <th scope="col"><?= __('Code Regex Description') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Next Serial Number') ?></th>
                    <th scope="col"><?= __('Serial Number Format') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php $productType = $location->product_type;  ?>
                <tr>
                    <td><?= h($productType->name) ?></td>
                    <td><?= h($productType->storage_temperature) ?></td>
                    <td><?= h($productType->code_regex) ?></td>
                    <td><?= h($productType->code_regex_description) ?></td>
                    <td><?= $this->Html->activeIcon($productType->active); ?></td>
                    <td><?= h($productType->next_serial_number) ?></td>
                    <td><?= h($productType->serial_number_format) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'ProductTypes', 'action' => 'view', $productType->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'ProductTypes', 'action' => 'edit', $productType->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProductTypes', 'action' => 'delete', $productType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productType->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>