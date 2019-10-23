<?php $this->Html->css('std_rates/std_rates', ['inline' => false]); ?>
<div class="machinesStandardRates index">

    <h3><?= __('Machines Standard Rates'); ?></h3>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id'); ?></th>
                <th><?= $this->Paginator->sort('machine_id'); ?></th>
                <th><?= $this->Paginator->sort('pack_size_id'); ?></th>
                <th><?= $this->Paginator->sort('standard_rate'); ?></th>
                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($machinesStandardRates as $machinesStandardRate): ?>
                <tr>
                    <td><?= h($machinesStandardRate['MachinesStandardRate']['id']); ?></td>
                    <td>
    <?= $this->Html->link($machinesStandardRate['Machine']['machine'], ['controller' => 'machines', 'action' => 'view', $machinesStandardRate['Machine']['id']]); ?>
                    </td>
                    <td>
    <?= $this->Html->link($machinesStandardRate['PackSize']['pack_size'], ['controller' => 'pack_sizes', 'action' => 'view', $machinesStandardRate['PackSize']['id']]); ?>
                    </td>
                    <td><?= h($machinesStandardRate['MachinesStandardRate']['standard_rate']); ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $machinesStandardRate['MachinesStandardRate']['id']]); ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $machinesStandardRate['MachinesStandardRate']['id']]); ?>
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $machinesStandardRate['MachinesStandardRate']['id']], [], __('Are you sure you want to delete # %s?', $machinesStandardRate['MachinesStandardRate']['id'])); ?>
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
