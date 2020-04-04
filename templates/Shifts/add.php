<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shift $shift
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface $productTypes
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Shifts'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="shifts form content">
    <?= $this->Form->create($shift) ?>
    <fieldset>
        <legend><?= __('Add Shift') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('shift_minutes');
            echo $this->Form->control('comment');
            echo $this->Form->control('active');
            echo $this->Form->control('for_prod_dt');
            echo $this->Form->control('start_time');
            echo $this->Form->control('stop_time');
            echo $this->Form->control('product_type_id', ['options' => $productTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
