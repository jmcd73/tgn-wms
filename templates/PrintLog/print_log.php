<?php

?>

<div class="container">
<table class="table table-bordered table-condensed table-striped table-responsive">
    <thead>
        <tr>
<th><?= $this->Paginator->sort('id'); ?></th>
  <th><?= $this->Paginator->sort('controller_action'); ?></th>
            <th><?= $this->Paginator->sort('print_data'); ?></th>
            <th><?= $this->Paginator->sort('created'); ?></th>
            <th><?= $this->Paginator->sort('modified'); ?></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($printItems as $item): ?>
                <tr>
        <td><?= h($item['PrintLabel']['id']); ?></td>
        <td><?= h($item['PrintLabel']['controller_action']); ?></td>
        <td><pre style="background-color: inherit; border: 0px;"><?= json_encode(
                json_decode($item['PrintLabel']['print_data']),
                JSON_PRETTY_PRINT
        ); ?></pre></td>

        <td><?= h($item['PrintLabel']['created']); ?></td>
        <td><?= h($item['PrintLabel']['modified']); ?></td>
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
