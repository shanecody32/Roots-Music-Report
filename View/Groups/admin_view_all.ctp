<? // pr($bands); ?>
<div class="groups index">
	<h2><?php echo __('Groups');?></h2>
	<p class="smaller"><?=$this->Html->link('Create Group', array('controller'=>'groups', 'action'=>'admin_add')); ?></span>


	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Group.name', 'name');?></th>
			<th><?php echo $this->Paginator->sort('GroupDetail.first_name', 'First Name');?></th>
			<th><?php echo $this->Paginator->sort('GroupDetail.last_name', 'Last Name');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($groups as $group):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}

	?>
	<tr<?php echo $class;?>>
		<td><?php echo $group['Group']['name']; ?>&nbsp;</td>
		<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'admin_view', $group['Group']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'admin_edit', $group['Group']['id'])); ?>
					<?=$this->Html->link('Change Password', array('action'=>'admin_change_group_password', $group['Group']['id'])); ?>
					<?php echo $this->Html->link(__('Delete'), array('action' => 'admin_delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $group['Group']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
		</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
