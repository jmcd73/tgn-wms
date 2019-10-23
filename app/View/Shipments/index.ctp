
<div class="container">
    <div class="row">
    <div class="col-lg-12">

            <H3><?=__('Shipments'); ?> <small>
                <?= $this->Html->tag('span', $count. ' to be shipped', [
                    'title' => "Number of pallets to be shipped",
                    'class' => (bool) $count ? 'label label-warning' : 'label label-success'
                ]); ?>
            </small></H3>

            <div class="bpad10">

            <?php foreach ($productTypes as $pt): ?>
                    <?php echo $this->Html->link(
                                'Add ' . $pt['ProductType']['name'],
                                [
                                    'action' => 'addApp',
                                    'add', $pt['ProductType']['id']
                                ],
                                [
                                    'escape' => false,
                                    'class' => 'btn btn-xs btn-primary add']);
                        ?>
            <?php endforeach; ?>
            </div>



    </div>
    </div>
<div class="row">
<div class="col-lg-12">
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th class="text-center"><?=$this->Paginator->sort('shipped'); ?></th>
                <th><?=$this->Paginator->sort('product_type_id', 'Type'); ?></th>
                <th><?=$this->Paginator->sort('shipper'); ?></th>
                <th><?=$this->Paginator->sort('destination'); ?></th>
                <th class="text-center"><?=$this->Paginator->sort('label_count', "No. pallets", ['title' => "Number of pallets on shipment"]); ?></th>
                <th class="hidden-xs"><?=$this->Paginator->sort('created'); ?></th>
                <th class="hidden-xs"><?=$this->Paginator->sort('modified'); ?></th>
                <th class="actions"><?=__('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shipments as $shipment): ?>
                <tr>
                    <td class="text-center">
                        <?php $icon = $shipment['Shipment']['shipped'] == 1 ? 'fas fa-toggle-on' : 'fas fa-toggle-off';
                            echo $this->Form->postLink(
                                '<i class="' . $icon . '"></i>',
                                [
                                    'action' => 'toggleShipped',
                                    $shipment['Shipment']['id']
                                ], [
                                    'escape' => false,
                                    'class' => 'btn btn-xs'], __('Are you sure you want to toggle shipped state # %s?', $shipment['Shipment']['id']));
                        ?>
						</td>

                    <td><?=Inflector::humanize($shipment['ProductType']['name']); ?></td>
                    <td><?=h($shipment['Shipment']['shipper']); ?></td>
                    <td><?=h($shipment['Shipment']['destination']); ?></td>
                    <td class="text-center"><?=h($shipment['Shipment']['label_count']); ?></td>
                    <td class="hidden-xs"><?=h($shipment['Shipment']['created']); ?></td>
                    <td class="hidden-xs"><?=h($shipment['Shipment']['modified']); ?></td>
                    <td class="actions">
                        <?php
                            echo $this->Html->link(
                                '<i class="fas fa-file-pdf"></i>' . __(' PDF'), ['action' => 'pdfPickList', $shipment['Shipment']['id']], [
                                    'escape' => false,
                                    'target' => '_blank',
                                    'class' => 'btn btn-xs']
                            );
                        ?>
                        <?=$this->Html->link(
    '<i class="fas fa-eye"></i>' . __(' View'),
    ['action' => 'view', $shipment['Shipment']['id']],
    [
        'escape' => false,
        'class' => 'btn btn-xs']);
?>
                        <?=$this->Html->link(

    '<i class="fas fa-edit"></i>' . __(' Edit'),
    ['action' => 'addApp', 'edit', $shipment['Shipment']['id']],
    [
        'escape' => false,
        'class' => 'btn btn-xs']);
?>
<?php
    echo $this->Form->postLink(
        '<i class="fas fa-trash-alt"></i>' . __(' Delete'),
        ['action' => 'delete', $shipment['Shipment']['id']], [
            'escape' => false,
            'class' => 'btn btn-xs'], __('Are you sure you want to delete # %s?', $shipment['Shipment']['id']));
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
</div>