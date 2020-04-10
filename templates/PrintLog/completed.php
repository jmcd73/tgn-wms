<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<?php

echo $this->Html->css([
    '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/styles/default.min.css',
    'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/styles/github-gist.min.css',
], [
    'block' => 'css',
]);
$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js', [
    'block' => 'from_view',
]);

echo $this->Html->scriptBlock('hljs.initHighlightingOnLoad();', ['block' => 'from_view']);
?>

<div class="container">
    <!--  <dl class="dl-horizontal">
        <dt>Print Type</dt>
        <dd> <?= $completed['PrintLabel']['print_action']; ?></dd>
        <dt>Print Data</dt>
        <dd>
            <pre
                style="display: block;
    padding: 9.5px;
    margin: 0 0 10px;
    font-size: 13px;
    line-height: 1.42857143;
    color: #333;
    word-break: break-all;
    word-wrap: break-word;
    background-color: white;
    border: 0;
    border-radius: 4px;"><code class="json"><?= json_encode(json_decode($completed['PrintLabel']['print_data']), JSON_PRETTY_PRINT); ?></code></pre>
        </dd>
    </dl> -->

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-3 col-md-4 col-sm-12 text-center">
            <?= $this->Html->link('Back to ' . $completed['print_action'], [
                'action' => $completed['print_action'],
            ], [
                'class' => 'btn btn-link',
            ]); ?>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 text-center">
            <?= $this->Html->link('Print another type of label', [
                'action' => 'labelChooser',
            ], [
                'class' => 'btn btn-link',
            ]); ?>
        </div>
    </div>
</div>