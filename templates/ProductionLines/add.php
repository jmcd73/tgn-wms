<?php
/**
 * @var \App\View\AppView                                                    $this
 * @var \App\Model\Entity\ProductionLine                                     $productionLine
 * @var \App\Model\Entity\Printer[]|\Cake\Collection\CollectionInterface     $printers
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface $productTypes
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface      $pallets
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Production Lines'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Printers'), ['controller' => 'Printers', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Printer'), ['controller' => 'Printers', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
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

<div class="productionLines form content">
    <?= $this->Form->create($productionLine) ?>
    <fieldset>
        <legend><?= __('Add Production Line') ?></legend>
        <?php
            echo $this->Form->control('active', ['default' => 1]);
            echo $this->Form->control('printer_id', ['options' => $printers, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('product_type_id', ['options' => $productTypes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>