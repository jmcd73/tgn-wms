<?php
    $this->Html->css([
        'shipments'
    ],
        ['inline' => false]
    );
?>
<?php
    $this->Html->script(
        [
            'typeahead.bundle.min',
            'shipments'],
        [
            'inline' => false,
            'block' => 'from_view'
        ]
    );
?>


<?=$this->Form->create('Shipment');?>

<?=
$this->Form->hidden('shipment_type', [
    'value' => $type
]);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-offset-1 col-lg-3">
            <h3><?='Add ' . Inflector::humanize($shipment_slug) . ' Shipment';?></h3>
            <div class="col-lg-12">
                <?=$this->Form->input('shipped');?>
                <?=$this->Form->input('shipper');?>
                <?=
$this->Form->input('destination', [
    'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/destinationLookup'
]);
?>
                <?=
$this->Form->button('Submit', [
    'class' => 'tpad pull-right',
    'bootstrap-type' => 'primary'
]);
?>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="col-lg-7">
            <h3>Select Products <span id="selected_label_count" class="badge">0</span></h3>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php $item_id = null;?>
<?php foreach ($shipment_labels as $key => $sl): ?>
<?php if ($sl['Pallet']['item_id'] !== $item_id): ?>
<?php $item_id = $sl['Pallet']['item_id']?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading<?=$key;?>">
                                <h5 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapse<?=$key;?>" aria-expanded="false" aria-controls="collapse<?=$key;?>">

                                        <?=$sl['Pallet']['item'] . ' ' . $sl['Pallet']['description'];?>

                                    </a>
                                </h5>
                            </div>
                            <div id="collapse<?=$key;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$key;?>">
                                <div class="panel-body">
	<?php endif;?>

                                <div class="checkbox pallet-list <?=$sl['Pallet']['disabled'] ? 'disabled' : ''

;?>">
                                    <label>
                                        <input aria-label="<?=$sl['Pallet']['name'];?>"
                                               value="<?=$sl['Pallet']['id'];?>"
                                               name="data[Shipment][Pallet][]"
                                               type="checkbox" <?=$sl['Pallet']['disabled'] ? 'disabled' : '';?>>
                                        <!-- icon -->
                                         <?=$sl['Pallet']['disabled'] ? '<span class="glyphicon glyphicon-ban-circle"></span>' : '';?>
                                         <?=$sl['Location']['location'];?>:
					<?=$sl['Pallet']['item'];?>,
                                         <?=$this->Time->format($sl['Pallet']['bb_date'], '%d/%m/%y');?>,
                                         <?=$sl['Pallet']['pl_ref'];?>,
                                         <?=$sl['Pallet']['qty'];?>,
					<?=$sl['Pallet']['description'];?>
                                    </label>
                                </div>
                                <?php if (
                                        isset($shipment_labels[$key + 1]['Pallet']['item_id']) &&
                                        $shipment_labels[$key + 1]['Pallet']['item_id'] !== $item_id
                                ): ?>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>

</div>

<?=$this->element('shipment_footer');?>

<?=$this->Form->end();?>

