<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shipment $shipment
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface $productTypes
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shipment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipment->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Shipments'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="shipments form content">
    <?= $this->Form->create($shipment) ?>
    <fieldset>
        <legend><?= __('Edit Shipment') ?></legend>
        <?php
            echo $this->Form->control('shipper');
            echo $this->Form->control('product_type_id', ['options' => $productTypes, 'empty' => true]);
            echo $this->Form->control('destination');
            echo $this->Form->control('pallet_count');
            echo $this->Form->control('shipped');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>