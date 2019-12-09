<div class="container">
    <h3><?php echo __('Menu'); ?></h3>
    <dl class="dl-horizontal">
        <dt><?php echo __('Active'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['active']); ?>
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo $this->Html->link($menu['Menu']['name'], [
                    'controller' => 'menus',
                    'action' => 'edit',
                    $menu['Menu']['id']

                ],
                    ['title' => 'Click here to edit this menu']
            ); ?>
        </dd>
        <dt><?php echo __('Url'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['bs_url']); ?>

        </dd>
        <dt><?php echo __('Options'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['options']); ?>

        </dd>
        <dt><?php echo __('Parent Menu'); ?></dt>
        <dd>
            <?php echo $this->Html->link($menu['ParentMenu']['name'], ['controller' => 'menus', 'action' => 'view', $menu['ParentMenu']['id']]); ?>

        </dd>
        <dt><?php echo __('Lft'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['lft']); ?>

        </dd>
        <dt><?php echo __('Rght'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['rght']); ?>

        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['modified']); ?>

        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['created']); ?>

        </dd>
    </dl>


    <div class="row">
        <h3><?php echo __('Related Menus'); ?></h3>
        <?php if (!empty($menu['ChildMenu'])): ?>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <tr>
                <th><?php echo __('Id'); ?></th>

                <th><?php echo __('Active'); ?></th>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Url'); ?></th>
                <th><?php echo __('Options'); ?></th>
                <th><?php echo __('Parent Id'); ?></th>
                <th><?php echo __('Lft'); ?></th>
                <th><?php echo __('Rght'); ?></th>

                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($menu['ChildMenu'] as $childMenu): ?>
            <tr>
                <td><?php echo $childMenu['id']; ?></td>
                <td><?php echo $childMenu['active']; ?></td>
                <td><?php echo $childMenu['name']; ?></td>
                <td><?php echo $childMenu['bs_url']; ?></td>
                <td><?php echo $childMenu['options']; ?></td>
                <td><?php echo $childMenu['parent_id']; ?></td>
                <td><?php echo $childMenu['lft']; ?></td>
                <td><?php echo $childMenu['rght']; ?></td>
                <td class="actions">

                    <div class="row mb1">
                        <div class="col-lg-12">
                            <?php echo $this->Html->link(
                                    __('View'),
                                    ['controller' => 'menus', 'action' => 'view', $childMenu['id']],
                                    [
                                        'class' => 'btn btn-sm view',
                                        'escape' => false
                                    ]
                                );
                                echo $this->Html->link(
                                    __(' Edit'),
                                    ['controller' => 'menus', 'action' => 'edit', $childMenu['id']], [
                                        'class' => 'btn btn-sm view',
                                        'escape' => false
                                    ]);
                                echo $this->Form->postLink(
                                    __(' Delete'),
                                    [
                                        'controller' => 'menus',
                                        'action' => 'delete',
                                        $childMenu['id'],
                                        '?' => [
                                            'redirect' => urlencode($this->request->here)
                                        ]
                                    ], [
                                        'class' => 'btn btn-sm delete',
                                        'escape' => false
                                ], __('Are you sure you want to delete # %s?', $childMenu['id'])); ?>
                        </div>
                    </div>
                    <div class="row mb1">
                        <div class="col-lg-12">
                            <?php
                                echo $this->Form->create(null, [
                                    'url' => [
                                        'action' => 'move',
                                        $childMenu['id']
                                    ],
                                    'class' => 'input-sm up-down-control'
                                ]);
                                echo $this->Form->input('amount', [
                                    'input-group-size' => 'input-group-sm',
                                    'label' => false,
                                    'class' => 'move',
                                    'placeholder' => 'move up/down',
                                    'prepend' => $this->Form->button('<i class="fas fa-caret-up"></i>', [
                                        'type' => 'submit',
                                        'name' => 'data[Menu][moveUp]',
                                        'class' => 'move-up'
                                    ]
                                    ),
                                    'append' => $this->Form->button('<i class="fas fa-caret-down"></i>', [
                                        'type' => 'submit',
                                        'name' => 'data[Menu][moveDown]',
                                        'class' => 'move-down'
                                    ]
                                    )
                                ]);
                                echo $this->Form->end();
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>


    </div>
</div>