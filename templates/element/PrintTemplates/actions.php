<div class="form-row">
<?php
echo $this->Form->create(null, [
    'style' => 'width: 80px;',
    'url' => [
        'action' => 'move',
        $id,
    ],
]);
echo $this->Form->control('amount', [
    'label' => false,
    'placeholder' => '1',
    'class' => 'form-control-sm',
    'prepend' => $this->Form->button(
        '',
        [
            'type' => 'submit',
            'name' => 'moveUp',
            'class' => 'move-up btn-sm btn-secondary',
        ]
    ),
    'append' => $this->Form->button(
        '',
        [
            'type' => 'submit',
            'name' => 'moveDown',
            'class' => 'move-down btn-sm btn-secondary',
        ]
    ),
]);
echo $this->Form->end(); ?>
<div class="col">
<?= $this->Html->link(__('View'), ['action' => 'view', $id], ['title' => __('View'), 'class' => 'btn btn-secondary btn-sm mr-1 mb-1']) ?>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $id], ['title' => __('Edit'), 'class' => 'btn btn-secondary btn-sm mr-1 mb-1']) ?>
<?= $this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $id],
    [
        'confirm' => __('Are you sure you want to delete # {0}?', $id),
        'title' => __('Delete'),
        'class' => 'btn btn-danger btn-sm mb-1',
    ]
) ?>
</div>

</div>