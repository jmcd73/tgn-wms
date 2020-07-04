<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Settings'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Setting'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="settings view large-9 medium-8 columns content">
    <h3><?= h($setting->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($setting->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Setting') ?></th>
                <td><?= h($setting->setting) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Setting in comment') ?></th>
                <td><?= $this->Html->activeIcon($setting->setting_in_comment) ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->comment)); ?>
        </div>
    </div>
</div>
