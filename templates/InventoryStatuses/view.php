<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryStatus $inventoryStatus
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Inventory Status'), ['action' => 'edit', $inventoryStatus->id], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Form->postLink(__('Delete Inventory Status'), ['action' => 'delete', $inventoryStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryStatus->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Inventory Status'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>

<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="inventoryStatuses view large-9 medium-8 columns content">
    <h3><?= h($inventoryStatus->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($inventoryStatus->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Comment') ?></th>
                <td><?= h($inventoryStatus->comment) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($inventoryStatus->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Perms') ?></th>
                <td><?php
                       echo $this->Form->control('StockViewPerms', [
                           'label' => false,
                           'options' => $stockViewPerms,
                           'value' => $inventoryStatus->permArray,
                           'multiple' => 'checkbox',
                           'disabled' => true,
                       ]); ?>
                </td>
                <!-- <td><?= $this->Number->format($inventoryStatus->perms) ?></td> -->
            </tr>
            <tr>
                <th scope="row"><?= __('Allow Bulk Status Change') ?></th>
                <td><?= $inventoryStatus->allow_bulk_status_change ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Product Types') ?></h4>
        <?php if (!empty($inventoryStatus->product_types)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Inventory Status Id') ?></th>
                    <th scope="col"><?= __('Location Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Code Prefix') ?></th>
                    <th scope="col"><?= __('Storage Temperature') ?></th>
                    <th scope="col"><?= __('Code Regex') ?></th>
                    <th scope="col"><?= __('Code Regex Description') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Next Serial Number') ?></th>
                    <th scope="col"><?= __('Serial Number Format') ?></th>
                    <th scope="col"><?= __('Enable Pick App') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($inventoryStatus->product_types as $productTypes): ?>
                <tr>
                    <td><?= h($productTypes->id) ?></td>
                    <td><?= h($productTypes->inventory_status_id) ?></td>
                    <td><?= h($productTypes->location_id) ?></td>
                    <td><?= h($productTypes->name) ?></td>
                    <td><?= h($productTypes->storage_temperature) ?></td>
                    <td><?= h($productTypes->code_regex) ?></td>
                    <td><?= h($productTypes->code_regex_description) ?></td>
                    <td><?= $this->Html->activeIcon($productTypes->active); ?></td>
                    <td><?= h($productTypes->next_serial_number) ?></td>
                    <td><?= h($productTypes->serial_number_format) ?></td>
                    <td><?= h($productTypes->enable_pick_app) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'ProductTypes', 'action' => 'view', $productTypes->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'ProductTypes', 'action' => 'edit', $productTypes->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProductTypes', 'action' => 'delete', $productTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productTypes->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>