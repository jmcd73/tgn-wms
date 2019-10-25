<div class='container'>
<div class="row">
	<h3><?= __('Location'); ?></h3>
	<dl class="dl-horizontal">
		<dt><?= __('Location'); ?></dt>
		<dd>
			<?= h($location['Location']['location']); ?>

		</dd>
                <dt><?= __('Pallet Capacity'); ?></dt>
		<dd>
			<?= h($location['Location']['pallet_capacity']); ?>

		</dd>
		<dt><?= __('Description'); ?></dt>
		<dd>
			<?= h($location['Location']['description']); ?>

		</dd>
		<dt><?= __('Created'); ?></dt>
		<dd>
			<?= h($location['Location']['created']); ?>

		</dd>
		<dt><?= __('Modified'); ?></dt>
		<dd>
			<?= h($location['Location']['modified']); ?>

		</dd>
                <dt><?= __('Location Type'); ?></dt>
		<dd>
			<?= h($location['ProductType']['storage_temperature']); ?>

		</dd>
	</dl>
</div>
</div>

