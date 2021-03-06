<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryStatus $inventoryStatus
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface $productTypes
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inventoryStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryStatus->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>

<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="inventoryStatuses form content">
    <?= $this->Form->create($inventoryStatus) ?>
    <fieldset>
        <legend><?= __('Edit Inventory Status') ?></legend>
        <?php
             echo $this->Form->control('perms', [
                 'multiple' => 'checkbox',
                 'options' => $stockViewPerms,
                 'value' => $inventoryStatus->permArray,
             ]);
            echo $this->Form->control('name');
            echo $this->Form->control('comment');
            echo $this->Form->control('allow_bulk_status_change');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>