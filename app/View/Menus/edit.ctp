<div class="container">
<?=$this->Form->create('Menu'); ?>
	<fieldset>
		<legend><?=__('Edit Menu'); ?></legend>
	<?php
        echo $this->Form->input('id');
        echo $this->Form->input('active');
        echo $this->Form->input('divider');
        echo $this->Form->input('header');
        echo $this->Form->input('admin_menu');
        echo $this->Form->input('name');
        echo $this->Form->input('description');
        echo $this->Form->input('bs_url', [
            'empty' => '(select)',
            'options' => $bs_url]);
        echo $this->Form->input('title', ['label' => 'URL Title']);
        echo $this->Form->input('extra_args', [
            'label' => 'Extra Args',
            'placeholder' => 'Separate multiple values with space, comma or semi colon'
        ]);
        echo $this->Form->input('options');
        echo $this->Form->input('parent_id', ['empty' => '(leave empty or choose parent)', 'options' => $parentMenus]);
    ?>
	</fieldset>
<?=$this->Form->button(__('Submit'), [
    'bootstrap-type' => 'primary'
]); ?>
<?=$this->Form->end(); ?>
        </div>

</div>
