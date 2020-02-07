<div class="inventoryStatuses index container">
    <h3><?= __('Inventory Statuses'); ?></h3>
    <?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn add btn-primary add mb2 btn-xs']); ?>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id'); ?></th>
                <th><?= $this->Paginator->sort('allow_bulk_status_change'); ?></th>
                <th><?= $this->Paginator->sort('name'); ?></th>
                <th><?= $this->Paginator->sort('comment'); ?></th>
                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryStatuses as $inventoryStatus): ?>
            <tr>
                <td><?= h($inventoryStatus['InventoryStatus']['id']); ?></td>
                <td><?= h($inventoryStatus['InventoryStatus']['allow_bulk_status_change']); ?></td>
                <td><?= h($inventoryStatus['InventoryStatus']['name']); ?></td>
                <td><?= h($inventoryStatus['InventoryStatus']['comment']); ?></td>
                <td class="actions">
                    <?= $this->Html->link(
    __('View'),
    ['action' => 'view', $inventoryStatus['InventoryStatus']['id']],
    ['class' => 'btn btn-link btn-sm view']
); ?>
                    <?= $this->Html->link(
    __('Edit'),
    ['action' => 'edit', $inventoryStatus['InventoryStatus']['id']],
    ['class' => 'btn btn-link btn-sm edit']
); ?>
                    <?= $this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $inventoryStatus['InventoryStatus']['id']],
    ['class' => 'btn btn-link btn-sm delete'],
    __('Are you sure you want to delete # %s?', $inventoryStatus['InventoryStatus']['id'])
); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter([
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'),
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
<div class="actions">
    <h3><?= __('Actions'); ?></h3>
    <ul>
        <li><?= $this->Html->link(__('New Inventory Status'), ['action' => 'add']); ?></li>
        <li><?= $this->Html->link(__('List Labels'), ['controller' => 'pallets', 'action' => 'index']); ?> </li>
        <li><?= $this->Html->link(__('New Label'), ['controller' => 'pallets', 'action' => 'add']); ?> </li>
    </ul>
</div>