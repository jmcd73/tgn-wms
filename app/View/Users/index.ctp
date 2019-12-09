<div class="users index container">

                <h3><?= __('Users'); ?></h3>
        <?= $this->Html->link('Add', [ 'action'=> 'add'], [ 'class' => 'btn add btn-primary mb2 btn-xs'] ); ?>

    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id'); ?></th>
                <th><?= $this->Paginator->sort('active'); ?></th>
                <th><?= $this->Paginator->sort('username'); ?></th>
                <th><?= $this->Paginator->sort('full_name'); ?></th>
                <th><?= $this->Paginator->sort('role'); ?></th>
                <th><?= $this->Paginator->sort('created'); ?></th>
                <th><?= $this->Paginator->sort('modified'); ?></th>
                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user['User']['id']); ?></td>
                    <td><?= h($user['User']['active']); ?></td>
                    <td><?= h($user['User']['username']); ?></td>
                    <td><?= h($user['User']['full_name']); ?></td>
                    <td><?= h($user['User']['role']); ?></td>
                    <td><?= h($user['User']['created']); ?></td>
                    <td><?= h($user['User']['modified']); ?></td>
                    <td class="actions">
                        <?= $this->Html->link(
                            __('View'),
                            ['action' => 'view', $user['User']['id']],
                            [ 'class' => 'btn btn-link btn-sm view']
                            ); ?>
                        <?= $this->Html->link(
                            __('Edit'), ['action' => 'edit',
                            $user['User']['id']],
                            [ 'class' => 'btn btn-link btn-sm edit']
                            ); ?>
    <?= $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $user['User']['id']],
        [    'class' => 'btn btn-link  btn-sm delete',
            'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id'])]); ?>
                    </td>
                </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter([
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ]);
        ?>	</p>
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
<div class="actions">
    <h3><?= __('Actions'); ?></h3>
    <ul>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']); ?></li>
    </ul>
</div>
