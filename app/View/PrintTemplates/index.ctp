<div class="printTemplates index container">
    <h2><?php echo __('Print Templates'); ?></h2>
    <?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn btn-xs add btn-primary mb2']);?>
    <p><strong>Warning:</strong> Do not change these settings unless you know what you are doing</p>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('description'); ?></th>
                <th><?php echo $this->Paginator->sort('active'); ?></th>
                <th><?php echo $this->Paginator->sort('show_in_label_chooser'); ?></th>
                <th><?php echo $this->Paginator->sort('controller_action', 'Controller / Action'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($printTemplates as $key => $printTemplate): ?>
            <?php $icon = $this->Html->printTemplateType($printTemplate); ?>
            <tr>
                <?php $boldClass = empty($printTemplate['ParentTemplate']['id']) ? sprintf('class="%s" ', 'font-bold') : ''; ?>
                <td <?= $boldClass; ?>>
                    <?php if ($icon): ?>

                    <?php $iconHtml = '<span class="' . $icon . '">' . $this->Html->icon($icon, ['font' => 'fa']) . '</span>' ?>

                    <?php endif; ?>
                    <?php $prefix = !empty($printTemplate['ParentTemplate']['id']) ? $iconHtml . ' ' : ''; ?>
                    <?php echo $prefix . h($printTemplate['PrintTemplate']['name']); ?>
                </td>
                <td <?= $boldClass; ?>><?php echo h($printTemplate['PrintTemplate']['description']); ?></td>
                <td <?= $boldClass; ?>><?php echo h($printTemplate['PrintTemplate']['active']); ?></td>
                <td <?= $boldClass; ?>><?php echo h($printTemplate['PrintTemplate']['show_in_label_chooser']); ?></td>
                <td <?= $boldClass; ?>>
                    <?php echo h($printTemplate['PrintTemplate']['controller_action']); ?>
                </td>
                <td class="actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <?=$this->Html->link(__('View'), ['action' => 'view', $printTemplate['PrintTemplate']['id']], [
                                'class' => 'btn view btn-link btn-sm btn-sm',
                            ]); ?>
                            <?=$this->Html->link(__('Edit'), ['action' => 'edit', $printTemplate['PrintTemplate']['id']], [
                                'class' => 'btn edit btn-link btn-sm',
                            ]); ?>
                            <?=$this->Form->postLink(
                                __('Delete'),
                                [
                                    'action' => 'delete',
                                    $printTemplate['PrintTemplate']['id'],
                                    '?' => [
                                        'redirect' => urlencode($this->request->here),
                                    ],
                                ],
                                [
                                    'class' => 'btn delete btn-link btn-sm',
                                    'confirm' => __('Are you sure you want to remove # %s?. Children will no be deleted', $printTemplate['PrintTemplate']['id']),
                                ]
                            ); ?>
                        </div>
                    </div>

                    <div class="row mb1">
                        <div class="col-lg-12">
                            <?php
                                echo $this->Form->create(null, [
                                    'url' => [
                                        'action' => 'move',
                                        $printTemplate['PrintTemplate']['id'],
                                    ],
                                    'id' => 'PrintTemplateMoveForm' . $key,
                                    'class' => 'input-sm up-down-control',
                                ]);
                                echo $this->Form->input('amount', [
                                    'input-group-size' => 'input-group-sm',
                                    'label' => false,
                                    'class' => 'move',
                                    'id' => 'PrintTemplateAmount' . $key,
                                    'placeholder' => 'move up/down',
                                    'prepend' => $this->Form->button(
                                        '<i class="fas fa-caret-up"></i>',
                                        [
                                            'type' => 'submit',
                                            'name' => 'data[PrintTemplate][moveUp]',
                                            'class' => 'move-up',
                                        ]
                                    ),
                                    'append' => $this->Form->button(
                                        '<i class="fas fa-caret-down"></i>',
                                        [
                                            'type' => 'submit',
                                            'name' => 'data[PrintTemplate][moveDown]',
                                            'class' => 'move-down',
                                        ]
                                    ),
                                ]);
                                echo $this->Form->end();
                            ?>

                        </div>

                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter([
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'),
        ]);
    ?> </p>
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
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Print Template'), ['action' => 'add']); ?></li>
        <li><?php echo $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
        <li><?php echo $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
    </ul>
</div>