<div class="container-fluid">
    <div class="col-lg-1 col-md-1">
        <?php
            echo $this->Form->create();
            echo $this->Form->input('start_date', [
                'type' => 'date', 'dateFormat' => 'DMY']);

            echo $this->Form->end([
                'bootstrap-size' => 'sm',
                'bootstrap-type' => 'primary'
            ]);
        ?>
    </div>
    <div class="col-lg-11 col-md-11">
        <?php if (!empty($shift_date)): ?>
        <h4>Shift Report for&nbsp;<?php echo $this->Time->format('D d M Y', $shift_date); ?></h4>
        <?php endif; ?>
        <?php if (!empty($reports)): ?>
        <?php foreach ($reports as $report): ?>
        <?php $panelType = !empty($report['report']) ? 'primary' : 'warning' ?>
        <div class="panel panel-<?php echo $panelType; ?>">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $report['shift']['Shift']['name']; ?> -
                    <?php echo $this->Time->format('h:i a', $report['shift']['Shift']['start_time']); ?> to
                    <?php echo $this->Time->format('h:i a', $report['shift']['Shift']['stop_time']); ?></h3>
            </div>
            <?php if (!empty($report['report'])): ?>
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Line</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Run Time</th>
                        <th>Cartons</th>
                        <th>Pallets.Ctns</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($report['report'] as $report_line): ?>
                    <tr>
                        <td><?php echo $report_line['production_line']; ?></td>
                        <td><?php echo $report_line['item']; ?></td>
                        <td><?php echo $report_line['description']; ?></td>
                        <td><?php echo $report_line['first_pallet']; ?></td>
                        <td><?php echo $report_line['last_pallet']; ?></td>
                        <td><?php echo $report_line['run_time']; ?></td>
                        <td><?php echo $report_line['carton_total']; ?></td>

                        <td><?php echo $report_line['pallets']; ?></td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="panel-body">
                <?php echo $this->element('Flash/error', ['message' => "No production data", 'key' => 'test']); ?>
            </div>
            <?php endif; ?>

        </div>

        <?php $panelType = empty($report['Cartons']) ? 'warning' : 'info' ?>
        <div class="panel panel-<?php echo $panelType; ?>">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $report['shift']['Shift']['name']; ?> - Part or changed pallets</h3>
            </div>
            <?php if (!empty($report['Cartons'])): ?>
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Line</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Pl Ref</th>
                        <th>Cartons</th>
                        <th>Orig. Prod Date</th>
                        <th>Prod date</th>
                        <th>Best Before</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($report['Cartons'] as $carton): ?>


                    <?php $cartonTotal = 0;
                        $palletTotal = 0;
                        $qtyPrevious = 0;
                    ?>

                    <?php foreach ($carton['Carton'] as $cartonRecord): ?>
                    <?php $palletTotal = $carton['Item']['quantity'];
    $cartonTotal += $cartonRecord['count'];
$qtyPrevious = $carton['Pallet']['qty_previous'] ?>
                    <tr>
                        <td><?php echo $carton['ProductionLine']['name']; ?></td>
                        <td><?php echo $carton['Pallet']['item']; ?></td>
                        <td><?php echo $carton['Pallet']['description']; ?></td>
                        <td><?php echo $carton['Pallet']['pl_ref']; ?></td>

                        <td><?php echo $cartonRecord['count']; ?></td>
                        <td><?php echo $carton['Pallet']['print_date']; ?></td>
                        <td><?php echo $cartonRecord['production_date']; ?></td>
                        <td><?php echo $cartonRecord['best_before']; ?></td>
                        <td><?php echo $this->Html->link('Edit', [
                                    'controller' => 'Cartons',
                                    'action' => 'editPalletCartons',
                                    $carton['Pallet']['id']
                                ],
                                ['class' => 'btn btn-link btn-xs edit']); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php $movement = $cartonTotal - $qtyPrevious; ?>

                    <?php if ($cartonTotal == $qtyPrevious) {
                            $movementClass = 'movement-none';
                        } elseif ($movement < 0) {
                            $movementClass = 'movement-down';
                        } else {
                            $movementClass = 'movement-up';
                        }
                    ; // ?>

                    <tr>
                        <td colspan="4" class="text-right">

                            <div class="small pallet-info"><strong>Full Pallet Qty</strong><span
                                    class="secondary-text"><?php echo $palletTotal; ?></span></div>
                            <div class="small pallet-info"><strong>Qty Previous</strong><span
                                    class="secondary-text"><?php echo $qtyPrevious; ?></span></div>
                            <div class="small pallet-info"><strong>Movement</strong><span
                                    class="secondary-text"><?php echo __('<span class="%s">%d</span>', $movementClass, $movement); ?></span>
                            </div>

                        </td>

                        <td class='total-cell'>
                            <?php echo __('<strong>%d</strong>', $cartonTotal); ?>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="panel-body">
                <?php echo $this->element('Flash/error', ['message' => "No part or changed quantity pallets during shift", 'key' => 'test']); ?>
            </div>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>