<div class="container">
<h3><?=__('Menu');?></h3>
	<dl class="dl-horizontal">

                <dt><?=__('Active');?></dt>
		<dd>
			<?=h($menu['Menu']['active']);?>

		</dd>
		<dt><?=__('Name');?></dt>
		<dd>
			<?=$this->Html->link($menu['Menu']['name'], [
    'controller' => 'menus',
    'action' => 'edit',
    $menu['Menu']['id']

],
    ['title' => 'Click here to edit this menu']
);?>

		</dd>
		<dt><?=__('Url');?></dt>
		<dd>
			<?=h($menu['Menu']['url']);?>

		</dd>
		<dt><?=__('Options');?></dt>
		<dd>
			<?=h($menu['Menu']['options']);?>

		</dd>
		<dt><?=__('Parent Menu');?></dt>
		<dd>
			<?=$this->Html->link($menu['ParentMenu']['name'], ['controller' => 'menus', 'action' => 'view', $menu['ParentMenu']['id']]);?>

		</dd>
		<dt><?=__('Lft');?></dt>
		<dd>
			<?=h($menu['Menu']['lft']);?>

		</dd>
		<dt><?=__('Rght');?></dt>
		<dd>
			<?=h($menu['Menu']['rght']);?>

		</dd>
		<dt><?=__('Modified');?></dt>
		<dd>
			<?=h($menu['Menu']['modified']);?>

		</dd>
		<dt><?=__('Created');?></dt>
		<dd>
			<?=h($menu['Menu']['created']);?>

		</dd>
	</dl>


<div class="row">
	<h3><?=__('Related Menus');?></h3>
	<?php if (!empty($menu['ChildMenu'])): ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<tr>
		<th><?=__('Id');?></th>

                <th><?=__('Active');?></th>
               <th><?=__('Name');?></th>
		<th><?=__('Url');?></th>
		<th><?=__('Options');?></th>
		<th><?=__('Parent Id');?></th>
		<th><?=__('Lft');?></th>
		<th><?=__('Rght');?></th>
		<th><?=__('Modified');?></th>
		<th><?=__('Created');?></th>
		<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?php foreach ($menu['ChildMenu'] as $childMenu): ?>
		<tr>
			<td><?=$childMenu['id'];?></td>
                        <td><?=$childMenu['active'];?></td>
			<td><?=$childMenu['name'];?></td>
			<td><?=$childMenu['url'];?></td>
			<td><?=$childMenu['options'];?></td>
			<td><?=$childMenu['parent_id'];?></td>
			<td><?=$childMenu['lft'];?></td>
			<td><?=$childMenu['rght'];?></td>
			<td><?=$childMenu['modified'];?></td>
			<td><?=$childMenu['created'];?></td>
			<td class="actions">

                <?=$this->Form->postLink( '<i class="fas fa-caret-down"></i> ' . __('Move down'), ['action' => 'move_down', $childMenu['id']], [
					'class' => 'btn btn-sm',
					'escape' => false,
					'confirm' => __('Are you sure you want to move down # %s??', $menu['Menu']['id'])])?>
                <?=$this->Form->postLink('<i class="fas fa-caret-up"></i> ' . __('Move up'), ['action' => 'move_up', $childMenu['id']], [
					'class' => 'btn btn-sm',
					'escape' => false,
					'confirm' => __('Are you sure you want to move up # %s?', $menu['Menu']['id'])])?>
				<?=$this->Html->link(
					'<i class="fas fa-eye"></i> ' . __('View'), ['controller' => 'menus', 'action' => 'view', $childMenu['id']],
			[
				'class' => 'btn btn-sm',
				'escape' => false,
			]
			);?>
				<?=$this->Html->link(
					$this->Html->tag(
						'i', '', [
						'class' => "fas fa-edit" ] ) . __(' Edit'),
						['controller' => 'menus', 'action' => 'edit', $childMenu['id']], [
						'class' => 'btn btn-sm',
						'escape' => false
				]);?>
				<?=$this->Form->postLink(
					$this->Html->tag('i', '', [
						'class' => "fas fa-trash-alt" ]) . __(' Delete'),
						[
							'controller' => 'menus',
							'action' => 'delete',
							$childMenu['id'],
							'?' => [
								'redirect' => urlencode($this->here)
							]
						], [
					'class' => 'btn btn-sm',
					'escape' => false
				], __('Are you sure you want to delete # %s?', $childMenu['id']));?>

			</td>
		</tr>
	<?php endforeach;?>
	</table>
<?php endif;?>


</div>
</div>
