<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Label $label
 * @var \App\Model\Entity\ProductionLine[]|\Cake\Collection\CollectionInterface $productionLines
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 * @var \App\Model\Entity\Printer[]|\Cake\Collection\CollectionInterface $printers
 * @var \App\Model\Entity\Location[]|\Cake\Collection\CollectionInterface $locations
 * @var \App\Model\Entity\Shipment[]|\Cake\Collection\CollectionInterface $shipments
 * @var \App\Model\Entity\InventoryStatus[]|\Cake\Collection\CollectionInterface $inventoryStatuses
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface $productTypes
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $label->id], ['confirm' => __('Are you sure you want to delete # {0}?', $label->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Production Lines'), ['controller' => 'ProductionLines', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Production Line'), ['controller' => 'ProductionLines', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Printers'), ['controller' => 'Printers', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Printer'), ['controller' => 'Printers', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Shipments'), ['controller' => 'Shipments', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Shipment'), ['controller' => 'Shipments', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Inventory Statuses'), ['controller' => 'InventoryStatuses', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Inventory Status'), ['controller' => 'InventoryStatuses', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="labels form content">
    <?= $this->Form->create($label) ?>
    <fieldset>
        <legend><?= __('Edit Label') ?></legend>
        <?php
            echo $this->Form->control('production_line_id', ['options' => $productionLines, 'empty' => true]);
            echo $this->Form->control('item');
            echo $this->Form->control('description');
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('best_before');
            echo $this->Form->control('bb_date');
            echo $this->Form->control('gtin14');
            echo $this->Form->control('qty_user_id');
            echo $this->Form->control('qty');
            echo $this->Form->control('qty_previous');
            echo $this->Form->control('qty_modified');
            echo $this->Form->control('pl_ref');
            echo $this->Form->control('sscc');
            echo $this->Form->control('batch');
            echo $this->Form->control('printer_id', ['options' => $printers]);
            echo $this->Form->control('print_date');
            echo $this->Form->control('cooldown_date', ['empty' => true]);
            echo $this->Form->control('min_days_life');
            echo $this->Form->control('production_line');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('shipment_id', ['options' => $shipments]);
            echo $this->Form->control('inventory_status_id', ['options' => $inventoryStatuses]);
            echo $this->Form->control('inventory_status_note');
            echo $this->Form->control('inventory_status_datetime');
            echo $this->Form->control('ship_low_date');
            echo $this->Form->control('picked');
            echo $this->Form->control('product_type_id', ['options' => $productTypes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
