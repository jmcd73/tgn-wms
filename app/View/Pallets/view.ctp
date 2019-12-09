<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3><?php echo __('Pallet'); ?></h3>
            <?php echo $this->Html->link(
                    'Edit',
                    [
                        'controller' => 'Pallets',
                        'action' => 'editPallet',
                        $pallet['Pallet']['id']
                    ], [
                        'class' => 'mb2 btn btn-primary btn-xs edit'
                ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <dl class="dl-horizontal">
                <dt><?php echo __('Item'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['item']); ?>
                </dd>
                <dt><?php echo __('Description'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['description']); ?>
                </dd>
                <dt><?php echo __('Print Date'); ?></dt>
                <dd>
                    <?php echo h($this->Time->format($pallet['Pallet']['print_date'], '%a %d %b %Y %r')); ?>
                </dd>
                <dt><?php echo __('Best Before'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['bb_date']); ?>
                </dd>
                <dt><?php echo __('Gtin14'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['gtin14']); ?>
                </dd>
                <dt><?php echo __('Qty'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['qty']); ?>
                </dd>
                <dt><?php echo __('Qty Previous'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['qty_previous']); ?>
                </dd>
                <dt><?php echo __('Qty Last Edited by'); ?></dt>
                <dd>
                    <?php echo h($pallet['User']['username']); ?>
                </dd>
                <dt><?php echo __('Qty Modified At'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['qty_modified']); ?>
                </dd>

                <dt><?php echo __('Pl Ref'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['pl_ref']); ?>
                </dd>
                <dt><?php echo __('Serial Shipper Container Code'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['sscc_fmt']); ?>
                </dd>
            </dl>
        </div>
        <div class="col-lg-4">
            <dl class="dl-horizontal">
                <dt><?php echo __('Production Line'); ?></dt>
                <dd>
                    <?php echo h($pallet['ProductionLine']['name']); ?>
                </dd>
                <dt><?php echo __('Batch'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['batch']); ?>
                </dd>
                <dt><?php echo __('Printer'); ?></dt>
                <dd>
                    <?php echo isset($pallet['Printer']['name']) ? h($pallet['Printer']['name']) : ""; ?>
                </dd>

                <dt><?php echo __('Location Id'); ?></dt>
                <dd>
                    <?php echo h($pallet['Location']['location']); ?>
                </dd>
                <dt><?php echo __('Shipment'); ?></dt>
                <dd>
                    <?php echo h($pallet['Shipment']['shipper']); ?>
                </dd>
                <dt><?php echo __('Low Dated'); ?></dt>
                <dd>
                    <?php echo $pallet['Pallet']['dont_ship'] ? 'yes' : 'no'; ?>
                </dd>
                <dt><?php echo __('Ship if low dated'); ?></dt>
                <dd>
                    <?php echo $pallet['Pallet']['ship_low_date'] ? 'yes' : 'no'; ?>
                </dd>
                <dt><?php echo __('Inventory Status'); ?></dt>
                <dd>
                    <?php echo $pallet['InventoryStatus']['name']; ?>
                </dd>
                <dt><?php echo __('Inv. Status Changed'); ?></dt>
                <dd>
                    <?php echo h($this->Time->format($pallet['Pallet']['inventory_status_datetime'], '%a %d %b %Y %r')); ?>
                </dd>
                <dt><?php echo __('Created'); ?></dt>
                <dd>
                    <?php echo $pallet['Pallet']['created']; ?>
                </dd>
                <dt><?php echo __('Modified'); ?></dt>
                <dd>
                    <?php echo $pallet['Pallet']['modified']; ?>
                </dd>
            </dl>
        </div>
        <div class="col-lg-4">
            <dl class="dl-horizontal">

                <dt><?php echo __('Cooldown Date'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['cooldown_date']); ?>
                </dd>
                <dt><?php echo __('Minimum Days Life'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['min_days_life']); ?>
                </dd>

                <dt><?php echo __('Product Type'); ?></dt>
                <dd>
                    <?php echo h($pallet['ProductType']['name']); ?>
                </dd>
                <dt><?php echo __('Inventory status note'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['inventory_status_note']); ?>
                </dd>

                <dt><?php echo __('Inv. status note date time'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['inventory_status_datetime']); ?>
                </dd>
                <dt><?php echo __('Picked'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['picked']); ?>
                </dd>
                <dt><?php echo __('Record Created'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['created']); ?>
                </dd>
                <dt><?php echo __('Record last modified'); ?></dt>
                <dd>
                    <?php echo h($pallet['Pallet']['modified']); ?>
                </dd>
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3><?php echo __("Cartons"); ?></h3>
            <?php echo $this->Html->link(
                    'Edit',
                    [
                        'controller' => 'Cartons',
                        'action' => 'editPalletCartons',
                        $pallet['Pallet']['id']
                    ], [
                        'class' => 'mb2 btn btn-primary btn-xs edit'
                ]); ?>

            <?php if (!empty($pallet['Carton'])): ?>

            <table class="table table-bordered table-condensed table-striped table-responsive">
                <tr>
                    <th><?php echo __('Production Date'); ?></th>
                    <th><?php echo __('Best Before'); ?></th>
                    <th><?php echo __('Quantity'); ?></th>
                </tr>
                <?php foreach ($pallet['Carton'] as $carton): ?>
                <tr>
                    <td><?php echo $carton['production_date']; ?></td>
                    <td><?php echo $carton['best_before']; ?></td>
                    <td><?php echo $carton['count']; ?></td>

                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>