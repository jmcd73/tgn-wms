<div class="container">
<div class="col-lg-12">

          <h3><?= __('Shifts'); ?></h3>
          <?= $this->Html->link('Add', ['action' => 'add'], ['class' => 'btn add btn-primary mb2 btn-xs']); ?>
          </div>
<div class="col-lg-12">
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id'); ?></th>
                <th><?= $this->Paginator->sort('active'); ?></th>

                <th><?= $this->Paginator->sort('name'); ?></th>
                  <th><?= $this->Paginator->sort('product_type_id'); ?></th>
                <th><?= $this->Paginator->sort('start_time'); ?></th>
                <th><?= $this->Paginator->sort('stop_time'); ?></th>

                <th><?= $this->Paginator->sort('shift_minutes'); ?></th>
                <th><?= $this->Paginator->sort('comment'); ?></th>

                <th class="actions"><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shifts as $shift): ?>
                <tr>
                    <td><?= h($shift['Shift']['id']); ?></td>
                    <td><?= h($shift['Shift']['active']); ?></td>

                    <td><?= h($shift['Shift']['name']); ?></td>
                      <td><?= h($shift['ProductType']['name']); ?></td>
                    <td><?= h($shift['Shift']['start_time']); ?></td>
                    <td><?= h($shift['Shift']['stop_time']); ?></td>
                    <td><?= h($shift['Shift']['shift_minutes']); ?></td>
                    <td><?= h($shift['Shift']['comment']); ?></td>

                    <td class="actions">
                        <?= $this->Html->link(
                            __('View'),
                            ['action' => 'view', $shift['Shift']['id']],
                            [ 'class' => 'btn btn-link btn-sm view']
                            ); ?>
                        <?= $this->Html->link(
                            __('Edit'), ['action' => 'edit', $shift['Shift']['id']],
                            [ 'class' => 'btn btn-link btn-sm edit']
                            ); ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $shift['Shift']['id']], [ 'class' => 'btn btn-link btn-sm delete'], __('Are you sure you want to delete # %s?', $shift['Shift']['id'])); ?>
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
