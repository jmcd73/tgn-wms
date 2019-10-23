<?php $this->assign('title', $shipment['Shipment']['shipper']) ?>
<?php  $this->Html->css('shipments/viewplain',['inline' => false]); ?>
<ul class="viewplain-screen">
    <li><?php
        echo $this->Html->link('View Shippers', [
            'action' => 'index'], [
                
                'title' => "Go back and View Shippers"]);
        ?></li>
    <li><?php
        echo $this->Html->link('Print This', "javascript:void(0);", [
            'onClick' => "window.print()",
            'title' => "Click this link to print this shipper"]);
        ?></li>       

</ul>
<pre>
===============================================================
 * <?= str_pad(__('Shipment No') . ': ' . h($shipment['Shipment']['shipper']), 33, ' ', STR_PAD_RIGHT) ; ?>
 Operator: <?= str_pad(h($shipment['Operator']['full_name']), 0, ' ', STR_PAD_LEFT) . "\n"; ?>
 * <?= str_pad(__('Destination') . ': ' . h($shipment['Shipment']['destination']), 33, ' ', STR_PAD_RIGHT)  ; ?>
     Rego: <?= str_pad(h($shipment['TruckRegistration']['rego_number']), 0, ' ', STR_PAD_LEFT) . "\n"; ?>
 * <?= str_pad(__('Created') . ': ' . $this->Time->format('d/m/Y h:iA', $shipment['Shipment']['created']),  30, ' ', STR_PAD_RIGHT); ?>
    Con note: <?= str_pad(h($shipment['Shipment']['con_note']), 0, ' ', STR_PAD_LEFT) . "\n"; ?>
===============================================================
 * Timing
   <?php foreach(['start', 'finish'] as $time){
      
      echo str_pad (Inflector::humanize($time) . ': '. $this->Time->format('d/m/y h:iA', $shipment['Shipment'][ 'time_' .$time]), 25, ' ', STR_PAD_RIGHT);
     
 } ?>
<?= str_pad (Inflector::humanize('Total') . ': '. h($shipment['Shipment'][ 'time_total']), 20, ' ', STR_PAD_RIGHT) . "\n"; ?>
 * Temps
   <?php foreach(['product', 'truck', 'dock'] as $temp){
      echo  str_pad(Inflector::humanize( $temp ) . ': '. $shipment['Shipment'][$temp . '_temp'], 25, ' ', STR_PAD_RIGHT);
     
 } ?>

<?php if (!empty($pallets)): ?>
===============================================================
         Total Pallets: <?= $pl_count . "\n"?>
===============================================================
  Item Code                                             Total
  Description   Location   Reference    Qty   Pallets   Qty
  -----------   --------   ---------    ---   -------   -----
<?php foreach ($groups as $group): ?>
<?php //string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] ) ?>
<?= '  ' . $group['Item']['code'] . "\n"; ?>
<?= '  ' . str_pad($group['Item']['description'], 30, ' ', STR_PAD_RIGHT); ?>
<?= str_repeat(' ', 9) . str_pad($group['0']['Pallets'], 12, ' ', STR_PAD_LEFT) . str_repeat(' ', 3) . str_pad($group['0']['Total'], 5, ' ' , STR_PAD_LEFT) . "\n"; ?>
<?php foreach ($pallets as $pallet): ?>
<?php if($pallet['Label']['item_id'] == $group['Label']['item_id']):
echo str_pad($pallet['Location']['location'], 24, ' ', STR_PAD_LEFT) . '    ' . $pallet['Label']['pl_ref'] . '     ' .$pallet['Label']['qty'] ."\n"; 
endif; ?>
<?php endforeach; ?>
---------------------------------------------------------------
<?php endforeach; ?>
<?php endif; ?>
</pre>

<ul class="viewplain-screen">
    <li><?php
        echo $this->Html->link('View Shippers', [
            'action' => 'index'], [
                
                'title' => "Go back and View Shippers"]);
        ?></li>
    <li><?php
        echo $this->Html->link('Print This', "javascript:void(0);", [
            'onClick' => "window.print()",
            'title' => "Click this link to print this shipper"]);
        ?></li>       

</ul>


