<div class="container">
<?= $this->Form->create('Shift'); ?>
	<fieldset>
		<legend><?= __('Add Shift'); ?></legend>
	<?php
                echo $this->Form->input('active', [
                    'default' => true
                ]);

		echo $this->Form->input('name');

                   echo $this->Form->input('product_type_id', [
                     'options' => $productTypes,
                     'empty' => '(select)'
                 ]);
		echo $this->Form->input('shift_minutes');
                 echo $this->Form->input('start_time', [
                    'timeFormat' => 24,
                    'label' => "Start Time (24 HR Time)"
                ]);
                echo $this->Form->input('stop_time', [
                    'timeFormat' => 24,
                    'label' => "Stop Time (24 HR Time)"
                ]);

		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php $btn_options = ['class' => 'col-md-offset-2 col-md-1btn btn-lg btn-primary']; ?>
<?= $this->Form->button(__('Submit'),$btn_options ); ?>
<?= $this->Form->end(); ?>
</div>
