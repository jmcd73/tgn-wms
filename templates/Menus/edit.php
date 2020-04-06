<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 * @var \App\Model\Entity\ParentMenu[]|\Cake\Collection\CollectionInterface $parentMenus
 * @var \App\Model\Entity\ChildMenu[]|\Cake\Collection\CollectionInterface $childMenus
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Menus'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'Menus', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'Menus', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="menus form content">
    <?= $this->Form->create($menu) ?>
    <fieldset>
        <legend><?= __('Edit Menu') ?></legend>
        <?php
            echo $this->Form->control('active');
            echo $this->Form->control('divider');
            echo $this->Form->control('admin_menu');
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('url');
            echo $this->Form->control('title');
            echo $this->Form->control('parent_id', ['options' => $parentMenus, 'empty' => true]);
            echo $this->Form->control('bs_url');
            echo $this->Form->control('extra_args');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>