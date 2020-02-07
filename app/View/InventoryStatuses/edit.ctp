<?php $form_options = [
    'class' => 'form-horizontal',
    'inputDefaults' => [
        'format' => [
            //'before', 'input', 'between', 'label', 'after','error'
            'label', 'before', 'input', 'after', 'between', 'error',
        ],
        'label' => [
            'class' => 'col-md-2 form-label',
        ],
        'before' => '<div class=col-md-4>',
        'after' => '</div>',
        'class' => 'form-control',
        'div' => [
            'class' => 'form-group',
        ],
    ],
]; ?>
<div class="container">
    <?= $this->Form->create('InventoryStatus'); ?>
    <fieldset>
        <legend><?= __('Edit Inventory Status'); ?></legend>
        <?php echo $this->Form->input('id');
            echo $this->Form->input('allow_bulk_status_change');
        echo $this->Form->input('name');
        echo $this->Form->input('comment');

        echo $this->Form->input('StockViewPerms', [
            'options' => $stockViewPerms,
            'multiple' => 'checkbox',
        ]); ?>
    </fieldset>
    <?= $this->Form->end([
        'bootstrap-type' => 'primary',
    ]); ?>
</div>