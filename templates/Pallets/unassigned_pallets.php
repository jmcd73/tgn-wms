<?php //debug($pallets)?>
<?php
    echo $this->Html->meta(
    [
        'http-equiv' => 'refresh',
        'content' => '10', ],
    [],
    [
        'inline' => false,
    ]
);
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<?php if ($pallets): ?>
<div class="row">
    <div class="col-lg-12">
        <?php $count = $this->Paginator->counter('{{count}}'); ?>
        <?php
            $token_0 = 'are';
            $token_1 = sprintf('<span class="badge badge-info">%d</span>', $count);
            $token_2 = 'pallets';
        if ($count == 1) {
            $token_0 = 'is';
            $token_2 = 'pallet';
        } elseif ($count == 0) {
            $token_1 = 'no';
        } ?>
        <h5><?php echo
            __('There {0} {1} {2} to put away', $token_0, $token_1, $token_2);
            ?> </h5>
        <?php //echo $this->Html->link(__('Oil put-away'), array('controller' => 'pallets', 'action' => 'unassigned_pallets', 'putawayoil'), array('title' => "Click to move oil pallets to bottling"));?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('item'); ?></th>
                    <th><?php echo $this->Paginator->sort('description'); ?></th>
                    <th><?php echo $this->Paginator->sort('bb_date', 'Best Before'); ?></th>
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
                    <td><?php echo h($pallet['item']); ?></td>
                    <td><?php echo h($pallet['description']); ?></td>
                    <td><?php echo h($pallet['bb_date']); ?></td>
                    <td><?php echo h($pallet['pl_ref']); ?></td>
                    <td><?php echo h($pallet['qty']); ?></td>
                    <td><?php echo h($pallet['sscc']); ?></td>
                    <td><?php echo h($pallet['batch']); ?></td>
                    <td class="actions text-center">
                        <?php
                            echo $this->Html->link(
                __('Put-away'),
                [
                    'controller' => 'pallets',
                    'action' => 'putAway',
                    $pallet['id'],
                ],
                ['class' => 'btn btn-primary']
            );
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <?php
                echo $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}');
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

<?php // debug($last_pallet);?>