<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Settings'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="settings form content">
    <?= $this->Form->create($setting) ?>
    <fieldset>
        <legend><?= __('Edit Setting') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('setting');
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
