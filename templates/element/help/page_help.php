<?= $this->Html->link(
    'Instructions ' . $this->Html->icon('question-circle', ['iconSet' => 'far']),
    [
        'controller' => 'Help',
        'action' => 'view_page_help',
        $helpPage['id'],
    ],
    [
        'class' => 'nav-link',
        'escape' => false,
        'title' => 'Click here for page specific help',
    ]
);