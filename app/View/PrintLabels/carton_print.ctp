<?php $this->Html->script(
        [
            'carton-label-print',
            'typeahead.bundle.min'
        ], [
            'block' => 'from_view'
        ]
    );

    $this->Html->css(
        [
            'bottling/bottling-ui'
        ],
        [
            'inline' => false
    ]);?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <span id="global-error"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="keypad">
                <button class="btn btn-primary keypad" data-value="3">3</button>
                <button class="btn btn-primary keypad" data-value="2">2</button>
                <button class="btn btn-primary keypad" data-value="1">1</button>
                <button class="btn btn-primary keypad" data-value="6">6</button>
                <!--    <button class="btn btn-primary keypad" v2="">v2</button>-->
                <button class="btn btn-primary keypad" data-value="5">5</button>
                <button class="btn btn-primary keypad" data-value="4">4</button>
                <button class="btn btn-primary keypad" data-value="9">9</button>
                <button class="btn btn-primary keypad" data-value="8">8</button>
                <button class="btn btn-primary keypad" data-value="7">7</button>
                <button class="btn btn-primary keypad" data-value="back-space"><span><i class="glyphicon glyphicon-triangle-left"></i>BS</span></button>
                <!--    <button class="btn btn-primary keypad" v2="">v2</button>-->
                <button class="btn btn-primary keypad" data-value="0">0</button>
                <button class="btn btn-primary keypad" data-value="delete"><i class="glyphicon glyphicon-remove"></i></button>
                <button class="btn btn-primary keypad" data-value="print"  h2="">Print</button>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 carton-form">
            <div class="row">
                <div class='col-lg-4 col-md-4'>
                    <h3>
                        Carton Label Details
                    </h3>

                    <?php
                        echo $this->Form->input('print_action', [
                            'type' => 'hidden',

                            'id' => 'print_action',
                            'value' => $print_action
                        ]);
                        echo $this->Form->input('product-list', [
                            'type' => 'hidden',
                            'id' => 'product-list',
                            'data-print_url' => $this->Html->url([
                                'action' => 'printCartonLabels'
                            ]),
                            'data-url' => $this->Html->url([
                                'controller' => 'items',
                                'action' => 'productListByCode'
                            ])]);
                    ?>
<?php
    echo $this->Form->input('cartons-item', [
        'type' => 'text',
        'id' => 'cartons-item',
        'label' => 'Item'

    ]);
?>

                    <?php
                        echo $this->Form->input('carton-desc', [
                            'type' => 'text',
                            'id' => 'cartons-desc',
                            'label' => 'Description'
                        ]);
                    ?>

                    <?php
                        echo $this->Form->input('cartons-gtin14', [
                            'type' => 'text',
                            'id' => 'cartons-gtin14',
                            'label' => 'Trade Unit Barcode'
                        ]);
                    ?>
                </div>
                <div class="col-lg-4 col-md-4 tpad text-center">

                    <?=$this->Html->image('/files/templates/100x50carton.png', [
    'alt' => "Sample Carton Label",
    'class' => 'img-responsive tpad'
]);?>

                    <small><em>Sample carton label</em></small>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <h4>Label Printer</h4>
                    <?php foreach ($printers as $printer => $name): ?>

                    <label class="radio-inline">
                        <input <?= (int)$default === (int)$printer ? 'checked="checked"' : ''?> type="radio" name="printer_id" id="PrinterRadio<?=$printer;?>" value="<?=$printer;?>"><?=$name;?>
                    </label>

                    <?php endforeach;?>



                    </div>

                <div class="row">

                    <h4>Select quantity to print</h4>
                    <div class="btn-group btn-group-lg qty-group" role="group" id="cartons-pallet-count">

                        <?php foreach ([1, 10, 20, 50, 100, 200, 400] as $button): ?>
<?php $class = ($button === 1) ? 'active ' : '';?>
                            <button type="button" class="<?=$class;?>btn btn-default qty" id="<?='button-' . $button;?>">
                                <?=$button;?>
                            </button>
                        <?php endforeach;?>

                    </div>
                    <!-- popup for part pallet weight -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cartonLabelPrintModal" tabindex="-1" role="dialog" aria-labelledby="cartonLabelPrintModalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cartonLabelPrintModalTitle">Label Print</h4>
            </div>
            <div class="modal-body">
                <p id="pallet-count"></p>
                <div class="alert alert-warning tpad" role="alert">
					<?= $this->Html->tag('i', '', [ 'class' => 'glyphicon glyphicon-warning-sign' ]); ?> <strong>Warning!</strong> Remember to load 100x50 labels into the printer
				</div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="button" class="col-lg-12 col-md-12 col-sm-12 btn btn-lg btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <button id="modal-print-button" type="button" class="col-lg-12 col-md-12 col-sm-12 tpad btn btn-lg btn-primary">Print</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
