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
        <h4>Shift Report for<?php echo $this->Time->format('d M Y', $shift_date); ?></h4>
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
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>