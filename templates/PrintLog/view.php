<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PrintLog $printLog
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Print Log'), ['action' => 'edit', $printLog->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Print Log'), ['action' => 'delete', $printLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printLog->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Print Log'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Print Log'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="printLog view large-9 medium-8 columns content">
    <h3><?= h($printLog->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Print Action') ?></th>
                <td><?= h($printLog->print_action) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($printLog->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($printLog->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($printLog->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4><?= __('Print Data') ?></h4>
        <?= $this->Text->autoParagraph(h($printLog->print_data)); ?>
    </div>
</div>
