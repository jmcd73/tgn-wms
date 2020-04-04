<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Help $help
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Help'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="help form content">
    <?= $this->Form->create($help) ?>
    <fieldset>
        <legend><?= __('Add Help') ?></legend>
        <?php
            echo $this->Form->control('controller_action');
            echo $this->Form->control('markdown_document');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
