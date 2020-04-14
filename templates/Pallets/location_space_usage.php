<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<?php $this->start('tb_actions'); ?>
<div class="col">
    <h3>Actions</h3>
    <ul class="nav flex-column">
        <?php $active = $filter === 'all' ? 'active' : null ;?>
        <li><?= $this->Html->link('All Locations', [
            'action' => 'locationSpaceUsage',
            'all', ], ['class' => 'nav-link ' . $active]); ?>
        </li>
        <?php $active = $filter === 'available' ? 'active' : null ;?>
        <li><?= $this->Html->link('Space Available', [
            'action' => 'locationSpaceUsage',
            'available', ], ['class' => 'nav-link ' . $active]); ?>
        </li>
        <?php $active = $filter === 'full' ? 'active' : null ;?>
        <li><?= $this->Html->link('Full', [
            'action' => 'locationSpaceUsage',
            'full', ], ['class' => 'nav-link ' . $active]); ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', $this->fetch('tb_actions')); ?>
<div class="row">
    <div class="col">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('location'); ?></th>
                    <th><?= $this->Paginator->sort('pallet_capacity', 'Location Capacity'); ?></th>
                    <th><?= $this->Paginator->sort('pallets', 'Current Pallet Count'); ?></th>
                    <th><?= $this->Paginator->sort('hasSpace'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locations as $location): ?>
                <tr class="<?= $location['hasSpace'] ? 'success' : 'danger';?>">
                    <td><?= h($location['location']); ?></td>
                    <td><?= h($location['pallet_capacity']); ?></td>
                    <td><?= h($location['pallets']); ?></td>
                    <td><?=
                        $location['hasSpace'] ?
                        $this->Html->icon('check-circle')
                        : $this->Html->icon('times-circle'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <?php
    echo $this->Paginator->counter(
                            'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}'
                        );
    ?> </p>
        <div class="pagination pagination-large">
            <ul class="pagination">
                <?php
            echo $this->Paginator->first('&laquo; first', ['escape' => false, 'tag' => 'li']);
            echo $this->Paginator->prev('&lsaquo; ' . __('previous'), ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->numbers(['separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1, 'ellipsis' => null]);
            echo $this->Paginator->next(__('next') . ' &rsaquo;', ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->last('last &raquo;', ['escape' => false, 'tag' => 'li']);
            ?>
            </ul>
        </div>
    </div>
</div>