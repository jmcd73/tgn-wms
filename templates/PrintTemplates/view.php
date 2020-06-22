<?php
/**
 * @var \App\View\AppView               $this
 * @var \App\Model\Entity\PrintTemplate $printTemplate
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Print Template'), ['action' => 'edit', $printTemplate->id], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Form->postLink(__('Delete Print Template'), ['action' => 'delete', $printTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printTemplate->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Print Templates'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Print Template'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Parent Print Templates'), ['controller' => 'PrintTemplates', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Parent Print Template'), ['controller' => 'PrintTemplates', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Child Print Templates'), ['controller' => 'PrintTemplates', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Child Print Template'), ['controller' => 'PrintTemplates', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="printTemplates view large-9 medium-8 columns content">

    <h3><?= h($printTemplate->name) ?></h3>

   <?php if ($printTemplate->hasValue('parent_id')): ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($printTemplate->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($printTemplate->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Print Class') ?></th>
                <td><?= h($printTemplate->print_class) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Text Template') ?></th>
                <td><?= h($printTemplate->text_template) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('File Template') ?></th>
                <td><?= $printTemplate->has('file_template') ? 
                $this->Html->link($printTemplate->file_template, ['action' => 'sendFile', $printTemplate->id]): ''; ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Controller/Action') ?></th>
                <td><?= h($printTemplate->controller_action) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Example Image') ?></th>
                <td><?= h($printTemplate->example_image) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Example Image') ?></th>
                <td><?= h($printTemplate->example_image) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('File Template Type') ?></th>
                <td><?= h($printTemplate->file_template_type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Example Image Type') ?></th>
                <td><?= h($printTemplate->example_image_type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Parent Print Template') ?></th>
                <td><?= $printTemplate->has('parent_print_template') ? $this->Html->link($printTemplate->parent_print_template->name, ['controller' => 'PrintTemplates', 'action' => 'view', $printTemplate->parent_print_template->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Replace Tokens') ?></th>
                <td><?= h($printTemplate->replace_tokens) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($printTemplate->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Is File Template') ?></th>
                <td><?= $this->Number->format($printTemplate->is_file_template) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('File Template Size') ?></th>
                <td><?= $this->Number->format($printTemplate->file_template_size) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Example Image Size') ?></th>
                <td><?= $this->Number->format($printTemplate->example_image_size) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Lft') ?></th>
                <td><?= $this->Number->format($printTemplate->lft) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Rght') ?></th>
                <td><?= $this->Number->format($printTemplate->rght) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($printTemplate->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($printTemplate->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $printTemplate->active ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Show In Label Chooser') ?></th>
                <td><?= $printTemplate->show_in_label_chooser ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>

   <?php endif; ?>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($printTemplate->items)) : ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Code') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Quantity') ?></th>
                    <th scope="col"><?= __('Trade Unit') ?></th>
                    <th scope="col"><?= __('Pack Size Id') ?></th>
                    <th scope="col"><?= __('Product Type Id') ?></th>
                    <th scope="col"><?= __('Consumer Unit') ?></th>
                    <th scope="col"><?= __('Brand') ?></th>
                    <th scope="col"><?= __('Variant') ?></th>
                    <th scope="col"><?= __('Unit Net Contents') ?></th>
                    <th scope="col"><?= __('Unit Of Measure') ?></th>
                    <th scope="col"><?= __('Days Life') ?></th>
                    <th scope="col"><?= __('Min Days Life') ?></th>
                    <th scope="col"><?= __('Item Comment') ?></th>
                    <th scope="col"><?= __('Print Template Id') ?></th>
                    <th scope="col"><?= __('Carton Label Id') ?></th>
                    <th scope="col"><?= __('Pallet Label Copies') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($printTemplate->items as $items): ?>
                <tr>
                    <td><?= h($items->id) ?></td>
                    <td><?= $this->Html->activeIcon($items->active); ?></td>
                    <td><?= h($items->code) ?></td>
                    <td><?= h($items->description) ?></td>
                    <td><?= h($items->quantity) ?></td>
                    <td><?= h($items->trade_unit) ?></td>
                    <td><?= h($items->pack_size_id) ?></td>
                    <td><?= h($items->product_type_id) ?></td>
                    <td><?= h($items->consumer_unit) ?></td>
                    <td><?= h($items->brand) ?></td>
                    <td><?= h($items->variant) ?></td>
                    <td><?= h($items->unit_net_contents) ?></td>
                    <td><?= h($items->unit_of_measure) ?></td>
                    <td><?= h($items->days_life) ?></td>
                    <td><?= h($items->min_days_life) ?></td>
                    <td><?= h($items->item_comment) ?></td>
                    <td><?= h($items->pallet_template_id) ?></td>
                    <td><?= h($items->carton_template_id) ?></td>
                    <td><?= h($items->pallet_label_copies) ?></td>
                    <td><?= h($items->created) ?></td>
                    <td><?= h($items->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Print Templates') ?></h4>
        <?php if (!empty($printTemplate->child_print_templates)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Text Template') ?></th>
                    <th scope="col"><?= __('File Template') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Is File Template') ?></th>
                    <th scope="col"><?= __('Print Action') ?></th>
                    <th scope="col"><?= __('Print Controller') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Example Image') ?></th>
                    <th scope="col"><?= __('File Template Type') ?></th>
                    <th scope="col"><?= __('File Template Size') ?></th>
                    <th scope="col"><?= __('Example Image Size') ?></th>
                    <th scope="col"><?= __('Example Image Type') ?></th>
                    <th scope="col"><?= __('Show In Label Chooser') ?></th>
                    <th scope="col"><?= __('Parent Id') ?></th>
                    <th scope="col"><?= __('Lft') ?></th>
                    <th scope="col"><?= __('Rght') ?></th>
                    <th scope="col"><?= __('Replace Tokens') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($printTemplate->child_print_templates as $childPrintTemplates): ?>
                <tr>
                    <td><?= h($childPrintTemplates->id) ?></td>
                    <td><?= h($childPrintTemplates->name) ?></td>
                    <td><?= h($childPrintTemplates->description) ?></td>
                    <td><?= h($childPrintTemplates->text_template) ?></td>
                    <td><?= h($childPrintTemplates->file_template) ?></td>
                    <td><?= $this->Html->activeIcon($childPrintTemplates->active); ?></td>
                    <td><?= h($childPrintTemplates->is_file_template) ?></td>
                    <td><?= h($childPrintTemplates->controller_action) ?></td>
                    <td><?= h($childPrintTemplates->print_controller) ?></td>
                    <td><?= h($childPrintTemplates->created) ?></td>
                    <td><?= h($childPrintTemplates->modified) ?></td>
                    <td><?= h($childPrintTemplates->example_image) ?></td>
                    <td><?= h($childPrintTemplates->file_template_type) ?></td>
                    <td><?= h($childPrintTemplates->file_template_size) ?></td>
                    <td><?= h($childPrintTemplates->example_image_size) ?></td>
                    <td><?= h($childPrintTemplates->example_image_type) ?></td>
                    <td><?= h($childPrintTemplates->show_in_label_chooser) ?></td>
                    <td><?= h($childPrintTemplates->parent_id) ?></td>
                    <td><?= h($childPrintTemplates->lft) ?></td>
                    <td><?= h($childPrintTemplates->rght) ?></td>
                    <td><?= h($childPrintTemplates->replace_tokens) ?></td>
                    <td class="actions">
                        <?php
                echo $this->Form->create(null, [
                    'style' => 'width: 120px;',
                    'url' => [
                        'action' => 'move',
                        $printTemplate->id,
                    ],
                ]);
                                echo $this->Form->control('amount', [
                                    'label' => false,
                                    'prepend' => $this->Form->button(
                                        '',
                                        [
                                            'type' => 'submit',
                                            'name' => 'moveUp',
                                            'class' => 'move-up',
                                        ]
                                    ),
                                    'append' => $this->Form->button(
                                        '',
                                        [
                                            'type' => 'submit',
                                            'name' => 'moveDown',
                                            'class' => 'move-down',
                                        ]
                                    ),
                                ]);
                                echo $this->Form->end(); ?>
                        <?= $this->Html->link(__('View'), ['controller' => 'PrintTemplates', 'action' => 'view', $childPrintTemplates->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'PrintTemplates', 'action' => 'edit', $childPrintTemplates->id], ['class' => 'btn btn-secondary btn-sm mb-1']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'PrintTemplates', 'action' => 'delete', $childPrintTemplates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childPrintTemplates->id), 'class' => 'btn btn-danger btn-sm mb-1']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>