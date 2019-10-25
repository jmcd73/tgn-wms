<?php

?>
<div class="container">
<div class="col-lg-2 col-md-3">
	<h3>Actions</h3>
	<ul class="nav nav-pills nav-stacked">
		<li <?= $filter === 'all' ? 'class="active"': NULL ;?>><?= $this->Html->link('All Locations', [
			'action' => 'locationSpaceUsage',
			'all']); ?>
			</li>
		<li <?= $filter === 'available' ? 'class="active"': NULL ;?>><?= $this->Html->link('Space Available', [
			'action' => 'locationSpaceUsage',
			'available']); ?>
			</li>
		<li></li>
	</ul>

</div>
<div class="col-lg-10 col-md-9">
<table class="table table-bordered table-responsive">
<thead>
	<tr>
		<th><?= $this->Paginator->sort('Location'); ?></th>
		<th><?= $this->Paginator->sort('pallet_capacity', 'Location Capacity'); ?></th>
		<th><?= $this->Paginator->sort('Pallets', "Current Pallet Count"); ?></th>
		<th><?= $this->Paginator->sort('hasSpace'); ?></th>
	</tr>
</thead>
<tbody>
<?php foreach($locations as $location): ?>
	<tr class="<?= $location['Label']['hasSpace'] ? "success" : 'danger';?>">
		<td><?= $location['Label']['Location']; ?></td>
		<td><?= $location['Label']['pallet_capacity']; ?></td>
		<td><?= $location['Label']['Pallets']; ?></td>
		<td><?= $location['Label']['hasSpace'] ?
		$this->Html->tag('span', null, [
			'aria-hidden' => 'true',
			'class' => 'glyphicon glyphicon-ok-circle' ] )
		: $this->Html->tag('span', null, [
			'aria-hidden' => 'true',
			'class' => 'glyphicon glyphicon-ban-circle' ] ); ?></td>


	</tr>
<?php endforeach; ?>
</tbody>
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
	</div>
</div>

