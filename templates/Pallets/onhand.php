<?php
use App\View\Helper\ToggenHelper;

?>
<?php $this->Html->script(
    'edit-modal',
    [
        'inline' => false,
        'block' => 'from_view',
    ]
); ?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<?php $this->start('tb_actions'); ?>

<div class="col">
    <h3><?php echo __('Filter'); ?></h3>
    <?php echo $this->Form->create($searchForm, [
        'url' => [
            'action' => 'search',
        ],
    ]);
    echo $this->Form->control('filter_value', [
        'label' => false,

        'type' => 'select',
        'options' => $filter_values,
        'empty' => '(select)',
    ]);
    echo $this->Form->submit('Search');
    echo $this->Form->end(); ?>
    <h4 class="mt-4">Colour Legend</h4>
    <div class="bg-danger alert" role="alert">
        <?php echo $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-ban-circle', 'aria-hidden' => 'true']); ?>
        Can't ship low dated
    </div>
    <div class="alert bg-warning">
        <?php echo $this->Html->tag('span', '', ['class' => 'glyphicon glyphicon-ok-circle', 'aria-hidden' => 'true']); ?>
        Low dated but shippable
    </div>
    <div class="bg-info alert">
        <?php echo $this->Html->tag('span', '', ['class' => 'wi wi-thermometer', 'aria-hidden' => 'true']); ?>
        On cooldown
        <span class="label label-primary"><?php echo $cooldown; ?> hours</span>
    </div>
</div>
<?php $this->end();?>
<?php $this->assign('tb_sidebar', $this->fetch('tb_actions')); ?>
<div class="container">
    <div class="col">
        <p class="h3"><?php echo __('Pallet Location Report'); ?>
            <small>
                <span class="label label-default">
                    <?php echo $this->Paginator->counter('{{count}} pallets'); ?>
                </span>
                <span class="<?php echo $dont_ship_count === 0 ? 'hidden' : ''; ?> label label-danger">
                    <?php echo $dont_ship_count; ?>
                    low dated
                </span>
            </small>
        </p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('location_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('description'); ?></th>
                    <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                    <th><?php echo $this->Paginator->sort('print_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('pl_age', null, ['title' => 'Pallet age in hours']); ?></th>
                    <th><?php echo $this->Paginator->sort('bb_date', 'Best before', ['title' => 'dd/mm/yy']); ?></th>
                    <th><?php echo $this->Paginator->sort('batch'); ?></th>
                    <th><?php echo $this->Paginator->sort('qty'); ?></th>
                    <th><?php echo $this->Paginator->sort('shipment_id', 'Alloc'); ?></th>
                    <th><?php echo $this->Paginator->sort('inventory_status_id', 'Status / Note'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pallets as $pallet): ?>
                <?php if ($pallet['oncooldown']) {
        $cls = 'bg-info';
    } elseif ($pallet['ship_low_date']) {
        $cls = 'bg-warning';
    } elseif ($pallet['dont_ship']) {
        $cls = 'bg-danger';
    } else {
        $cls = '';
    } ?>
                <tr>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo $this->Html->tag('a', '', [
                            'id' => $pallet['pl_ref'],
                            'class' => 'anchor', ]);
                            echo $this->Html->link(
                                h($pallet['location']['location']),
                                [
                                    'action' => 'move',
                                    $pallet['id'], ],
                                [
                                    'title' => 'Click here to move this pallet',
                                ]
                            );
                        ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['items']['code']); ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['items']['description']); ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['pl_ref']); ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo $this->Html->tag(
                            'span',
                            h($pallet['print_date']->i18nFormat(null, $user->timezone)),
                            ['title' => 'Cooldown date: ' . h($pallet['cooldown_date']->i18nFormat(null, $user->timezone)), 'style' => 'cursor: crosshair;']
                        ); ?></td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['pl_age']); ?></td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['bb_date']); ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['batch']); ?></td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['qty']); ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php if ($pallet['shipment']['shipper']) {
                            echo $this->Html->link(
                                $pallet['shipment']['shipper'],
                                [
                                    'controller' => 'shipments',
                                    'action' => 'addApp',
                                    'edit',
                                    $pallet['shipment']['id'], ],
                                [
                                    'class' => 'btn edit btn-xs',
                                    'title' => 'Edit Shipment',
                                ]
                            );
                        };
                        ?></td>

                    <td <?php echo $this->Toggen->buildClass($cls); ?>>
                        <?php echo h($pallet['InventoryStatus']['name']); ?>
                        <?php if (!empty($pallet['inventory_status_note'])): ?>
                        <p class="x-small" title="<?php echo $pallet['inventory_status_note']; ?>">
                            <?php echo $this->Text->truncate($pallet['inventory_status_note'], 14); ?>
                        </p>
                        <?php endif; ?>
                    </td>
                    <td <?php echo $this->Toggen->buildClass([$cls, 'actions']); ?>>
                        <?php echo $this->Html->link(
                            __('Edit'),
                            '#',
                            [
                                'data-palletId' => $pallet['id'],
                                'data-codeDesc' => $pallet['code_desc'],
                                'data-editPalletCartons' => $this->Url->build([
                                    'controller' => 'Cartons',
                                    'action' => 'editPalletCartons',
                                    $pallet['id'],
                                ]),
                                'data-moveOrEdit' => $this->Url->build([
                                    'action' => 'editPallet',
                                    $pallet['id'],
                                ]),
                                'data-toggle' => 'modal',
                                'data-target' => '#edit-modal',
                                'class' => 'btn edit btn-xs tgn-modal',
                                'title' => 'Click here for popup edit options menu',
                            ]
                        );
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <?php
                echo $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}');
            ?>
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
</div>

<?php echo $this->element('pallet_cartons_edit_modal'); ?>