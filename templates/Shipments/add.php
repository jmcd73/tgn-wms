<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shipment $shipment
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface $productTypes
 * @var \App\Model\Entity\Label[]|\Cake\Collection\CollectionInterface $labels
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Shipments'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['controller' => 'Labels', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Label'), ['controller' => 'Labels', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="shipments form content">
    <?= $this->Form->create($shipment) ?>
    <fieldset>
        <legend><?= __('Add Shipment') ?></legend>
        <?php
            echo $this->Form->control('operator_id');
            echo $this->Form->control('truck_registration_id');
            echo $this->Form->control('shipper');
            echo $this->Form->control('con_note');
            echo $this->Form->control('shipment_type');
            echo $this->Form->control('product_type_id', ['options' => $productTypes, 'empty' => true]);
            echo $this->Form->control('destination');
            echo $this->Form->control('pallet_count');
            echo $this->Form->control('shipped');
            echo $this->Form->control('time_start', ['empty' => true]);
            echo $this->Form->control('time_finish', ['empty' => true]);
            echo $this->Form->control('time_total');
            echo $this->Form->control('truck_temp');
            echo $this->Form->control('dock_temp');
            echo $this->Form->control('product_temp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
