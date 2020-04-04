<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PrintTemplate[]|\Cake\Collection\CollectionInterface $printTemplates
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Print Template'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('description') ?></th>
        <th scope="col"><?= $this->Paginator->sort('text_template') ?></th>
        <th scope="col"><?= $this->Paginator->sort('file_template') ?></th>
        <th scope="col"><?= $this->Paginator->sort('active') ?></th>
        <th scope="col"><?= $this->Paginator->sort('is_file_template') ?></th>
        <th scope="col"><?= $this->Paginator->sort('print_action') ?></th>
        <th scope="col"><?= $this->Paginator->sort('print_controller') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('example_image') ?></th>
        <th scope="col"><?= $this->Paginator->sort('file_template_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('file_template_size') ?></th>
        <th scope="col"><?= $this->Paginator->sort('example_image_size') ?></th>
        <th scope="col"><?= $this->Paginator->sort('example_image_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('show_in_label_chooser') ?></th>
        <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('replace_tokens') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($printTemplates as $printTemplate) : ?>
        <tr>
            <td><?= $this->Number->format($printTemplate->id) ?></td>
            <td><?= h($printTemplate->name) ?></td>
            <td><?= h($printTemplate->description) ?></td>
            <td><?= h($printTemplate->text_template) ?></td>
            <td><?= h($printTemplate->file_template) ?></td>
            <td><?= h($printTemplate->active) ?></td>
            <td><?= $this->Number->format($printTemplate->is_file_template) ?></td>
            <td><?= h($printTemplate->print_action) ?></td>
            <td><?= h($printTemplate->print_controller) ?></td>
            <td><?= h($printTemplate->created) ?></td>
            <td><?= h($printTemplate->modified) ?></td>
            <td><?= h($printTemplate->example_image) ?></td>
            <td><?= h($printTemplate->file_template_type) ?></td>
            <td><?= $this->Number->format($printTemplate->file_template_size) ?></td>
            <td><?= $this->Number->format($printTemplate->example_image_size) ?></td>
            <td><?= h($printTemplate->example_image_type) ?></td>
            <td><?= h($printTemplate->show_in_label_chooser) ?></td>
            <td><?= $printTemplate->has('parent_print_template') ? $this->Html->link($printTemplate->parent_print_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $printTemplate->parent_print_template->id]) : '' ?></td>
            <td><?= h($printTemplate->replace_tokens) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $printTemplate->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $printTemplate->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $printTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printTemplate->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>
