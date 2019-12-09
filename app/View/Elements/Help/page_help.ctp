
<?php echo $this->Html->link(
    '<i class="glyphicon glyphicon-question-sign"></i>',
    [
        'controller' => 'Help',
        'action' => 'viewPageHelp',
        $helpPage['Help']['id']
    ],
    [
        'class' => 'page-help-icon',
        'escape' => false,
        'title' => "Click here for page specific help"
    ]
); ?>