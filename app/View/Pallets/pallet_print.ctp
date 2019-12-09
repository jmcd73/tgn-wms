<?php $this->Html->script([
        'jquery.cookie',
        'pallet-print'
    ], [
        'inline' => false,
        'block' => 'from_view'
    ]
); ?>

<div <?php echo $this->Html->buildClass([
    "container",
    $this->request->controller,
    $this->request->action
]); ?>>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="col-lg-12">
                <?php echo __("Print %s Pallet Labels", Inflector::humanize($product_type));
$this->Html->link(
    $this->Html->tag(
        'i',
        '',
        [
            'aria-hidden' => "true",
            'class' => 'glyphicon glyphicon-question-sign'
        ]
    ),
    [
        'controller' => 'pages',
        'action' => 'display',
        'pallet_print_help'
    ],
    [
        'escape' => false
    ]
); ?></h3>
            <?php foreach (['left', 'right'] as $palletForm): ?>
            <?php $formName = 'PalletLabel' . Inflector::humanize($palletForm) . 'PalletPrintForm'; ?>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="col-lg-12 col-md-12 col-md-12 well">
                    <?php echo $this->Form->create($formName
    ,
    [
        'id' => $formName,
        'class' => 'pallet-print'
    ]
); ?>

                    <?php echo $this->Form->hidden(
    'formName',
    [
        'class' => 'formName',
        'value' => $palletForm
    ]
); ?>
                    <?php echo $this->Form->input('item', [
    'class' => 'item',
    'empty' => '(select)'
]); ?>
                    <?php echo $this->Form->input(
    'production_line',
    [
        'options' => $productionLines,
        'empty' => '(select)'
    ]); ?>
                    <?php echo $this->Form->hidden('product_type', ['value' => $product_type, 'class' => 'product_type']); ?>
                    <?php echo $this->Form->input('part_pallet', [
    'type' => 'checkbox',
    'data-queryurl' => $this->Html->url(['controller' => 'items', 'action' => 'product'])]); ?>
                    <?php echo $this->Form->input('qty', ['class' => 'qty', 'type' => 'select', 'div' => ['class' => 'form-group', 'style' => 'display: none;']]); ?>
                    <?php echo $this->Form->input('batch_no',
    [
        'options' => $batch_nos,
        'empty' => '(select)'
    ]); ?>
                    <?php echo $this->Form->button(
    $this->Html->tag('i', '', ['class' => 'fas fa-print']) . ' Print...', [
        'class' => 'frm-print col-md-12 ' . $palletForm,
        'bootstrap-size' => 'lg',
        'bootstrap-type' => 'primary',
        'type' => 'button',
        'data-formName' => $formName,
        'escape' => false,
        'data-toggle' => "modal",
        'data-target' => "#dialog"
    ]); ?>
                    <?php echo $this->Form->end(); ?>


                </div>
            </div> <!-- enn col-lg-6 -->
            <?php endforeach; ?>
        </div>
    </div>
    <div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Label Print</h4>
                </div>
                <div class="modal-body">
                    <p>Do you wish to print a <strong id="item"></strong> pallet label?</p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button id="no-button" type="button" data-dismiss="modal"
                                class="col-lg-12 col-md-12 col-sm-12 btn btn-lg btn-default">
                                Cancel
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button"
                                class="col-lg-12 col-md-12 col-sm-12 tpad btn btn-lg btn-primary print">
                                <?php echo $this->Html->tag('i', '', ['class' => 'fas fa-print']); ?> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>