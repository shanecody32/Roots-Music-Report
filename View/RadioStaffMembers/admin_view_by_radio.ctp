<div class="radioStations index">
	<h2><?php echo __('Staff for '.$staff[0]['RadioStation']['name']);?></h2>
		<table>
			<tr>
				<th style="border:none;"><?php echo $this->Paginator->sort('approved');?></th>
				<th style="border:none;"><?php echo $this->Paginator->sort('verified');?></th>
				<th style="border:none;"><?php echo $this->Paginator->sort('violations');?></th>
				<th style="border:none;"><?php echo $this->Paginator->sort('automatic');?></th>
			</tr>
		</table>
		
		
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
			<th><?php echo $this->Paginator->sort('position');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($staff as $member):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}

		if(!empty($member['RadioStaffMember']['violations'])){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		}

		if(empty($member['RadioStaffMember']['violations']) && !$member['RadioStaffMember']['verified']){
			if(!$altrow)
				$class = ' class="yellow"';
			else
				$class = ' class="altyellow"';
		}

	?>
	<tr<?php echo $class;?>>
		<td><? if($member['RadioStaffMember']['automatic']) echo "&infin;"; ?></td>
		<td><?php // echo $this->Html->link($member['User']['username'], array('controller' => 'users', 'action' => 'view', $member['User']['id'])); ?></td>
		<td><?php echo $member['RadioStaffMember']['first_name']; ?>&nbsp;</td>
		<td><?php echo $member['RadioStaffMember']['last_name']; ?>&nbsp;</td>
		<td><?php echo $member['RadioStaffMember']['position']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'admin_view', $member['RadioStaffMember']['id'])); ?>
			<?php echo $this->Html->link(__('Playlist'), array('controller'=>'radio_staff_playlists','action' => 'admin_view', $member['RadioStaffMember']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $member['RadioStaffMember']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $member['RadioStaffMember']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $member['RadioStaffMember']['id'])); ?>
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
