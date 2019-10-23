
<div class="container">
	<div class="row">
	<div class="col-lg-12">
    <h3><?= __('Shipment'); ?></h3>
    <dl class="dl-horizontal">
        <dt><?= __('Shipper'); ?></dt>
        <dd>
            <?= $this->Html->link(h($shipment['Shipment']['shipper']), ['action' => 'addApp', 'edit', $shipment['Shipment']['id']]); ?>
        </dd>
        <dt><?= __('Shipped'); ?></dt>
        <dd>
            <?= $shipment['Shipment']['shipped'] == 1 ? "Yes" : "No"; ?>
        </dd>
        <dt><?= __('Destination'); ?></dt>
        <dd>
            <?= h($shipment['Shipment']['destination']); ?>
        </dd>
        <dt><?= __('Pallet Count'); ?></dt>
        <dd>
            <?= h($shipment['Shipment']['label_count']); ?>
        </dd>
        <dt><?= __('Created'); ?></dt>
        <dd>
            <?= h($shipment['Shipment']['created']); ?>
        </dd>
        <dt><?= __('Modified'); ?></dt>
        <dd>
            <?= h($shipment['Shipment']['modified']); ?>
        </dd>
    </dl>
	</div>
	</div>

<div class="row">
<div class="col-lg-12">
<h3><?php
    if (!empty($shipment['Label'])): echo count($shipment['Label']) . ' ';
    endif;
    echo __('pallets on') . ' ' . h($shipment['Shipment']['shipper']);
    ?></h3>
<?php if (!empty($shipment['Label'])): ?>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <tr>

            <th><?= __('Item'); ?></th>
            <th><?= __('Description'); ?></th>
            <th><?= __('Best Before'); ?></th>
            <th><?= __('Gtin14'); ?></th>
            <th><?= __('Qty'); ?></th>
            <th><?= __('Pl Ref'); ?></th>
            <th><?= __('SSCC'); ?></th>
            <th><?= __('Batch'); ?></th>
            <th><?= __('Print Date'); ?></th>
            <th><?= __('Location'); ?></th>

            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    <?php foreach ($shipment['Label'] as $label): ?>
            <tr>

                <td><?= $label['item']; ?></td>
                <td><?= $label['description']; ?></td>
                <td><?= $label['best_before']; ?></td>
                <td><?= $label['gtin14']; ?></td>
                <td><?= $label['qty']; ?></td>
                <td><?= $label['pl_ref']; ?></td>
                <td><?= $label['sscc']; ?></td>
                <td><?= $label['batch']; ?></td>
                <td><?= $label['print_date']; ?></td>
                <td><?= isset($label['Location']['location']) ? $label['Location']['location'] : ""; ?></td>

                <td class="actions">
        <?= $this->Html->link(
            __('View'),
            ['controller' => 'labels', 'action' => 'view', $label['id']],
            ['class' => 'btn btn-link btn-sm view']
            ); ?>

                </td>
            </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>
</div>
</div>
</div>
