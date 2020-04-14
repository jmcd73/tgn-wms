<div class="context-help">
    <?= $this->Html->link(
    'Context help ' . $this->Html->icon('question-circle', ['iconSet' => 'far']),
    [
        'controller' => 'Help',
        'action' => 'view_page_help',
        $helpPage['id'],
    ],
    [
        'class' => 'context-help',
        'escape' => false,
        'title' => 'Click here for page specific help',
    ]
); ?>
</div>