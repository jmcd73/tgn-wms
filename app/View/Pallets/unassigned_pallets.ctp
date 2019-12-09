<?php //debug($pallets) ?>
<?php
    echo $this->Html->meta(
        [
            'http-equiv' => 'refresh',
            'content' => '10'],
        [],
        [
            'inline' => false
        ]
    );
?>
<?php if ($pallets): ?>
<div class="container">
    <div class="col-lg-12">
        <h3><?php echo
            __('There are <span class="label label-default">%d</span> pallets to put away', $this->Paginator->counter(['format' => '{:count}']));
            ?> </h3>
        <?php //echo $this->Html->link(__('Oil put-away'), array('controller' => 'pallets', 'action' => 'unassigned_pallets', 'putawayoil'), array('title' => "Click to move oil pallets to bottling")); ?>
        <table class="table table-hover table-bordered table-condensed table-striped table-responsive">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('item'); ?></th>
                    <th><?php echo $this->Paginator->sort('description'); ?></th>
                    <th><?php echo $this->Paginator->sort('best_before'); ?></th>
                    <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                    <th><?php echo $this->Paginator->sort('qty'); ?></th>
                    <th><?php echo $this->Paginator->sort('sscc'); ?></th>
                    <th><?php echo $this->Paginator->sort('batch'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pallets as $pallet): ?>
                <tr>
                    <td><?php echo h($pallet['Pallet']['item']); ?></td>
                    <td><?php echo h($pallet['Pallet']['description']); ?></td>
                    <td><?php echo h($pallet['Pallet']['best_before']); ?></td>
                    <td><?php echo h($pallet['Pallet']['pl_ref']); ?></td>
                    <td><?php echo h($pallet['Pallet']['qty']); ?></td>
                    <td><?php echo h($pallet['Pallet']['sscc']); ?></td>
                    <td><?php echo h($pallet['Pallet']['batch']); ?></td>
                    <td class="actions text-center">
                        <?php
                            echo $this->Html->link(
                                __('Put-away'),
                                [
                                    'controller' => 'pallets',
                                    'action' => 'putAway',
                                    $pallet['Pallet']['id']
                                ],
                                ['class' => 'btn btn-primary']);
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
            ?> </p>
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
<?php endif; ?>

<?php // debug($last_pallet); ?>