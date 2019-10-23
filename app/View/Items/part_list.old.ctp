<?php $xml = new SimpleXMLElement('<productList/>'); ?>
<?php foreach ($items as $item): ?>
<?php $itemNode = $xml->addChild('item');?>
<?php $itemNode->addAttribute('madeBy', 'Toggen'); ?>
<?php $itemNode->addChild('code', $item['Item']['code']);?>
<?php $itemNode->addChild('desc', h(strtoupper($item['Item']['description'])));?>
<?php $itemNode->addChild('plQty', $item['Item']['quantity']);?>
<?php $itemNode->addChild('active', 'yes');?>
<?php $itemNode->addChild('gtinEa', $item['Item']['trade_unit']);?>
<?php $itemNode->addChild('gtinCu', $item['Item']['consumer_unit']);?>
<?php endforeach;?>
<?php echo $xml->asXML(); ?>
