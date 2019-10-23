<div class="container">
<h3><?= __('Label'); ?></h3>
	<dl class="dl-horizontal">

		<dt><?= __('Item'); ?></dt>
		<dd>
			<?= h($label['Label']['item']); ?>

		</dd>
		<dt><?= __('Description'); ?></dt>
		<dd>
			<?= h($label['Label']['description']); ?>

		</dd>
		<dt><?= __('Best Before'); ?></dt>
		<dd>
			<?= h($label['Label']['best_before']); ?>

		</dd>
		<dt><?= __('Gtin14'); ?></dt>
		<dd>
			<?= h($label['Label']['gtin14']); ?>

		</dd>
		<dt><?= __('Qty'); ?></dt>
		<dd>
			<?= h($label['Label']['qty']); ?>

		</dd>
                <dt><?= __('Qty Previous'); ?></dt>
		<dd>
			<?= h($label['Label']['qty_previous']); ?>

		</dd>
                 <dt><?= __('Qty Last Edited by'); ?></dt>
		<dd>
			<?= h($label['User']['username']); ?>

		</dd>

                <dt><?= __('Production Line'); ?></dt>
		<dd>
			<?= h($label['Label']['production_line']); ?>

		</dd>

		<dt><?= __('Pl Ref'); ?></dt>
		<dd>
			<?= h($label['Label']['pl_ref']); ?>

		</dd>
		<dt><?= __('Sscc'); ?></dt>
		<dd>
			<?= h($label['Label']['sscc']); ?>

		</dd>
		<dt><?= __('Batch'); ?></dt>
		<dd>
			<?= h($label['Label']['batch']); ?>

		</dd>
		<dt><?= __('Printer'); ?></dt>
		<dd>
			<?= isset($label['Printer']['name']) ? h($label['Printer']['name']) : ""; ?>

		</dd>
		<dt><?= __('Print Date'); ?></dt>
		<dd>
			<?= h($this->Time->format($label['Label']['print_date'], '%a %d %b %Y %r')); ?>

		</dd>
		<dt><?= __('Location Id'); ?></dt>
		<dd>
			<?= h($label['Location']['location']); ?>

		</dd>
		<dt><?= __('Shipment Id'); ?></dt>
		<dd>
			<?= h($label['Shipment']['shipper']); ?>

		</dd>
                <dt><?= __('Low Dated'); ?></dt>
		<dd>
			<?= $label['Label']['dont_ship'] ? 'yes': 'no'; ?>

		</dd>
                <dt><?= __('Ship if low dated'); ?></dt>
		<dd>
			<?= $label['Label']['ship_low_date'] ? 'yes': 'no'; ?>

		</dd>
                 <dt><?= __('Inventory Status'); ?></dt>
		<dd>
			<?= $label['InventoryStatus']['name']; ?>

		</dd>
                    <dt><?= __('Inv. Status Changed'); ?></dt>
		<dd>
			<?= h($this->Time->format($label['Label']['inventory_status_datetime'], '%a %d %b %Y %r')); ?>

		</dd>
                 <dt><?= __('Created'); ?></dt>
		<dd>
			<?= $label['Label']['created']; ?>

		</dd>
                 <dt><?= __('Modified'); ?></dt>
		<dd>
			<?= $label['Label']['modified']; ?>

		</dd>
	</dl>
</div>
