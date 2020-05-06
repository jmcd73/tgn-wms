<?php
/**
 * @var \App\View\AppView                                                      $this
 * @var \App\Model\Entity\PrintTemplate[]|\Cake\Collection\CollectionInterface $printTemplates
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Print Template'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
        <tr>
         
            <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('example_image') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($printTemplates as $printTemplate) : ?>

        <?php if (!$printTemplate->hasValue('parent_id')): ?>
        <tr>
            <td colspan="4">
                <h4><?= h($printTemplate->name) ?></h4>
            </td>
            <td class="actions">
            <?= $this->element('PrintTemplates/actions', [
                'id' => $printTemplate->id,
            ]); ?>
            </td>
        </tr>
        <?php else: ?>
        <tr>
          
            <td><?= $printTemplate->has('parent_print_template') ? $this->Html->link($printTemplate->parent_print_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $printTemplate->parent_print_template->id]) : '' ?>
            </td>
            <td><?= $printTemplate->hasValue('example_image') ? $this->Html->image(
                $templateRoot . $printTemplate->example_image,
                [
                    'class' => 'example-image',
                ]
            ) : '' ?></td>
            <td><?= h($printTemplate->name) ?></td>
            <td><?= h($printTemplate->description) ?></td>
            <td class="actions">
            <?= $this->element('PrintTemplates/actions', [
                'id' => $printTemplate->id,
            ]); ?>
            </td>
        </tr>
        <?php endif; ?>
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
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>