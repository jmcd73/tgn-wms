<?php
/**
 * @var \App\View\AppView                                             $this
 * @var \App\Model\Entity\Menu[]|\Cake\Collection\CollectionInterface $menus
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Menu'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
        <tr>
           
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('divider') ?></th>
            <th scope="col"><?= $this->Paginator->sort('admin_menu') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col"><?= $this->Paginator->sort('url') ?></th>
            <th scope="col"><?= $this->Paginator->sort('title') ?></th>
            <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('bs_url') ?></th>
            <th scope="col"><?= $this->Paginator->sort('extra_args') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menus as $menu) : ?>
        <tr>
            <td><?= $this->Html->activeIcon($menu->active); ?></td>
            <td><?= h($menu->divider) ?></td>
            <td><?= h($menu->admin_menu) ?></td>
            <td><?= h($menu->name) ?></td>
            <td><?= h($menu->description) ?></td>
            <td><?= h($menu->url) ?></td>
            <td><?= h($menu->title) ?></td>
            <td><?= $menu->has('parent_menu') ? $this->Html->link($menu->parent_menu->name, ['controller' => 'Menus', 'action' => 'view', $menu->parent_menu->id]) : '' ?>
            </td>
            <td><?= h($menu->bs_url) ?></td>
            <td><?= h($menu->extra_args) ?></td>
            <td><?= h($menu->modified) ?></td>
            <td><?= h($menu->created) ?></td>
            <td class="actions">
                <?php
                                echo $this->Form->create(null, [
                                    'class' => 'menu',
                                    'align' => 'inline',
                                    'url' => [
                                        'action' => 'move',
                                        $menu->id,
                                    ],
                                ]);
                                echo $this->Form->control('amount', [
                                    'label' => false,
                                    'class' => 'mb-1 form-control form-control-sm',
                                    'title' => "Move menu up or down by one or enter a number to move multiple steps",
                                    'prepend' => $this->Form->button(
                                        '',
                                        [
                                            'type' => 'submit',
                                            'name' => 'moveUp',
                                            'class' => 'mb-1 btn btn-secondary move-up btn-sm',
                                        ]
                                    ),
                                    'append' => $this->Form->button(
                                        '',
                                        [
                                            'type' => 'submit',
                                            'name' => 'moveDown',
                                            'class' => 'mb-1 move-down btn btn-secondary btn-sm',
                                        ]
                                    ),
                                ]);
                                echo $this->Form->end();
                            ?>
                <?= $this->Html->link(__('View'), ['action' => 'view', $menu->id], ['title' => __('View'), 'class' => 'mb-1 btn btn-secondary btn-sm']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menu->id], ['title' => __('Edit'), 'class' => 'mb-1 btn btn-secondary btn-sm']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id), 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>