<?php
echo $this->Html->script(
    'bulk_status_remove',
    [
        'inline' => false,
        'block' => 'from_view',
    ]
);
?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container mb5">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <?php $active = empty($status_id) ? 'active' : ''; ?>
            <?php echo $this->Html->link('ALL', ['action' => 'bulkStatusRemove'], ['class' => 'nav-link ' . $active]); ?>
        </li>
        <?php foreach ($statuses as $status): ?>
        <li class="nav-item">
            <?php $active = ($status_id == $status['id']) ? 'active' : ''; ?>
            <?php
                echo $this->Html->link(
    $status['name'],
    ['action' => 'bulkStatusRemove', $status['id']],
    [
        'class' => 'nav-link ' . $active, ]
); ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php  echo $this->Form->create(null, [
        'align' => 'inline',
    ]);?>

    <div class="offset-lg-7 col">
        <div class="row">
            <?php echo $this->Form->control('inventory_status_note_global', [
                'type' => 'text',
                'label' => 'Inventory status note',
                'class' => 'mt-2 mb-2 mx-sm-3',
            ]); ?>
            <?php if ($showBulkChangeToSelect): ?>
            <?php echo $this->Form->control('change_to', [
                'type' => 'select',
                'label' => 'Change all to',
                'options' => $status_list,
                'class' => 'mt-2 mb-2',
                'empty' => '(select)', ]);
                ?>
            <?php endif; ?>
        </div>
    </div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                <th><?php echo $this->Paginator->sort('description'); ?></th>
                <th><?php echo $this->Paginator->sort('bb_date', 'Best Before', ['title' => 'Best Before']); ?></th>
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
                <td><?php echo h($pallet['items']['code']); ?></td>
                <td><?php echo h($pallet['description']); ?></td>
                <td><?php echo h($pallet['bb_date']); ?></td>
                <td><?php echo h($pallet['qty']); ?></td>
                <td><?php echo h($pallet['pl_ref']); ?></td>
                <td><?php echo h($pallet['batch']); ?></td>
                <td><?php echo h($pallet['print_date']); ?></td>
                <td><?php echo h($pallet['location']['location']); ?></td>
                <td><?php echo h($pallet['inventory_status']['name']); ?></td>
                <td><?php echo h($pallet['inventory_status_note']); ?></td>
                <td>
                    <?php
                    /**
                     * This radio control doesn't use  $this->Form->input because it takes
                     * so long to render that execution timeouts occur
                     */
                ?>

                    <?php echo $this->Form->control('pallets.' . $k . '.inventory_status_id', [
                        'type' => 'radio',
                        'options' => $status_list,
                    ]); ?>
                    <!-- <?php  foreach ($status_list as $key => $value): ?>
                    <label class="radio-inline">
                        <input type="radio" data-checked="0" name="data[Pallet][<?= $k; ?>][inventory_status_id]"
                            value="<?= $key; ?>"><?= $value; ?>
                    </label>
                    <?php endforeach; ?> -->
                    <?php  echo $this->Form->control('pallets.' . $k . '.id', [
                        'type' => 'hidden',
                        'value' => $pallet['id'],
                    ]);  ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <p><?php echo $this->Paginator->counter(
                        'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}'
                    );?></p>
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
<?php  $this->Form->end(); ?>