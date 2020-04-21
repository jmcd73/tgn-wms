<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php

function processMenu($menus, $obj)
{
    echo '<ul>';
    foreach ($menus as $menu) {
        if ($menu->parent_id !== null) {
            $actions = '<div class="row"><div class="form-row col-6"><div class="col-3">';

            $actions .= $obj->Form->create(null, [
                'url' => [
                    'action' => 'move',
                    $menu->id,
                ],
            ]);
            $actions .= $obj->Form->control('amount', [
                'label' => false,
                'class' => 'form-control-sm',
                'prepend' => $obj->Form->button(
                    '',
                    [
                        'type' => 'submit',
                        'name' => 'moveUp',
                        'class' => 'move-up btn-sm btn-secondary',
                    ]
                ),
                'append' => $obj->Form->button(
                    '',
                    [
                        'type' => 'submit',
                        'name' => 'moveDown',
                        'class' => 'move-down btn-sm btn-secondary',
                    ]
                ),
            ]);
            $actions .= $obj->Form->end();
            $actions .= '</div><div class="col-3 text-center">';
            $actions .= $obj->Html->link(__('View'), ['action' => 'view', $menu->id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm']);
            $actions .= '</div><div class="col-3 text-center">';
            $actions .= $obj->Html->link(__('Edit'), ['action' => 'edit', $menu->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm']);
            $actions .= '</div><div class="col-3 text-center">';
            $actions .= $obj->Form->postLink(__('Delete'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id), 'title' => __('Delete'), 'class' => 'btn btn-sm btn-danger']);
            $actions .= '</div></div></div>';
        } else {
            $actions = '';
        }

        echo $obj->Html->tag('li', $menu->name . $actions);

        if ($menu->has('children')) {
            processMenu($menu->children, $obj);
        }
    }
    echo '</ul>';
}

?>

<?php processMenu($menus, $this); ?>