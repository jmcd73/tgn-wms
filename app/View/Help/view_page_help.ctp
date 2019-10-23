<div class="helps view container">
	<div class="col-lg-12">
	<?=$this->Html->link('Go back', "#", [
		'class' => 'btn btn-link',
		'onClick' => 'javascript:window.history.back()']); ?>
	<?php echo $markdown; ?>
	<?=$this->Html->link('Go back', "#", [
		'class' => 'btn btn-link',
		'onClick' => 'javascript:window.history.back()']); ?>
		</div>
</div>
