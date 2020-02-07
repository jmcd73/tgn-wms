<?php
echo $this->Html->script(
    'bulk_status_remove',
    [
        'inline' => false,
        'block' => 'from_view',
    ]
);
?>

<div class="container mb5">
    <ul class="nav nav-tabs">
        <li <?php echo $status_id === null ? 'class="active"' : ''; ?>>
            <?php echo $this->Html->link('ALL', ['action' => 'bulkStatusRemove']); ?> </li>
        <?php foreach ($statuses as $status): ?>
        <li class="<?php echo ($status_id == $status['InventoryStatus']['id']) ? 'active' : ''; ?>">
            <?php echo $this->Html->link($status['InventoryStatus']['name'], ['action' => 'bulkStatusRemove', $status['InventoryStatus']['id']]); ?>
        </li>
        <?php endforeach; ?>
    </ul>

    <?php  echo $this->Form->create('Pallet', ['inline' => true]);?>

    <div class="col-lg-3">
        <h4><?php echo __('Pallets'); ?> <span class="badge"><?php echo $this->Paginator->params()['count']; ?></span>
        </h4>
    </div>
    <div class="col-lg-offset-2 col-lg-4">
        <div class="bsrtpad">
            <?php echo $this->Form->input('inventory_status_note_global', [
                'type' => 'text',
                'class' => 'input-sm',
                'label' => 'Inventory status note&nbsp;',
            ]); ?>
        </div>
    </div>
    <?php if ($showBulkChangeToSelect): ?>
    <div class="col-lg-3">
        <div class="bsrtpad">
            <?php echo $this->Form->input('change_to', [
                'type' => 'select',
                'class' => 'input-sm',
                'label' => 'Change all to&nbsp;',
                'options' => $status_list,
                'empty' => '(select)', ]);
                ?>
        </div>
    </div>
    <?php endif; ?>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                <th><?php echo $this->Paginator->sort('description'); ?></th>
                <th><?php echo $this->Paginator->sort('best_before', 'BBefore', ['title' => 'Best Before']); ?></th>
                <th><?php echo $this->Paginator->sort('qty'); ?></th>
                <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                <th><?php echo $this->Paginator->sort('batch'); ?></th>
                <th><?php echo $this->Paginator->sort('print_date'); ?></th>
                <th><?php echo $this->Paginator->sort('location_id'); ?></th>
                <th><?php echo $this->Paginator->sort('inventory_status_id', 'Status'); ?></th>
                <th><?php echo $this->Paginator->sort('inventory_status_note'); ?></th>
                <th><?php echo __('Change To'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pallets as $k => $pallet): ?>
            <tr>
                <td><?php echo $pallet['Item']['code']; ?></td>
                <td><?php echo $pallet['Pallet']['description']; ?></td>
                <td><?php echo $pallet['Pallet']['best_before']; ?></td>
                <td><?php echo $pallet['Pallet']['qty']; ?></td>
                <td><?php echo $pallet['Pallet']['pl_ref']; ?></td>
                <td><?php echo $pallet['Pallet']['batch']; ?></td>
                <td><?php echo $this->Time->format('d/m/y h:i:s a', $pallet['Pallet']['print_date'], 'invalid'); ?></td>
                <td><?php echo $pallet['Location']['location']; ?></td>
                <td><?php echo $pallet['InventoryStatus']['name']; ?></td>
                <td><?php echo $pallet['Pallet']['inventory_status_note']; ?></td>
                <td>
                <?php
                    /**
                     * This radio control doesn't use  $this->Form->input because it takes
                     * so long to render that execution timeouts occur
                     */
                ?>
                <?php  foreach ($status_list as $key => $value): ?>
                    <label class="radio-inline">
                        <input type="radio" data-checked="0" name="data[Pallet][<?= $k; ?>][inventory_status_id]" value="<?= $key; ?>"><?= $value; ?>
                    </label>
                <?php endforeach; ?>
                    <?php  echo $this->Form->input('Pallet.' . $k . '.id', [
                        'type' => 'hidden',
                        'value' => $pallet['Pallet']['id'],
                    ]);  ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><?php echo $this->Paginator->counter([
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'),
    ]);?>
    </p>
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
<?php echo $this->element('shipment_footer'); ?>
<?php  $this->Form->end([
    'bootstrap-type' => 'primary',
]); ?>