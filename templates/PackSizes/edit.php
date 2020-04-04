<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PackSize $packSize
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $packSize->id], ['confirm' => __('Are you sure you want to delete # {0}?', $packSize->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Pack Sizes'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="packSizes form content">
    <?= $this->Form->create($packSize) ?>
    <fieldset>
        <legend><?= __('Edit Pack Size') ?></legend>
        <?php
            echo $this->Form->control('pack_size');
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
