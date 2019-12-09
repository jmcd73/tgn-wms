<div class="container">
<div class="row">
<div class="col-lg-2">
<h3><?=__('Fast Edit'); ?></h3>


<?=$this->Form->create(null, [
    'url' => [
        'controller' => 'menus',
        'action' => 'edit'
    ]
]); ?>
<?=$this->Form->input('edit_menu', [
    'type' => 'select',
    'empty' => '(select)',
    'options' => $edit_menus
]); ?>

<?=$this->Form->end(
    ['label' => 'Edit', 'bootstrap-type' => 'primary']
); ?>
</div>

<div class="col-lg-10">

<h2><?=__('Menus'); ?></h2>
    <?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn btn-primary mb2 add btn-xs']); ?>
        <p><strong>Warning:</strong> Do not change these settings unless you know what you are doing</p>
	<table class="table table-bordered table-condensed table-responsive table-striped">
	<thead>
	<tr>
            <th><?=$this->Paginator->sort('name'); ?></th>
            <th><?=$this->Paginator->sort('description'); ?></th>
            <th><?=$this->Paginator->sort('active'); ?></th>
            <th><?=$this->Paginator->sort('id'); ?></th>


            <th class="actions"><?=__('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($menus as $menu): ?>
	<tr>
                <td>
                <?php $prefix = !empty($menu['ParentMenu']['id']) ? '&nbsp;&nbsp;--&nbsp;&nbsp;' : ""; ?>
                <?=$prefix . h($menu['Menu']['name']); ?></td>
                <td><?=h($menu['Menu']['description']); ?></td>
                <td><?=h($menu['Menu']['active']); ?></td>
                <td><?=h($menu['Menu']['id']); ?></td>
                <td class="actions">
                    <div class="row">
                        <div class="col-lg-12">
                        <?php
                            echo $this->Html->link(
                                __('View'),
                                [
                                    'action' => 'view',
                                    $menu['Menu']['id']
                                ],
                                [
                                    'class' => 'btn view btn-link btn-sm btn-sm'
                                ]
                            );
                            echo $this->Html->link(
                                __('Edit'),
                                [
                                    'action' => 'edit',
                                    $menu['Menu']['id']
                                ],
                                [
                                    'class' => 'btn edit btn-link btn-sm'
                                ]
                            );
                            echo $this->Form->postLink(
                                __('Delete'),
                                [
                                    'action' => 'delete',
                                    $menu['Menu']['id'],
                                    '?' => [
                                        'redirect' => urlencode($this->request->here)
                                    ]

                                ],
                                [
                                    'class' => 'btn delete btn-link btn-sm',
                                    'confirm' => __('Are you sure you want to delete # %s?', $menu['Menu']['id'])
                                ]
                        ); ?>
                    </div>
                    </div>
                    <div class="row mb1">
                            <div class="col-lg-12">
                            <?php
                                echo $this->Form->create(null, [
                                    'url' => [
                                        'action' => 'move',
                                        $menu['Menu']['id']
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
</div>
</div>
