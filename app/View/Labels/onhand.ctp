<?php
    $this->Html->css('weather-icons.min.css', ['inline' => false]);
?>

<div class="container-fluid">
    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-8">
        <div class="row">
            <h3><?=__('Filter');?></h3>
            <?php
                echo $this->Form->create('Label', [
                    'class' => false,
                    'url' => [
                        'action' => 'search'
                    ]
                ]);
            ?>

            <?php
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
            ?>

            <?=$this->Form->end([
	'bootstrap-type' => 'primary',
	'bootstrap-size' => 'lg'
]);?>
        </div>
        <div class="row">
            <h4 class="colour-legend">Colour Legend</h4>

        </div>
        <div class="row">

            <div class="bg-danger alert" role="alert">

              <?=$this->Html->tag("span", "", ['class' => "glyphicon glyphicon-ban-circle", 'aria-hidden' => "true"]);?> Can't ship low dated
            </div>

        </div>

        <div class="row">

           <div class="alert bg-warning">
              <?=$this->Html->tag("span", "", ['class' => "glyphicon glyphicon-ok-circle", 'aria-hidden' => "true"]);?>  Low dated but shippable

</div>
        </div>

        <div class="row">

            <div class="bg-info alert">
              <?=$this->Html->tag("span", "", ['class' => "wi wi-thermometer", 'aria-hidden' => "true"]);?>
                    On cooldown
                    <span class="label label-primary"><?=$cooldown;?> hours</span>
            </div>

        </div>

    </div>
    <div class="clearFix"></div>

    <div class='col-lg-10 col-md-12 col-xs-12 col-sm-12'>
        <p class="h3"><?=__('Pallet Location Report');?>
            <small><span class="label label-default"><?=$this->Paginator->counter(['format' => '{:count} pallets']);?></span>
            <span class="<?=$dont_ship_count === 0 ? 'hidden' : '';?> label label-danger"><?=$dont_ship_count;?> low dated</span></small>
        </p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
                <tr>
                    <th><?=$this->Paginator->sort('location_id');?></th>
                    <th><?=$this->Paginator->sort('item_id');?></th>
                    <th><?=$this->Paginator->sort('description');?></th>
                    <th><?=$this->Paginator->sort('pl_ref');?></th>
                    <th><?=$this->Paginator->sort('print_date');?></th>
                    <th><?=$this->Paginator->sort('pl_age', null, ['title' => "Pallet age in hours"]);?></th>

                    <th><?=$this->Paginator->sort('bb_date', 'Best before', ['title' => "dd/mm/yy"]);?></th>
                    <th><?=$this->Paginator->sort('batch');?></th>
                    <th><?=$this->Paginator->sort('qty');?></th>
                    <th><?=$this->Paginator->sort('shipment_id', 'Alloc');?></th>

                    <th><?=$this->Paginator->sort('inventory_status_id', 'Status / Note');?></th>


                    <th class="actions"><?=__('Actions');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($labels as $label): ?>
<?php
    $cls = '';
    if ($label['Label']['oncooldown']) {
        $cls = "bg-info";
    } elseif ($label['Label']['ship_low_date']) {
        $cls = "bg-warning";
    } elseif ($label['Label']['dont_ship']) {
        $cls = "bg-danger";
    }
?>
                    <tr>
                        <td <?=$this->Html->buildClass($cls);?>>
							<?=$this->Html->link(
    h($label['Location']['location']), [
        'action' => 'move',
        $label['Label']['id']],
    [
        'title' => "Click here to move this pallet"
    ]);
?></td>
                        <td <?=$this->Html->buildClass($cls);?>><?=h($label['Item']['code']);?></td>
                        <td <?=$this->Html->buildClass($cls);?>><?=h($label['Item']['description']);?></td>
                        <td <?=$this->Html->buildClass($cls);?>><?=h($label['Label']['pl_ref']);?></td>
                        <td <?=$this->Html->buildClass($cls);?>><?=$this->Html->tag(
    'span',
    $this->Time->format($label['Label']['print_date'], '%d/%m/%Y %r'),
    ['title' => 'Cooldown date: ' . $this->Time->format($label['Label']['cooldown_date'], '%d/%m/%Y %r'), 'style' => 'cursor: crosshair;']
);?></td>
                        <td <?=$this->Html->buildClass($cls);?>><?=h($label['Label']['pl_age']);?></td>

                        <td <?=$this->Html->buildClass($cls);?>><?=
h($this->Time->format($label['Label']['bb_date'], '%d/%m/%y'));?></td>
                        <td <?=$this->Html->buildClass($cls);?>><?=h($label['Label']['batch']);?></td>

                        <td <?=$this->Html->buildClass($cls);?>><?=h($label['Label']['qty']);?></td>

                        <td <?=$this->Html->buildClass($cls);?>><?php
                        if($label['Shipment']['shipper']) {
                            echo $this->Html->link(
                                $label['Shipment']['shipper'], [
                                    'controller' => 'shipments',
                                    'action' => 'addApp',
                                    'edit',
                                    $label['Shipment']['id']], [
                                    'class' => 'btn edit btn-xs',
                                    'title' => 'Edit Shipment'
                            ]);
                        };
?></td>

                        <td <?=$this->Html->buildClass($cls);?>>
                            <?=h($label['InventoryStatus']['name']);?>
<?php if (!empty($label['Label']['inventory_status_note'])): ?>
                            <p class="x-small" title="<?=$label['Label']['inventory_status_note'];?>">
                                <?=$this->Text->truncate($label['Label']['inventory_status_note'], 14);?>
                            </p>
                            <?php endif;?>
                        </td>
                        <td  <?=$this->Html->buildClass([$cls, 'actions']);?>>
                            <?php
                                echo $this->Html->link(
                                    __('Edit'), [
                                        'action' => 'editPallet',
                                        $label['Label']['id']
                                    ], [
                                        'class' => 'btn edit btn-xs',
                                        'title' => 'Click here to put the product on hold, change the quantity or allow it to ship if it is low dated'
                                    ]);
                            ?>
                        </td>
                    </tr>
                <?php endforeach;?>
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
</div>
