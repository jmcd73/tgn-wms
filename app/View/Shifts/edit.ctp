<div class="container">
<?= $this->Form->create('Shift'); ?>
	<fieldset>
		<legend><?= __('Edit Shift'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('active');

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
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>

		<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('Shift.id')], [], __('Are you sure you want to delete # %s?', $this->Form->value('Shift.id'))); ?></li>
		<li><?= $this->Html->link(__('List Shifts'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Report Dates'), ['controller' => 'report_dates', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Report Date'), ['controller' => 'report_dates', 'action' => 'add']); ?> </li>
	</ul>
</div>
