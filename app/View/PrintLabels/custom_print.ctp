<?php
    if (isset($formName)) {
        $this->validationErrors[$formName] = $this->validationErrors['PrintLabel'];
    }
?>
<div class="container">
    <h3>Custom Label Print</h3>
    <div class="row">
	<?php foreach ($custom_prints as $key_val => $cust_print): ?>
<?php $decodedData = $cust_print['Setting']['decoded']; ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="thumbnail">
                <?=$this->Html->image(
    $decodedData['image'],
    [
        'alt' => $decodedData['description']
    ]); ?>
              <div class="caption">
              <h5 class="text-uppercase"><?=$decodedData['description']; ?></h5>
                <?=$this->Form->create(
    $cust_print['Setting']['name'],
    [
        'url' => [
            'controller' => 'PrintLabels',
            'action' => 'customPrint'],
        'id' => 'CustomPrint' . $cust_print['Setting']['id']
    ]
); ?>
<?=$this->Form->input(
    'printer',
    [
        'options' => $printers,
        'default' => $default ? $default : ''
    ]
); ?>
                <?=$this->Form->hidden('id', ['value' => $cust_print['Setting']['id']]); ?>
                <?=$this->Form->input(
    'copies',
    [
        'label' => "Enter quantity to print"
    ]
); ?>
                <?=$this->Form->hidden('template', [
    'value' => $decodedData['template']]); ?>
                <?=$this->Form->hidden('code', [
    'value' => $decodedData['code']]); ?>
<?php if (isset($cust_print["Setting"]["decoded"]["csv"])): ?>
<?php foreach ($cust_print["Setting"]["decoded"]["csv"] as $key => $csv): ?>
                    <?=$this->Form->hidden(
    $cust_print['Setting']['name'] . '.csv.' . $key, ['value' => $csv]); ?>
<?php endforeach; ?>
<?php endif; ?>

                <?=$this->Form->end([
    'label' => "Print",
    'bootstrap-type' => 'primary'
]); ?>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
