
<?php
$this->Html->css([
    'shipments'], ['inline' => false]);
?>
<?php
$this->Html->script([
    'typeahead.bundle.min',
    'moment-with-locales.min',
    'bootstrap-datetimepicker.min',
    'shipments'], ['inline' => false, 'block' => 'from_view'])
?>
<?= $this->Form->create('Shipment'); ?>
<?= $this->Form->hidden('referer', [
    'value' => $referer
]); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-offset-1 col-lg-3">
            <?=
            $this->Form->hidden('shipment_type', [
                'value' => $type
            ]);
            ?>

            <?= $this->Form->input('id'); ?>

                <?php $difot = !Configure::read('Difot') ?: 'col-lg-offset-2'; ?>

                    <h3><?= 'Edit ' . Inflector::humanize($type) . ' Shipment'; ?></h3>

                        <?= $this->Form->input('shipped'); ?>

                        <?= $this->Form->input('shipper'); ?>
                        <?=
                        $this->Form->input('destination', [
                            'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/destinationLookup',
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

                <?php if (Configure::read('Difot')): ?>
                    <div class="col-lg-8">
                        <h4>DIFOT</h4>
                        <div class="col-lg-3 well">


                            <?=
                            $this->Form->input('operator_id', [
                                'empty' => '(select operator)'
                            ]);
                            ?>

                            <?=
                            $this->Form->input('truck_rego', [
                                'append' => $this->Html->tag('i', '', [
                                    'class' => 'glyphicon glyphicon-remove',
                                ])
                            ]);
                            ?>


                            <?=
                            $this->Form->input('truck_registration_id', [
                                'error' => [
                                    'escape' => false
                                ],
                                'empty' => '(select one)']);
                            ?>
                            <?= $this->Form->input('con_note'); ?>

                        </div>

                        <div class="col-lg-3">
                            <?php if ($type === 'marg'): ?>
                                <div class="col-lg-12 well">
                                    <h4>Temps &#8451;</h4>
                                    <?=
                                    $this->Form->input('truck_temp', [
                                        'append' => $this->Html->tag('i', '', [
                                            'class' => 'wi wi-thermometer']),
                                    ]);
                                    ?>
                                    <?=
                                    $this->Form->input('dock_temp', [
                                        'append' => $this->Html->tag('i', '', [
                                            'class' => 'wi wi-thermometer']),
                                    ]);
                                    ?>
                                    <?=
                                    $this->Form->input('product_temp', [
                                        'append' => $this->Html->tag('i', '', [
                                            'class' => 'wi wi-thermometer']),
                                    ]);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-6 well">
                            <div class="col-lg-12">
                                <h4>Timings</h4>
                                <?= $this->Form->hidden('time_start'); ?>
                                <?=
                                $this->Form->input('time_start_i', [
                                    'data-format' => "hh:mm:ss",
                                    'append' => $this->Html->tag('i', '', [
                                        'class' => 'glyphicon glyphicon-time',
                                        'data-time-icon' => "icon-time", 'data-date-icon' => "icon-calendar"]),
                                    'label' => "Time Start"]);
                                ?>
                                <?= $this->Form->hidden('time_finish'); ?>
                                <?=
                                $this->Form->input('time_finish_i', [
                                    'append' => $this->Html->tag('i', '', [
                                        'class' => 'glyphicon glyphicon-time',
                                        'data-time-icon' => "icon-time", 'data-date-icon' => "icon-calendar"]),
                                    'label' => "Time Finish"]);
                                ?>
                                <?=
                                $this->Form->input('time_total', [
                                    'label' => "Total time (mins)"
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

          <div class="col-lg-7">


            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                 <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingCurrent">
                                <h5 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapseCurrent" aria-expanded="true" aria-controls="collapseCurrent">

                                        Currently On Shipment

                                    </a><span id="selected_label_count" class="badge"><?= $selected_label_count; ?></span>
                                </h5>
                            </div>
                            <div id="collapseCurrent" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCurrent">
                                <div class="panel-body">


                                  <?php
            echo $this->Form->input('Label', [
                'multiple' => 'checkbox',

                'class' => 'checkbox pallet-list',
                'label' => false,
              //  'values' => $this_shipment['Label']
                    ]
            );
            ?>


                                </div>
                            </div>
                        </div>



                <?php $item_id = null; ?>
                <?php foreach ($shipment_labels as $key => $sl): ?>
                    <?php if ($sl['Label']['item_id'] !== $item_id): ?>
                    <?php $item_id = $sl['Label']['item_id']  ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading<?= $key; ?>">
                                <h5 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapse<?= $key; ?>" aria-expanded="false" aria-controls="collapse<?= $key; ?>">

                                        <?= $sl['Label']['item'] . ' ' . $sl['Label']['description']; ?>

                                    </a>
                                </h5>
                            </div>
                            <div id="collapse<?= $key; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $key; ?>">
                                <div class="panel-body">
                                <?php endif; ?>

                                <div class="checkbox pallet-list <?= $sl['Label']['disabled'] ? 'disabled': ''

                                        ;?>">
                                    <label>
                                        <input aria-label="<?= $sl['Label']['name'] ;?>"
                                               value="<?= $sl['Label']['id']; ?>"
                                               name="data[Shipment][Label][]"
                                               type="checkbox" <?= $sl['Label']['disabled'] ? 'disabled': '';?>>
                                   <?=  $sl['Label']['disabled'] ? '<span class="glyphicon glyphicon-ban-circle"></span>': ''; ?>
                                         <?= $sl['Location']['location']; ?>:
                                         <?= $sl['Label']['item']; ?>,
                                         <?= $this->Time->format($sl['Label']['bb_date'], '%d/%m/%y'); ?>,
                                         <?= $sl['Label']['pl_ref']; ?>,
                                        <?= $sl['Label']['qty']; ?>,
                                        <?= $sl['Label']['description']; ?>
                                    </label>

                                </div>

                                <?php if ($shipment_labels[$key + 1]['Label']['item_id'] !== $item_id): ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>



                <?php endforeach; ?>

            </div>



            <!-- <?php
            $label = '<h3><span class="label-count">' . $label_count . '</span> pallets available</h3><p><strong>Note:</strong> There are ' . count($disabled) . ' pallets that cannot be shipped due to low date</p>';
            ?>
            <?php
            echo $this->Form->input('Shipment.Label', [
                'multiple' => 'checkbox',
                'disabled' => $disabled,
                'class' => 'checkbox pallet-list',
                'label' => $label,
                    ]
            );
            ?> -->



        </div>

<!--            <div class="col-lg-7">

                <?php
                echo $this->Form->input('Label', [
                    'class' => 'checkbox pallet-list',
                    'label' => '<h3>' . $selected_label_count . ' pallets selected</h3>'
                    . '<p>' . $label_count . ' other pallets available. ' . count($disabled) . ' low dated</p>',
                    'multiple' => 'checkbox',
                    'disabled' => $disabled
                ]);
                ?>

            </div>-->
        </div>
    </div>


<?= $this->element('shipment_footer'); ?>
<?= $this->Form->end(); ?>
