<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Menu'), ['action' => 'edit', $menu->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Menu'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Menus'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Menu'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'Menus', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'Menus', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Child Menus'), ['controller' => 'Menus', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Child Menu'), ['controller' => 'Menus', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="menus view large-9 medium-8 columns content">
    <h3><?= h($menu->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($menu->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($menu->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Url') ?></th>
                <td><?= h($menu->url) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Options') ?></th>
                <td><?= h($menu->options) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Title') ?></th>
                <td><?= h($menu->title) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Parent Menu') ?></th>
                <td><?= $menu->has('parent_menu') ? $this->Html->link($menu->parent_menu->name, ['controller' => 'Menus', 'action' => 'view', $menu->parent_menu->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Bs Url') ?></th>
                <td><?= h($menu->bs_url) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Extra Args') ?></th>
                <td><?= h($menu->extra_args) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($menu->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Lft') ?></th>
                <td><?= $this->Number->format($menu->lft) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Rght') ?></th>
                <td><?= $this->Number->format($menu->rght) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($menu->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($menu->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $menu->active ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Divider') ?></th>
                <td><?= $menu->divider ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Header') ?></th>
                <td><?= $menu->header ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Admin Menu') ?></th>
                <td><?= $menu->admin_menu ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Menus') ?></h4>
        <?php if (!empty($menu->child_menus)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Divider') ?></th>
                    <th scope="col"><?= __('Header') ?></th>
                    <th scope="col"><?= __('Admin Menu') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Url') ?></th>
                    <th scope="col"><?= __('Options') ?></th>
                    <th scope="col"><?= __('Title') ?></th>
                    <th scope="col"><?= __('Parent Id') ?></th>
                    <th scope="col"><?= __('Lft') ?></th>
                    <th scope="col"><?= __('Rght') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Bs Url') ?></th>
                    <th scope="col"><?= __('Extra Args') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($menu->child_menus as $childMenus): ?>
                <tr>
                    <td><?= h($childMenus->id) ?></td>
                    <td><?= h($childMenus->active) ?></td>
                    <td><?= h($childMenus->divider) ?></td>
                    <td><?= h($childMenus->header) ?></td>
                    <td><?= h($childMenus->admin_menu) ?></td>
                    <td><?= h($childMenus->name) ?></td>
                    <td><?= h($childMenus->description) ?></td>
                    <td><?= h($childMenus->url) ?></td>
                    <td><?= h($childMenus->options) ?></td>
                    <td><?= h($childMenus->title) ?></td>
                    <td><?= h($childMenus->parent_id) ?></td>
                    <td><?= h($childMenus->lft) ?></td>
                    <td><?= h($childMenus->rght) ?></td>
                    <td><?= h($childMenus->modified) ?></td>
                    <td><?= h($childMenus->created) ?></td>
                    <td><?= h($childMenus->bs_url) ?></td>
                    <td><?= h($childMenus->extra_args) ?></td>
                    <td class="actions">
                        <?php
                                echo $this->Form->create(null, [
                                    'style' => 'width: 120px',
                                    'url' => [
                                        'action' => 'move',
                                        $childMenus->id,
                                    ],
                                ]);
                                echo $this->Form->control('amount', [
                                    'prepend' => $this->Form->button(
                                        '',
                                        [
                                            'type' => 'submit',
                                            'name' => 'moveUp',
                                            'class' => 'move-up',
                                        ]
                                    ),
                                    'append' => $this->Form->button(
                                        '',
                                        [
                                            'type' => 'submit',
                                            'name' => 'moveDown',
                                            'class' => 'move-down',
                                        ]
                                    ),
                                ]);
                                echo $this->Form->end();
                            ?>
                        <?= $this->Html->link(__('View'), ['controller' => 'Menus', 'action' => 'view', $childMenus->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Menus', 'action' => 'edit', $childMenus->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Menus', 'action' => 'delete', $childMenus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childMenus->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>