<? // pr($bands); ?>
<div class="users index">
	<h2><?php echo __('Users');?></h2>
	<p class="smaller"><?=$this->Html->link('Create User', array('controller'=>'users', 'action'=>'admin_add')); ?></span>


	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('User.username', 'Username');?></th>
			<th><?php echo $this->Paginator->sort('UserDetail.first_name', 'First Name');?></th>
			<th><?php echo $this->Paginator->sort('UserDetail.last_name', 'Last Name');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}

	?>
	<tr<?php echo $class;?>>
		<td><?php echo $user['User']['username']; ?>&nbsp;</td>
		<td><?php echo $user['UserDetail']['first_name']; ?>&nbsp;</td>
		<td><?php echo $user['UserDetail']['last_name']; ?>&nbsp;</td>
		<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'admin_view', $user['User']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'admin_edit', $user['User']['id'])); ?>
					<?=$this->Html->link('Change Password', array('action'=>'admin_change_user_password', $user['User']['id'])); ?>
					<?php echo $this->Html->link(__('Delete'), array('action' => 'admin_delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $user['User']['id'])); ?>
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
