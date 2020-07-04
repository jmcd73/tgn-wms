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
    echo $this->Form->button('Search', [ 
        'type' => 'submit',
        'class' => 'btn search btn-primary'
        ]);
    echo $this->Form->end(); ?>
    <h4 class="mt-4"><?= __('Colour Legend'); ?></h4>
    <div class="bg-danger alert" role="alert">
        <?= $this->Html->icon('ban'); ?>
        Can't ship low dated
    </div>
    <div class="alert bg-warning">
        <?= $this->Html->icon('check-circle', ['iconSet' => 'far']); ?>
        Low dated but shippable
    </div>
    <div class="bg-info alert">
        <?= $this->Html->icon('thermometer-half'); ?>
        On cooldown
        <span class="label label-primary"><?php echo $cooldown; ?> hours</span>
    </div>
    <div class="bg-secondary alert">
        <?= $this->Html->icon('calendar-plus'); ?>
              <span class="label label-primary">Mixed date pallet</span>
    </div>
</div>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', $this->fetch('tb_actions')); ?>

<div class="row">
    <div class="col">
    <p class="h4"><?php echo __('Pallet Location Report'); ?>
            <small>
                <?php echo $this->Html->badge($this->Paginator->counter('{{count}}')); ?> pallets
                <?php if ($dont_ship_count) : ?>
                <span> <?= $this->Html->badge($dont_ship_count, ['class' => 'danger']); ?> low dated
                </span>
                <?php endif; ?>
                
            </small>
        </p>
    </div>
    <div class="col-1">
        <?= $this->Html->link("Download", [ 'action' => "export", "?" => $this->request->getQuery()], [ 
        'class' => 'btn btn-sm btn-primary download',
        'title' => "Click to download the current view as a spreadsheet in CSV format"
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('location_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('item_id'); ?></th>   
                    <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                    <th><?php echo $this->Paginator->sort('print_date'); ?></th>
                    <th>Pl age</th>
                    <th><?php echo $this->Paginator->sort('bb_date', 'Best before'); ?></th>
                    <th><?php echo $this->Paginator->sort('batch'); ?></th>
                    <th><?php echo $this->Paginator->sort('qty'); ?></th>
                    <th><?php echo $this->Paginator->sort('shipment_id', 'Shipment'); ?></th>
                    <th><?php echo $this->Paginator->sort('inventory_status_id', 'Status / Note'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pallets as $pallet) : ?>
                <?php
                    if ($pallet['oncooldown']) {
                        $cls = 'bg-info';
                    } elseif ($pallet['ship_low_date']) {
                        $cls = 'bg-warning';
                    } elseif ($pallet['dont_ship']) {
                        $cls = 'bg-danger';

                    } elseif ( count($pallet['cartons']) > 1 ) {
                        $cls = 'bg-secondary';
                    } else {
                        $cls = '';
                    }
                    $classString = $this->Html->buildClass($cls);
                ?>
                <tr>
                    <td <?= $classString; ?>>
                        <?php if($pallet->has('location')): ?>
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
                        <?php else: ?>
                            Missing Location 
                        <?php endif; ?>
                    </td>
                    <td <?= $classString; ?>><?=  h($pallet->code_desc); ?></td>
                    <td <?= $classString; ?>>
                        <?php echo h($pallet['pl_ref']); ?>
                    </td>
                    <td <?= $classString; ?>>
                        <?php echo $this->Html->tag(
                            'span',
                            h($pallet['print_date']->i18nFormat(null, $user->timezone)),
                            ['title' => 'Cooldown date: ' . h($pallet['cooldown_date']->i18nFormat(null, $user->timezone)), 'style' => 'cursor: crosshair;']
                        ); ?></td>
                    <td <?= $classString; ?>>
                        <?php echo h($this->Time->timeAgoInWords($pallet['print_date'])); ?></td>
                    <td <?= $classString; ?>>
                        <?php echo h($pallet['bb_date']->i18nFormat(null, $user->timezone)); ?>
                    </td>
                    <td <?= $classString; ?>>
                        <?php echo h($pallet['batch']); ?></td>
                    <td <?= $classString; ?>>
                        <?php echo h($pallet['qty']); ?>
                    </td>
                    <td <?= $classString; ?>>
                        <?php if ($pallet->has('shipment')) {
                            echo $this->Html->link(
                                $pallet->shipment->shipper,
                                [
                                    'controller' => 'shipments',
                                    'action' => 'process',
                                    'edit-shipment',
                                    $pallet->shipment->id,
                                ],
                                [
                                    'class' => 'btn edit btn-sm btn-link',
                                    'title' => 'Edit Shipment',
                                ]
                            );
                        };
                        ?></td>

                    <td <?= $classString; ?>>
                        <?= $pallet->has('inventory_status') ? h($pallet->inventory_status->name) : ''; ?>
                        <?php if (!empty($pallet['inventory_status_note'])): ?>
                        <p class="x-small" title="<?php echo $pallet['inventory_status_note']; ?>">
                            <?php echo $this->Text->truncate($pallet['inventory_status_note'], 14); ?>
                        </p>
                        <?php endif; ?>
                    </td>
                    <td <?php echo $this->Html->buildClass([$cls, 'actions']); ?>>
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
                                'class' => 'btn edit btn-sm tgn-modal',
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

<?php echo $this->element('modals/pallet_cartons_edit_modal'); ?>