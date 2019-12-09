<?php $this->Html->script(
        'edit-modal',
        [
            'inline' => false,
            'block' => 'from_view'
    ]); ?>
<div class="container-fluid">
    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-8">
        <div class="row">
            <h3><?php echo __('Filter'); ?></h3>
            <?php echo $this->Form->create('Pallet', [
                    'class' => false,
                    'url' => [
                        'action' => 'search'
                    ]
                ]);
                echo $this->Form->input('filter_value', [
                    'label' => false,
                    'before' => '<div>',
                    'after' => '</div>',
                    'type' => 'select',
                    'options' => $filter_values,
                    'empty' => "(select)",
                    'class' => 'form-control',
                    'div' => ['class' => 'form-group']
                ]);
                echo $this->Form->end([
                    'bootstrap-type' => 'primary',
                    'bootstrap-size' => 'lg'
            ]); ?>
        </div>
        <div class="row">
            <h4 class="colour-legend">Colour Legend</h4>
        </div>
        <div class="row">
            <div class="bg-danger alert" role="alert">
                <?php echo $this->Html->tag("span", "", ['class' => "glyphicon glyphicon-ban-circle", 'aria-hidden' => "true"]); ?>
                Can't ship low dated
            </div>
        </div>
        <div class="row">
            <div class="alert bg-warning">
                <?php echo $this->Html->tag("span", "", ['class' => "glyphicon glyphicon-ok-circle", 'aria-hidden' => "true"]); ?>
                Low dated but shippable
            </div>
        </div>
        <div class="row">
            <div class="bg-info alert">
                <?php echo $this->Html->tag("span", "", ['class' => "wi wi-thermometer", 'aria-hidden' => "true"]); ?>
                On cooldown
                <span class="label label-primary"><?php echo $cooldown; ?> hours</span>
            </div>
        </div>
    </div>
    <div class="clearFix"></div>
    <div class='col-lg-10 col-md-12 col-xs-12 col-sm-12'>
        <p class="h3"><?php echo __('Pallet Location Report'); ?>
            <small>
                <span class="label label-default">
                    <?php echo $this->Paginator->counter(['format' => '{:count} pallets']); ?>
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
                    <th><?php echo $this->Paginator->sort('pl_age', null, ['title' => "Pallet age in hours"]); ?></th>
                    <th><?php echo $this->Paginator->sort('bb_date', 'Best before', ['title' => "dd/mm/yy"]); ?></th>
                    <th><?php echo $this->Paginator->sort('batch'); ?></th>
                    <th><?php echo $this->Paginator->sort('qty'); ?></th>
                    <th><?php echo $this->Paginator->sort('shipment_id', 'Alloc'); ?></th>
                    <th><?php echo $this->Paginator->sort('inventory_status_id', 'Status / Note'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pallets as $pallet): ?>
                <?php if ($pallet['Pallet']['oncooldown']) {
        $cls = "bg-info";
    } elseif ($pallet['Pallet']['ship_low_date']) {
        $cls = "bg-warning";
    } elseif ($pallet['Pallet']['dont_ship']) {
        $cls = "bg-danger";
    } else {
        $cls = '';
} ?>
                <tr>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo $this->Html->tag('a', '', [
                                'id' => $pallet['Pallet']['pl_ref'],
                                'class' => 'anchor']);
                            echo $this->Html->link(
                                h($pallet['Location']['location']), [
                                    'action' => 'move',
                                    $pallet['Pallet']['id']],
                                [
                                    'title' => "Click here to move this pallet"
                                ]);
                        ?>
                    </td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['Item']['code']); ?>
                    </td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['Item']['description']); ?>
                    </td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['Pallet']['pl_ref']); ?>
                    </td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo $this->Html->tag(
                                'span',
                                $this->Time->format($pallet['Pallet']['print_date'], '%d/%m/%Y %r'),
                            ['title' => 'Cooldown date: ' . $this->Time->format($pallet['Pallet']['cooldown_date'], '%d/%m/%Y %r'), 'style' => 'cursor: crosshair;']
                        ); ?></td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['Pallet']['pl_age']); ?></td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($this->Time->format($pallet['Pallet']['bb_date'], '%d/%m/%y')); ?>
                    </td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['Pallet']['batch']); ?></td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['Pallet']['qty']); ?>
                    </td>
                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php if ($pallet['Shipment']['shipper']) {
                                echo $this->Html->link(
                                    $pallet['Shipment']['shipper'], [
                                        'controller' => 'shipments',
                                        'action' => 'addApp',
                                        'edit',
                                        $pallet['Shipment']['id']], [
                                        'class' => 'btn edit btn-xs',
                                        'title' => 'Edit Shipment'
                                    ]);
                            }
                        ;
                        ?></td>

                    <td <?php echo $this->Html->buildClass($cls); ?>>
                        <?php echo h($pallet['InventoryStatus']['name']); ?>
                        <?php if (!empty($pallet['Pallet']['inventory_status_note'])): ?>
                        <p class="x-small" title="<?php echo $pallet['Pallet']['inventory_status_note']; ?>">
                            <?php echo $this->Text->truncate($pallet['Pallet']['inventory_status_note'], 14); ?>
                        </p>
                        <?php endif; ?>
                    </td>
                    <td <?php echo $this->Html->buildClass([$cls, 'actions']); ?>>
                        <?php echo $this->Html->link(
                                __('Edit'), '#', [
                                    'data-palletId' => $pallet['Pallet']['id'],
                                    'data-codeDesc' => $pallet['Pallet']['code_desc'],
                                    'data-editPalletCartons' => $this->Html->url([
                                        'controller' => 'Cartons',
                                        'action' => 'editPalletCartons',
                                        $pallet['Pallet']['id']
                                    ]),
                                    'data-moveOrEdit' => $this->Html->url([
                                        'action' => 'editPallet',
                                        $pallet['Pallet']['id']
                                    ]),
                                    'data-toggle' => "modal",
                                    'data-target' => "#edit-modal",
                                    'class' => 'btn edit btn-xs tgn-modal',
                                    'title' => 'Click here for popup edit options menu'
                                ]);
                        ?>
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