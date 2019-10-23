<div class="container">
<h3><?= __('Item'); ?></h3>
	<dl class="dl-horizontal">

		<dt><?= __('Active'); ?></dt>
		<dd>
			<?php $icon = $item['Item']['active'] ? "ok" : "remove";
                echo $this->Html->tag('i','',[ 'aria-hidden' => 'true',  'class' => 'glyphicon glyphicon-' . $icon ]);
                ?>

		</dd>
		<dt><?= __('Product Type'); ?></dt>
		<dd>
		<?= h($item['ProductType']['name']); ?>
		</dd>
		<dt><?= __('Code'); ?></dt>
		<dd>
			<?= $this->Html->link(h($item['Item']['code']), ['action' => 'edit', $item['Item']['id']], ['title' => "Edit"]); ?>

		</dd>
		<dt><?= __('Description'); ?></dt>
		<dd>
			<?= h($item['Item']['description']); ?>

		</dd>
		<dt><?= __('Quantity'); ?></dt>
		<dd>
			<?= h($item['Item']['quantity']); ?>

		</dd>
		<dt><?= __('Trade Unit'); ?></dt>
		<dd>
			<?= h($item['Item']['trade_unit']); ?>

		</dd>
		<dt><?= __('Consumer Unit'); ?></dt>
		<dd>
			<?= h($item['Item']['consumer_unit']); ?>

		</dd>
		<dt><?= __('Brand'); ?></dt>
		<dd>
			<?= h($item['Item']['brand']); ?>

		</dd>
		<dt><?= __('Variant'); ?></dt>
		<dd>
			<?= h($item['Item']['variant']); ?>

		</dd>
		<dt><?= __('Unit Net Contents'); ?></dt>
		<dd>
			<?= h($item['Item']['unit_net_contents']); ?>

		</dd>
		<dt><?= __('Unit Of Measure'); ?></dt>
		<dd>
			<?= h($item['Item']['unit_of_measure']); ?>

		</dd>
		<dt><?= __('Days Life'); ?></dt>
		<dd>
			<?= h($item['Item']['days_life']); ?>

		</dd>
                <dt><?= __('Min Days Life'); ?></dt>
		<dd>
			<?= h($item['Item']['min_days_life']); ?>

		</dd>
                <dt><?= __('Item comment'); ?></dt>
		<dd>
			<?= h($item['Item']['item_comment']); ?>

		</dd>

		<dt><?= __('Pallet Label Template'); ?></dt>
		<dd>
			<?= h($item['PrintTemplate']['name']); ?>

		</dd>
		<dt><?= __('Carton Label Template'); ?></dt>
		<dd>
			<?= h($item['CartonLabel']['name']); ?>

		</dd>
	</dl>
</div>
