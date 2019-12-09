<?php
echo $this->Html->script(
        'bulk_status_remove', [
    'inline' => false,
    'block' => 'from_view'
]);
?>

<div class="container">
    <ul class="nav nav-tabs">
        <li <?= $status_id === null ? 'class="active"' : ''; ?>><?= $this->Html->link('ALL', ['action' => 'bulkStatusRemove']); ?> </li>
        <?php foreach ($statuses as $status): ?>
            <li class="<?= ($status_id == $status['InventoryStatus']['id']) ? 'active' : ''; ?>"><?= $this->Html->link($status['InventoryStatus']['name'], ['action' => 'bulkStatusRemove', $status['InventoryStatus']['id']]); ?></li>
<?php endforeach; ?>
    </ul>

<?= $this->Form->create(null, ['inline' => true]); ?>

    <div class="col-lg-3">
        <h4><?= __('Pallets'); ?> <span class="badge"><?= $this->Paginator->params()['count']; ?></span></h4>
    </div>
    <div class="col-lg-offset-2 col-lg-4">
        <div class="bsrtpad">
            <?=
            $this->Form->input('inventory_status_note_global', [
                'type' => 'text',
                'class' => 'input-sm',
                'label' => 'Inventory status note&nbsp;',
                'options' => $status_list,
                'empty' => '(select)']);
            ?></div>
    </div>

<?php if ((int) $status_id === 3 || (int) $status_id === 1): ?>

        <div class="col-lg-3">
            <div class="bsrtpad">
                <?=
                $this->Form->input('change_to', [
                    'type' => 'select',
                    'class' => 'input-sm',
                    'label' => 'Change all to&nbsp;',
                    'options' => $status_list,
                    'empty' => '(select)']);
                ?></div>
        </div>
<?php endif; ?>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('item_id'); ?></th>
                <th><?= $this->Paginator->sort('description'); ?></th>
                <th><?= $this->Paginator->sort('best_before', 'BBefore', ['title' => "Best Before"]); ?></th>
                <th><?= $this->Paginator->sort('qty'); ?></th>
                <th><?= $this->Paginator->sort('pl_ref'); ?></th>
                <th><?= $this->Paginator->sort('batch'); ?></th>
                <th><?= $this->Paginator->sort('print_date'); ?></th>
                <th><?= $this->Paginator->sort('location_id'); ?></th>
                <th><?= $this->Paginator->sort('inventory_status_id', 'Status'); ?></th>
                <th><?= $this->Paginator->sort('inventory_status_note'); ?></th>
                <th><?= __('Change To'); ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($pallets as $k => $pallet): ?>
                <tr>

                    <td><?= h($pallet['Item']['code']); ?></td>
                    <td><?= h($pallet['Pallet']['description']); ?></td>
                    <td><?= h($pallet['Pallet']['best_before']); ?></td>

                    <td><?= h($pallet['Pallet']['qty']); ?></td>
                    <td><?= h($pallet['Pallet']['pl_ref']); ?></td>

                    <td><?= h($pallet['Pallet']['batch']); ?></td>


                    <td><?= $this->Time->format('d/m/y h:i:s a', $pallet['Pallet']['print_date'], 'invalid'); ?></td>
                    <td><?= h($pallet['Location']['location']); ?></td>

                    <td><?= h($pallet['InventoryStatus']['name']); ?></td>
                    <td><?= h($pallet['Pallet']['inventory_status_note']); ?></td>

                    <td>
                        <?php
                        echo $this->Form->input($k . '.id', [
                            'type' => 'hidden',
                            'value' => $pallet['Pallet']['id']
                        ]);
                        ?>
                        <!--    <?php
                        echo $this->Form->input($k . '.inventory_status_id', [
                            'type' => 'select',
                            'options' => $status_list,
                            'empty' => '(select)',
                            'label' => false,
                            'hiddenField' => false
                        ]);
                        ?> -->

    <?php foreach ($status_list as $key => $value): ?>
                            <label class="radio-inline">
                                <input type="radio" data-checked="0" name="data[Pallet][<?= $k; ?>][inventory_status_id]" value="<?= $key; ?>"><?= $value; ?>
                            </label>
    <?php endforeach; ?>

                    </td>
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

<?= $this->element('shipment_footer'); ?>
<?php $this->Form->end([
		'bootstrap-type' => 'primary'
	] ); ?>


