<?php //debug($labels)   ?>
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
<?php if ($labels): ?>
<div class="container">
   <div class="col-lg-12">
    <h3><?=
__('There are <span class="label label-default">%d</span> pallets to put away', $this->Paginator->counter(['format' => '{:count}']));
?> </h3>
<?php //echo $this->Html->link(__('Oil put-away'), array('controller' => 'labels', 'action' => 'unassigned_pallets', 'putawayoil'), array('title' => "Click to move oil pallets to bottling"));   ?>
    <table class="table table-hover table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>


                <th><?=$this->Paginator->sort('item');?></th>
                <th><?=$this->Paginator->sort('description');?></th>
                <th><?=$this->Paginator->sort('best_before');?></th>
                <th><?=$this->Paginator->sort('pl_ref');?></th>
                <th><?=$this->Paginator->sort('qty');?></th>
                <th><?=$this->Paginator->sort('sscc');?></th>
                <th><?=$this->Paginator->sort('batch');?></th>
                <th class="actions"><?=__('Actions');?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($labels as $label): ?>
            <tr>
                <td><?=h($label['Label']['item']);?></td>
                <td><?=h($label['Label']['description']);?></td>
                <td><?=h($label['Label']['best_before']);?></td>
                <td><?=h($label['Label']['pl_ref']);?></td>
                <td><?=h($label['Label']['qty']);?></td>
                <td><?=h($label['Label']['sscc']);?></td>
                <td><?=h($label['Label']['batch']);?></td>
                <td class="actions text-center">
                    <?php
                        echo $this->Html->link(
                            __('Put-away'),
                            [
                                'controller' => 'labels',
                                'action' => 'put_away',
                                $label['Label']['id']
                            ],
                            ['class' => 'btn btn-primary']);
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
<?php endif;?>

<?php // debug($last_pallet); ?>
