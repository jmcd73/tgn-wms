<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Help $help
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Help'), ['action' => 'edit', $help->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Help'), ['action' => 'delete', $help->id], ['confirm' => __('Are you sure you want to delete # {0}?', $help->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Help'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Help'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="help view large-9 medium-8 columns content">
    <h3><?= h($help->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Controller Action') ?></th>
                <td><?= h($help->controller_action) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Markdown Document') ?></th>
                <td><?= h($help->markdown_document) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($help->id) ?></td>
            </tr>
        </table>
    </div>
</div>
