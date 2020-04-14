<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductType $productType
 * @var \App\Model\Entity\InventoryStatus[]|\Cake\Collection\CollectionInterface $inventoryStatuses
 * @var \App\Model\Entity\Location[]|\Cake\Collection\CollectionInterface $locations
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 * @var \App\Model\Entity\ProductionLine[]|\Cake\Collection\CollectionInterface $productionLines
 * @var \App\Model\Entity\Shift[]|\Cake\Collection\CollectionInterface $shifts
 * @var \App\Model\Entity\Shipment[]|\Cake\Collection\CollectionInterface $shipments
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $productType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productType->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Product Types'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['controller' => 'InventoryStatuses', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Inventory Status'), ['controller' => 'InventoryStatuses', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Production Lines'), ['controller' => 'ProductionLines', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Production Line'), ['controller' => 'ProductionLines', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Shifts'), ['controller' => 'Shifts', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Shift'), ['controller' => 'Shifts', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Shipments'), ['controller' => 'Shipments', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Shipment'), ['controller' => 'Shipments', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="productTypes form content">
    <?= $this->Form->create($productType) ?>
    <fieldset>
        <legend><?= __('Edit Product Type') ?></legend>
        <?php
            echo $this->Form->control('inventory_status_id', ['options' => $inventoryStatuses, 'empty' => true]);
            echo $this->Form->control('location_id');
            echo $this->Form->control('name');
            echo $this->Form->control('storage_temperature');
            echo $this->Form->control('code_regex');
            echo $this->Form->control('code_regex_description');
            echo $this->Form->control('active');
            echo $this->Form->control('next_serial_number');
            echo $this->Form->control('serial_number_format');
            echo $this->Form->control('enable_pick_app');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>