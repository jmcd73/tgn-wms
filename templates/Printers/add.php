<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Printer $printer
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 * @var \App\Model\Entity\ProductionLine[]|\Cake\Collection\CollectionInterface $productionLines
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Printer'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Printers'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="printers form content">
    <?= $this->Form->create($printer) ?>
    <fieldset>
        <legend><?= __('Add Printer') ?></legend>
        <?php
            echo $this->Form->control('active');
            echo $this->Form->control('name');
            echo $this->Form->control('options');
            echo $this->Form->control(
                'queue_name'
            );
            echo $this->Form->control('set_as_default_on_these_actions', [
                'type' => 'select',
                'multiple' => 'checkbox',
            ]);

        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>