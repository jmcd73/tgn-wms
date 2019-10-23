<div class="container">
<h3><?= __('Machines Standard Rate'); ?></h3>
	<dl class="dl-horizontal">

		<dt><?= __('Machine'); ?></dt>
		<dd>
			<?= $this->Html->link($machinesStandardRate['Machine']['machine'], ['controller' => 'machines', 'action' => 'view', $machinesStandardRate['Machine']['id']]); ?>

		</dd>
		<dt><?= __('Pack Size'); ?></dt>
		<dd>
			<?= $this->Html->link($machinesStandardRate['PackSize']['pack_size'], ['controller' => 'pack_sizes', 'action' => 'view', $machinesStandardRate['PackSize']['id']]); ?>

		</dd>
		<dt><?= __('Standard Rate'); ?></dt>
		<dd>
			<?= h($machinesStandardRate['MachinesStandardRate']['standard_rate']); ?>

		</dd>
	</dl>
</div>
