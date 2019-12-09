<div class="container">
    <?= $this->Form->create('Pallet'); ?>
    <fieldset>
        <legend><?= __('Edit Pallet'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('item');
        echo $this->Form->input('description');
        echo $this->Form->input('best_before');
        echo $this->Form->input('gtin14');
        echo $this->Form->input('qty');
        echo $this->Form->input('pl_ref');
        echo $this->Form->input('sscc');
        echo $this->Form->input('batch');
        echo $this->Form->input('printer');
        echo $this->Form->input('print_date');
        echo $this->Form->input('location_id');
        echo $this->Form->input('shipment_id', ['empty' => true]);
           echo $this->Form->hidden('dont_ship');
        ?>
    </fieldset>

    <?= $this->Form->button(__('Submit'),  [
	'bootstrap-type' => 'primary',
	'bootstrap-size' => 'lg'
]); ?>



</div>
