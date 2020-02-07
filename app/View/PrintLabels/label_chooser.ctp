<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Label Chooser</h1>
            <h5>Click on a image to select a label to print</h5>
        </div>
    </div>
    <?php foreach ($printTemplatesThreaded as $printTemplate): ?>
    <?php if (!($printTemplate['PrintTemplate']['active'] && $printTemplate['PrintTemplate']['show_in_label_chooser'])) {
    continue;
} ?>
    <div class="row">
        <hr>
        <h3><?= $printTemplate['PrintTemplate']['name'] ; ?></h3>
        <p><?=  $printTemplate['PrintTemplate']['description'] ; ?></p>

        <?php foreach ($printTemplate['children'] as $ptc): ?>

        <?php if (!($ptc['PrintTemplate']['active'] && $ptc['PrintTemplate']['show_in_label_chooser'])) {
    continue;
} ?>

        <div class="col-sm-6 col-md-3 col-lg-3">
            <div class="thumbnail">
                <?=$this->Html->link(
    $this->Html->image(DS . $glabelsRoot . DS . $ptc['PrintTemplate']['example_image']),
    [
        'controller' => $ptc['PrintTemplate']['print_controller'],
        'action' => $ptc['PrintTemplate']['print_action'],
    ],
    [
        'escape' => false,
    ]
);?>
                <div class="caption">
                    <h3><?=h($ptc['PrintTemplate']['name']);?></h3>
                    <p><?=h($ptc['PrintTemplate']['description']);?></p>
                </div>
            </div>
        </div>


        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>