<div class="container">
<h3><?= __('Setting'); ?></h3>
	<dl class="dl-horizontal">

		<dt><?= __('Name'); ?></dt>
		<dd>
			<?= h($setting['Setting']['name']); ?>

		</dd>
		<dt><?= __('Setting'); ?></dt>
		<dd>
			<?= h($setting['Setting']['setting']); ?>

		</dd>
		<dt><?= __('Comment'); ?></dt>
		<dd>
			<?= h($setting['Setting']['comment']); ?>

		</dd>
	</dl>
</div>
