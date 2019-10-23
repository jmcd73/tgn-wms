<div class="container">
	<div class="col-lg-offset-3 col-lg-6">
<?= $this->Form->create('Menu'); ?>
	<fieldset>
		<legend><?= __('Add Menu'); ?></legend>
	<?php
               echo $this->Form->input('id');
                echo $this->Form->input('active', ['default' => 1]);
                 echo $this->Form->input('divider');
                 echo $this->Form->input('header');
								  echo $this->Form->input('admin_menu');
		echo $this->Form->input('name');
                echo $this->Form->input('description');

                	echo $this->Form->input('bs_url', [
                            'empty' => '(select)',
                            'options' => $bs_url]);
                        echo $this->Form->input('title' , ['label' => 'URL Title']);
                         echo $this->Form->input('extra_args');
		echo $this->Form->input('options');
		echo $this->Form->input('parent_id', ['empty' => '(leave empty or choose parent)', 'options' => $parentMenus]);

	?>
	</fieldset>

<?= $this->Form->button(__('Submit'), [
	'bootstrap-type' => 'primary',
	'bootstrap-size' => 'lg'
]); ?>
<?= $this->Form->end(); ?>
</div>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>

		<li><?= $this->Html->link(__('List Menus'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Menus'), ['controller' => 'menus', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'menus', 'action' => 'add']); ?> </li>
	</ul>
</div>
