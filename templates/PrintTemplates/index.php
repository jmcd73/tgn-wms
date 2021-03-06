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
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('show_in_label_chooser') ?></th>
            <th scope="col"><?= $this->Paginator->sort('send_email') ?></th>
            <th scope="col"><?= $this->Paginator->sort('example_image') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($printTemplates as $printTemplate) : ?>

            <?php if (!$printTemplate->hasValue('parent_id')) : ?>
                <tr>
                    <td><?= $this->Html->activeIcon($printTemplate->active) ?></td>
                    <td><?= $this->Html->activeIcon($printTemplate->show_in_label_chooser) ?></td>
                
                    <td colspan="3">
                        <h5><?= $this->Html->link($printTemplate->name, ['action' => 'view', $printTemplate->id]); ?> - <?= h($printTemplate->description); ?> </h5>
                    </td>
                    <td class="actions">
                        <?= $this->element('PrintTemplates/actions', [
                            'id' => $printTemplate->id,
                        ]); ?>
                    </td>
                </tr>
            <?php else : ?>
                <tr>
                    <td><?= $this->Html->activeIcon($printTemplate->active) ?></td>
                    <td><?= $this->Html->activeIcon($printTemplate->show_in_label_chooser) ?></td>
                    <td><?= $this->Html->activeIcon($printTemplate->send_email) ?></td>
                    <td><?= $printTemplate->hasValue('example_image') ? $this->Html->link($this->Html->image(
                            $templateRoot . $printTemplate->example_image,
                            [
                                'class' => 'example-image',
                            ]
                        ), ['action' => 'view', $printTemplate->id], [
                            'title' => "View details",
                            'escape' => false
                        ]) : '' ?></td>
                    <td>
                        <?= h($printTemplate->name) ?><br />
                        <?= h($printTemplate->description) ?><br>
                        <small><?= h($printTemplate->print_class); ?></small>
                    </td>
                 
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