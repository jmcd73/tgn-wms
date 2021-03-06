<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Carton $carton
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Carton'), ['action' => 'edit', $carton->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Carton'), ['action' => 'delete', $carton->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carton->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Cartons'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Carton'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Pallets'), ['controller' => 'Pallets', 'action' => 'index'], ['class' => 'nav-link']) ?></li>

<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="cartons view large-9 medium-8 columns content">
    <h3><?= h($carton->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Pallet') ?></th>
                <td><?= $carton->has('pallet') ? $this->Html->link($carton->pallet->pl_ref, ['controller' => 'Pallets', 'action' => 'view', $carton->pallet->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Cartons') ?></th>
                <td><?= $this->Number->format($carton->count) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Production Date') ?></th>
                <td><?= h($carton->production_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Best Before') ?></th>
                <td><?= h($carton->best_before) ?></td>
            </tr>
           
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($carton->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($carton->modified) ?></td>
            </tr>
        </table>
    </div>
</div>
