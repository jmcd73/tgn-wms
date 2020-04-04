<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shift $shift
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Shift'), ['action' => 'edit', $shift->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Shift'), ['action' => 'delete', $shift->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shift->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Shifts'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Shift'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Product Types'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Product Type'), ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="shifts view large-9 medium-8 columns content">
    <h3><?= h($shift->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($shift->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Comment') ?></th>
                <td><?= h($shift->comment) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Type') ?></th>
                <td><?= $shift->has('product_type') ? $this->Html->link($shift->product_type->name, ['controller' => 'ProductTypes', 'action' => 'view', $shift->product_type->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($shift->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Shift Minutes') ?></th>
                <td><?= $this->Number->format($shift->shift_minutes) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($shift->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($shift->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Start Time') ?></th>
                <td><?= h($shift->start_time) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Stop Time') ?></th>
                <td><?= h($shift->stop_time) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $shift->active ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('For Prod Dt') ?></th>
                <td><?= $shift->for_prod_dt ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
</div>
