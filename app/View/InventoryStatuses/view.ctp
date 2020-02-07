<div class="container">
    <h3><?= __('Inventory Status'); ?></h3>
    <dl class="dl-horizontal">

        <dt><?= __('Name'); ?></dt>
        <dd>
            <?= h($inventoryStatus['InventoryStatus']['name']); ?>

        </dd>
        <dt><?= __('Allow Bulk Status Change'); ?></dt>
        <dd>
            <?= h($inventoryStatus['InventoryStatus']['allow_bulk_status_change']); ?>

        </dd>
        <dt><?= __('Comment'); ?></dt>
        <dd>
            <?= h($inventoryStatus['InventoryStatus']['comment']); ?>

        </dd>
        <dt><?= __('Stock view permissions'); ?></dt>
        <dd>
            <?php echo $this->Form->input('StockViewPerms', [
                'label' => false,
                'options' => $stockViewPerms,
                'selected' => $inventoryStatus['InventoryStatus']['StockViewPerms'],
                'multiple' => 'checkbox',
                'disabled' => true,
            ]); ?>

        </dd>



    </dl>


</div>