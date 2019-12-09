<div class="pallets container index">
    <h3><?php echo __('Pallets'); ?></h3>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                <th><?php echo $this->Paginator->sort('description'); ?></th>
                <th><?php echo $this->Paginator->sort('inventory_status_id'); ?></th>
                <th><?php echo $this->Paginator->sort('qty'); ?></th>
                <th><?php echo $this->Paginator->sort('quantity', 'Full PL Qty'); ?></th>
                <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                <th><?php echo $this->Paginator->sort('print_date'); ?></th>
                <th><?php echo $this->Paginator->sort('bb_date', 'Best before'); ?></th>
                <th><?php echo $this->Paginator->sort('shipment_id'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pallets as $pallet): ?>
            <tr>

                <td><?php echo $this->Html->link($pallet['Item']['code'], ['controller' => 'items', 'action' => 'view', $pallet['Pallet']['item_id']]); ?>
                </td>
                <td><?php echo h($pallet['Pallet']['description']); ?></td>
                <td><?php echo h($pallet['InventoryStatus']['name']); ?></td>
                <td>
                    <?php echo $this->Html->tag('span', $pallet['cartonRecordCount'], ['class' => 'badge']); ?>
                    <?php echo h($pallet['Pallet']['qty']); ?>
                </td>
                <td>
                    <?php echo h($pallet['Item']['quantity']); ?>
                </td>
                <td><?php echo h($pallet['Pallet']['pl_ref']); ?></td>

                <td><?php echo h($pallet['Pallet']['print_date']); ?></td>
                <td><?php echo h($pallet['Pallet']['bb_date']); ?></td>
                <td><?php echo h($pallet['Shipment']['shipper']); ?></td>
                <td class="actions">

                    <?php echo $this->Html->link(
                            __('View'),
                            [
                                'action' => 'view',
                                $pallet['Pallet']['id']
                            ],
                            [
                                'class' => 'btn btn-link btn-xs view'
                            ]
                        );
                        echo $this->Html->link(
                            __('Edit'),
                            [
                                'controller' => 'Cartons',
                                'action' => 'editPalletCartons',
                                $pallet['Pallet']['id']
                            ],
                            [
                                'class' => 'btn btn-link btn-xs edit'
                            ]
                    ); ?>
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
        ?> </p>
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