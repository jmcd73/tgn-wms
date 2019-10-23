     <div class="jmits">
        <?php
        echo $this->Form->create("machinesStandardRates", [
            'type' => 'get',
            'class' => 'jmits',
            'url' => [
              
                'action' => 'bulk_add'
                ]
            ]
        );
        ?>
<p>Machine standard rates are in items per hour</p>
        <fieldset class="jmits">
            <legend>Select a machine</legend>
            
        <?= $this->Form->input("machine_choice", ['options' => $machines_all, 'empty' => '(select a machine)']); ?>
        </fieldset>
        <?= $this->Form->end(['label' => "Edit machine run rates", 'div' => ['class' => 'submit jmits']]); ?>
            
           </div>
 

<?php
$this->Html->css('std_rates/std_rates', ['inline' => false]);
?>
<?php foreach ($machines as $key => $machine): ?>

    <?= $this->Form->create('MachinesStandardRate'); ?>
    <fieldset>
    <legend>Edit standard rates for: <?= $this->Html->tag('span', $machine, ['id' => 'machine-name']) ; ?></legend>
    <?php $i = 0; ?>
    <div class="jmits-col">
        <?php foreach ($packSizes as $ps_key => $packSize): ?>
            <?= $this->Form->hidden('MachinesStandardRate.' . $i . '.pack_size_id' , ['value' => $ps_key]); ?>
            <?= $this->Form->input('MachinesStandardRate.' . $i . '.standard_rate' , ['required' => false, 'label' => $packSize, 'class' => 'jmits']); ?>
            <?= $this->Form->hidden('MachinesStandardRate.' . $i++ . '.machine_id', ['value' => $key]); ?>
        <?php endforeach; ?>
    </div>
    </fieldset>
<?= $this->Form->end('Submit') ?>
<?php endforeach; ?>
<?php //debug($machines);
//debug($packSizes);

?>