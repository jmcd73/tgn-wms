<div class="container">
    <?= $this->Form->create('Location'); ?>
    <fieldset>
        <legend><?= __('Add Location'); ?></legend>
        <?php
        echo $this->Form->input('location');
        echo $this->Form->input('description');
        echo $this->Form->input('pallet_capacity');

        echo $this->Form->input('product_type_id', [
            'empty' => '(select)',
            'options' => $productTypes
        ]);
        ?>
    </fieldset>

    <?= $this->Form->button(__('Submit'), ['bootstrap-type' => 'primary']); ?>


</div>

