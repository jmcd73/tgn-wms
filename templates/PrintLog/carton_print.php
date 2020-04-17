<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->Html->script(
    [
        'carton-label-print',
        'typeahead.bundle.min',
    ],
    [
        'block' => 'from_view',
    ]
);

    echo $this->Html->css(
        [
            'bottling-ui',
        ]
    );?>
<div class="row">
    <div class="col">
        <span id="global-error"></span>
    </div>

</div>
<div class="row">
    <div class="keypad-col mr-3">
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
            <button class="btn btn-primary keypad" data-value="back-space">
                <?= $this->Html->icon('backspace'); ?>
            </button>
            <!--    <button class="btn btn-primary keypad" v2="">v2</button>-->
            <button class="btn btn-primary keypad" data-value="0">0</button>
            <button class="btn btn-primary keypad" data-value="delete">
                <?= $this->Html->icon('trash-alt'); ?>
            </button>
            <button class="btn btn-primary keypad" data-value="print" h2="">Print</button>
        </div>
    </div>
    <div class="col-9">
        <div class="row">
            <div class='col-4'>
                <?php
                        echo $this->Form->hidden('controller_action', [
                            'id' => 'controller_action',
                            'value' => $controller_action,
                        ]);
                        echo $this->Form->hidden('product-list', [
                            'id' => 'product-list',
                            'data-print_url' => $this->Url->build([
                                'action' => 'printCartonLabels',
                            ]),
                            'data-url' => $this->Url->build([
                                'controller' => 'items',
                                'action' => 'productListByCode',
                            ]), ]);?>
                <?php
                        echo $this->Form->control('cartons-item', [
                            'type' => 'text',
                            'id' => 'cartons-item',
                            'label' => 'Item',
                        ]);?>

                <?php
                        echo $this->Form->control('carton-desc', [
                            'type' => 'text',
                            'id' => 'cartons-desc',
                            'label' => 'Description',
                        ]);
                    ?>
                <?php
                        echo $this->Form->control('cartons-gtin14', [
                            'type' => 'text',
                            'id' => 'cartons-gtin14',
                            'label' => 'Trade Unit Barcode',
                        ]);
                    ?>
            </div>
            <div class="col-8">
                <?= $this->element('printImage/card', [
                    'name' => $template->details['name'],
                    'description' => $template->details['description'],
                    'image' => $template->image,
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?= $this->Form->control('printer_id', [
                    'type' => 'radio',
                    'legend' => false,
                    'label' => 'Select Printer',
                    'inline' => true,
                    'options' => $printers['printers'],
                    'default' => $printers['default'] ? $printers['default'] : '',
                ]) ?>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="print-heading">Select quantity to print</div>
                <?php $buttonValues = [1, 10, 20, 50, 100, 200, 400]; ?>
                <?php $buttonOptions = array_combine($buttonValues, $buttonValues); ?>
                <?= $this->Form->control('copies', [
                    'type' => 'radio',
                    'inline' => true,
                    'label' => false,
                    'options' => $buttonOptions,
                    'nestedInput' => true,
                    'hiddenField' => false,
                    'autocomplete' => 'off',
                    'value' => 1,
                    'templates' => [
                        'radioContainer' => '<div data-toggle="buttons" class="btn-group btn-group-toggle {{type}}{{required}}" role="group" ' .
                'aria-labelledby="{{groupId}}">{{content}}{{help}}</div>',
                        'radioInlineWrapper' => '{{label}}',
                        'nestingLabelNestedInput' => '{{hidden}}<label class="btn btn-lg btn-secondary" {{attrs}}>{{input}}{{text}}{{tooltip}}</label>',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>


<?= $this->element('modals/carton_print_modal'); ?>