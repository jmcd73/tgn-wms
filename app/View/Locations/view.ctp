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
<div class="row">
	<div class="col-lg-12">
	<h3><?= __('Related Labels'); ?></h3>
	<?php if (!empty($labels)): ?>
	<p>
    <?php
        echo $this->Paginator->counter([
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ]);
    ?>	</p>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
		<th><?= $this->Paginator->sort('id'); ?></th>
		<th><?= $this->Paginator->sort('item'); ?></th>
		<th><?= $this->Paginator->sort('description'); ?></th>
		<th><?= $this->Paginator->sort('best_before'); ?></th>
		<th><?= $this->Paginator->sort('gtin14'); ?></th>
		<th><?= $this->Paginator->sort('qty'); ?></th>
		<th><?= $this->Paginator->sort('pl_ref'); ?></th>
		<th><?= $this->Paginator->sort('sscc'); ?></th>
		<th><?= $this->Paginator->sort('batch'); ?></th>
		<th><?= $this->Paginator->sort('printer'); ?></th>
		<th><?= $this->Paginator->sort('print_date'); ?></th>
		<th><?= $this->Paginator->sort('location_id'); ?></th>
		<th><?= $this->Paginator->sort('shipment_id'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	</thead>
	<?php foreach ($labels as $label): ?>
		<tr>
			<td><?= $label['Label']['id']; ?></td>
			<td><?= $label['Label']['item']; ?></td>
			<td><?= $label['Label']['description']; ?></td>
			<td><?= $label['Label']['best_before']; ?></td>
			<td><?= $label['Label']['gtin14']; ?></td>
			<td><?= $label['Label']['qty']; ?></td>
			<td><?= $label['Label']['pl_ref']; ?></td>
			<td><?= $label['Label']['sscc']; ?></td>
			<td><?= $label['Label']['batch']; ?></td>
			<td><?= $label['Label']['printer']; ?></td>
			<td><?= $label['Label']['print_date']; ?></td>
			<td><?= $label['Location']['location']; ?></td>
			<td><?= $label['Shipment']['shipper']; ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'labels', 'action' => 'view', $label['Label']['id']]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'labels', 'action' => 'edit', $label['Label']['id']]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'labels', 'action' => 'delete', $label['Label']['id']], [], __('Are you sure you want to delete # %s?', $label['Label']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<p>
    <?php
        echo $this->Paginator->counter([
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ]);
    ?>	</p>
<div class="pagination pagination-large">
    <ul class="pagination">
        <?php
            echo $this->Paginator->first('&laquo; first', ['escape' => false, 'tag' => 'li']);
            echo $this->Paginator->prev('&lsaquo; ' . __('previous'), ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->numbers(['separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1, 'ellipsis' => null]);
            echo $this->Paginator->next(__('next') . ' &rsaquo;', ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->last('last &raquo;', ['escape' => false, 'tag' => 'li']);
        ?>
    </ul>
</div>
<?php endif; ?>
	</div>
	</div>

