<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Printer $printer
 * @var \App\Model\Entity\Label[]|\Cake\Collection\CollectionInterface $labels
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface $pallets
 * @var \App\Model\Entity\ProductionLine[]|\Cake\Collection\CollectionInterface $productionLines
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $printer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printer->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Printers'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Labels'), ['controller' => 'Labels', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Label'), ['controller' => 'Labels', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Pallet'), ['controller' => 'Pallets', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Production Lines'), ['controller' => 'ProductionLines', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Production Line'), ['controller' => 'ProductionLines', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="printers form content">
    <?= $this->Form->create($printer) ?>
    <fieldset>
        <legend><?= __('Edit Printer') ?></legend>

        <?php

            echo $this->Form->control('active');
            echo $this->Form->control('name');
            echo $this->Form->control('options');
            echo $this->Form->control('queue_name');
            echo $this->Form->control('set_as_default_on_these_actions', [
                'type' => 'select',
                'multiple' => 'checkbox',
                'options' => $setAsDefaultOnTheseActions,
                'value' => $printer['array_of_actions'],
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>