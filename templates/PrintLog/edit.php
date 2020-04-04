<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PrintLog $printLog
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $printLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printLog->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Print Log'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="printLog form content">
    <?= $this->Form->create($printLog) ?>
    <fieldset>
        <legend><?= __('Edit Print Log') ?></legend>
        <?php
            echo $this->Form->control('print_data');
            echo $this->Form->control('print_action');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
