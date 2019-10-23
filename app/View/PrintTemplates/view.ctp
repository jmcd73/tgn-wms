<div class="printTemplates view container">
<h2><?php echo __('Print Template'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['id']); ?>

		</dd>
		<dt><?php echo __('Show in Label Chooser'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['show_in_label_chooser']); ?>

		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['active']); ?>

		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['name']); ?>

		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['description']); ?>

		</dd>
		<dt><?php echo __('Print Action'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['print_action']); ?>

		</dd>
		<dt><?php echo __('File Template'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['file_template']); ?>

		</dd>
		<dt><?php echo __('Sample Image name'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['example_image']); ?>
		</dd>
		<dt><?php echo __('Sample Image'); ?></dt>
		<dd>
			<?php echo $this->Html->image(
				$glabelsRoot .
				$printTemplate['PrintTemplate']['example_image'], [
					'class' => 'img-responsive',
					'width' => '320px'
			]); ?>
		</dd>
		<dt><?php echo __('Text Template'); ?></dt>
		<dd>
			<?php if ( $printTemplate['PrintTemplate']['text_template']) {
				echo $this->Html->tag(
					'pre',
					h($printTemplate['PrintTemplate']['text_template'])
				);
			}; ?></pre>

		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['created']); ?>

		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($printTemplate['PrintTemplate']['modified']); ?>

		</dd>

	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Print Template'), array('action' => 'edit', $printTemplate['PrintTemplate']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Print Template'), array('action' => 'delete', $printTemplate['PrintTemplate']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $printTemplate['PrintTemplate']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Print Templates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Print Template'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related container">
	<h3><?php echo __('Related Items'); ?></h3>
	<?php if (!empty($printTemplate['Item'])): ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Trade Unit'); ?></th>
		<th><?php echo __('Pack Size Id'); ?></th>
		<th><?php echo __('Product Type Id'); ?></th>
		<th><?php echo __('Consumer Unit'); ?></th>
		<th><?php echo __('Brand'); ?></th>
		<th><?php echo __('Variant'); ?></th>
		<th><?php echo __('Unit Net Contents'); ?></th>
		<th><?php echo __('Unit Of Measure'); ?></th>
		<th><?php echo __('Days Life'); ?></th>
		<th><?php echo __('Min Days Life'); ?></th>
		<th><?php echo __('Item Comment'); ?></th>
		<th><?php echo __('Print Template Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($printTemplate['Item'] as $item): ?>
		<tr>
			<td><?php echo $item['id']; ?></td>
			<td><?php echo $item['active']; ?></td>
			<td><?php echo $item['code']; ?></td>
			<td><?php echo $item['description']; ?></td>
			<td><?php echo $item['quantity']; ?></td>
			<td><?php echo $item['trade_unit']; ?></td>
			<td><?php echo $item['pack_size_id']; ?></td>
			<td><?php echo $item['product_type_id']; ?></td>
			<td><?php echo $item['consumer_unit']; ?></td>
			<td><?php echo $item['brand']; ?></td>
			<td><?php echo $item['variant']; ?></td>
			<td><?php echo $item['unit_net_contents']; ?></td>
			<td><?php echo $item['unit_of_measure']; ?></td>
			<td><?php echo $item['days_life']; ?></td>
			<td><?php echo $item['min_days_life']; ?></td>
			<td><?php echo $item['item_comment']; ?></td>
			<td><?php echo $item['print_template_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'items', 'action' => 'view', $item['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'items', 'action' => 'edit', $item['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'items', 'action' => 'delete', $item['id']), array('confirm' => __('Are you sure you want to delete # %s?', $item['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
