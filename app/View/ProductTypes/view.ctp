<div class="container">
    <div class="productTypes view">
        <h3><?= __('Area Or Type'); ?></h3>
        <dl class="dl-horizontal">
            <dt><?= __('Id'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['id']); ?>
            </dd>
            <dt><?= __('Default Inventory Status'); ?></dt>
            <dd>
                <?= h($productType['InventoryStatus']['id']); ?>
            </dd>
            <dt><?= __('Active'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['active']); ?>
            </dd>
            <dt><?= __('Pick App'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['enable_pick_app']); ?>
            </dd>
            <dt><?= __('Serial Number Format'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['serial_number_format']); ?>
            </dd>
            <dd>
                <?= h($productType['ProductType']['id']); ?>
            </dd>
            <dt><?= __('Name'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['name']); ?>
            </dd>
            <dt><?= __('Code Regex'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['code_regex']); ?>
            </dd>
            <dt><?= __('Code Regex Description'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['code_regex_description']); ?>
            </dd>
            <dt><?= __('Default Save Location'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['location_id']); ?>
            </dd>
            <dt><?= __('Storage Temperature'); ?></dt>
            <dd>
                <?= h($productType['ProductType']['storage_temperature']); ?>
            </dd>
        </dl>
    </div>
    <div class="actions">
        <h3><?= __('Actions'); ?></h3>
        <ul>
            <li><?= $this->Html->link(__('Edit Area Or Type'), ['action' => 'edit', $productType['ProductType']['id']]); ?>
            </li>
            <li><?= $this->Form->postLink(__('Delete Area Or Type'), ['action' => 'delete', $productType['ProductType']['id']], ['confirm' => __('Are you sure you want to delete # %s?', $productType['ProductType']['id'])]); ?>
            </li>
            <li><?= $this->Html->link(__('List Product Types'), ['action' => 'index']); ?> </li>
            <li><?= $this->Html->link(__('New Area Or Type'), ['action' => 'add']); ?> </li>
            <li><?= $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
            <li><?= $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
            <li><?= $this->Html->link(__('List Locations'), ['controller' => 'locations', 'action' => 'index']); ?>
            </li>
            <li><?= $this->Html->link(__('New Location'), ['controller' => 'locations', 'action' => 'add']); ?> </li>
            <li><?= $this->Html->link(__('List Shifts'), ['controller' => 'shifts', 'action' => 'index']); ?> </li>
            <li><?= $this->Html->link(__('New Shift'), ['controller' => 'shifts', 'action' => 'add']); ?> </li>
        </ul>
    </div>
    <div class="related">
        <h3><?= __('Related Items'); ?></h3>
        <?php if (!empty($productType['Item'])): ?>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <tr>
                <th><?= __('Id'); ?></th>
                <th><?= __('Active'); ?></th>
                <th><?= __('Code'); ?></th>
                <th><?= __('Description'); ?></th>
                <th><?= __('Quantity'); ?></th>
                <th><?= __('Trade Unit'); ?></th>
                <th><?= __('Pack Size Id'); ?></th>
                <th><?= __('Consumer Unit'); ?></th>
                <th><?= __('Brand'); ?></th>
                <th><?= __('Variant'); ?></th>
                <th><?= __('Unit Net Contents'); ?></th>
                <th><?= __('Unit Of Measure'); ?></th>
                <th><?= __('Days Life'); ?></th>
                <th><?= __('Min Days Life'); ?></th>
                <th><?= __('Item Comment'); ?></th>
                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
            <?php foreach ($productType['Item'] as $item): ?>
            <tr>
                <td><?= $item['id']; ?></td>
                <td><?= $item['active']; ?></td>
                <td><?= $item['code']; ?></td>
                <td><?= $item['description']; ?></td>
                <td><?= $item['quantity']; ?></td>
                <td><?= $item['trade_unit']; ?></td>
                <td><?= $item['pack_size_id']; ?></td>
                <td><?= $item['consumer_unit']; ?></td>
                <td><?= $item['brand']; ?></td>
                <td><?= $item['variant']; ?></td>
                <td><?= $item['unit_net_contents']; ?></td>
                <td><?= $item['unit_of_measure']; ?></td>
                <td><?= $item['days_life']; ?></td>
                <td><?= $item['min_days_life']; ?></td>
                <td><?= $item['item_comment']; ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'items', 'action' => 'view', $item['id']], ['class' => 'btn btn-link btn-sm view']); ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'items', 'action' => 'edit', $item['id']], ['class' => 'btn btn-link btn-sm edit']); ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'items', 'action' => 'delete', $item['id']], [
                        'class' => 'btn btn-link btn-sm delete',
                        'confirm' => __('Are you sure you want to delete # %s?', $item['id']), ]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?= $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
            </ul>
        </div>
    </div>
    <div class="related">
        <h3><?= __('Related Locations'); ?></h3>
        <?php if (!empty($productType['Location'])): ?>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <tr>
                <th><?= __('Id'); ?></th>
                <th><?= __('Location'); ?></th>
                <th><?= __('Pallet Capacity'); ?></th>
                <th><?= __('Is Hidden'); ?></th>
                <th><?= __('Description'); ?></th>
                <th><?= __('Created'); ?></th>
                <th><?= __('Modified'); ?></th>
                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
            <?php foreach ($productType['Location'] as $location): ?>
            <tr>
                <td><?= $location['id']; ?></td>
                <td><?= $location['location']; ?></td>
                <td><?= $location['pallet_capacity']; ?></td>
                <td><?= $location['is_hidden']; ?></td>
                <td><?= $location['description']; ?></td>
                <td><?= $location['created']; ?></td>
                <td><?= $location['modified']; ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'locations', 'action' => 'view', $location['id']], ['class' => 'btn btn-link btn-sm view']); ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'locations', 'action' => 'edit', $location['id']], ['class' => 'btn btn-link btn-sm edit']); ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'locations', 'action' => 'delete', $location['id']], ['class' => 'btn btn-link btn-sm delete',
                        'confirm' => __('Are you sure you want to delete # %s?', $location['id']), ]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?= $this->Html->link(__('New Location'), ['controller' => 'locations', 'action' => 'add']); ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="related">
        <h3><?= __('Related Shifts'); ?></h3>
        <?php if (!empty($productType['Shift'])): ?>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <tr>
                <th><?= __('Id'); ?></th>
                <th><?= __('Name'); ?></th>
                <th><?= __('Shift Minutes'); ?></th>
                <th><?= __('Comment'); ?></th>
                <th><?= __('Created'); ?></th>
                <th><?= __('Modified'); ?></th>
                <th><?= __('Active'); ?></th>
                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
            <?php foreach ($productType['Shift'] as $shift): ?>
            <tr>
                <td><?= $shift['id']; ?></td>
                <td><?= $shift['name']; ?></td>
                <td><?= $shift['shift_minutes']; ?></td>
                <td><?= $shift['comment']; ?></td>
                <td><?= $shift['created']; ?></td>
                <td><?= $shift['modified']; ?></td>
                <td><?= $shift['active']; ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'shifts', 'action' => 'view', $shift['id']], ['class' => 'btn btn-link btn-sm view']); ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'shifts', 'action' => 'edit', $shift['id']], ['class' => 'btn btn-link btn-sm edit']); ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'shifts', 'action' => 'delete', $shift['id']], [
                        'class' => 'btn btn-link btn-sm delete',
                        'confirm' => __('Are you sure you want to delete # %s?', $shift['id']), ]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <div class="actions">
            <ul>
                <li><?= $this->Html->link(__('New Shift'), ['controller' => 'shifts', 'action' => 'add']); ?> </li>
            </ul>
        </div>
    </div>
</div>