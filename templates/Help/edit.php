<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Help $help
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $help->id], ['confirm' => __('Are you sure you want to delete # {0}?', $help->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Help'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="help form content">
    <?= $this->Form->create($help) ?>
    <fieldset>
        <legend><?= __('Edit Help') ?></legend>
        <?php
            echo $this->Form->control('controller_action');
            echo $this->Form->control('markdown_document');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
