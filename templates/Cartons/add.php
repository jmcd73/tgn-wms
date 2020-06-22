<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Carton $carton
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Cartons'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>

<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="cartons form content">
    <?= $this->Form->create($carton) ?>
    <fieldset>
        <legend><?= __('Add Carton') ?></legend>
        <?php
        echo $this->Form->control('pallet_id', ['options' => $pallets, 'empty' => true]);
        echo $this->Form->control('count');
        echo $this->Form->control('best_before', ['empty' => true]);
        echo $this->Form->control('production_date', ['empty' => true]);
        echo $this->Form->control('item_id', ['options' => $items, 'empty' => true]);
        echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>