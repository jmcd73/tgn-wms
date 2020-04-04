<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PrintTemplate $printTemplate
 * @var \App\Model\Entity\ParentPrintTemplate[]|\Cake\Collection\CollectionInterface $parentPrintTemplates
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 * @var \App\Model\Entity\ChildPrintTemplate[]|\Cake\Collection\CollectionInterface $childPrintTemplates
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Print Templates'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Parent Print Templates'), ['controller' => 'PrintTemplates', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Parent Print Template'), ['controller' => 'PrintTemplates', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="printTemplates form content">
    <?= $this->Form->create($printTemplate) ?>
    <fieldset>
        <legend><?= __('Add Print Template') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('text_template');
            echo $this->Form->control('file_template');
            echo $this->Form->control('active');
            echo $this->Form->control('is_file_template');
            echo $this->Form->control('print_action');
            echo $this->Form->control('print_controller');
            echo $this->Form->control('example_image');
            echo $this->Form->control('file_template_type');
            echo $this->Form->control('file_template_size');
            echo $this->Form->control('example_image_size');
            echo $this->Form->control('example_image_type');
            echo $this->Form->control('show_in_label_chooser');
            echo $this->Form->control('parent_id', ['options' => $parentPrintTemplates, 'empty' => true]);
            echo $this->Form->control('lft');
            echo $this->Form->control('rght');
            echo $this->Form->control('replace_tokens');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
