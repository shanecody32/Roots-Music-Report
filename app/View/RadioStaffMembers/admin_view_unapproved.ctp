<div class="radioStations index">
	<h2><?=__('All Reporting Radio Members');?></h2>
		<table>
			<tr>
				<th style="border:none;"><?=$this->Paginator->sort('approved');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('verified');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('violations');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('automatic');?></th>
			</tr>
		</table>
		
		
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th></th>
			<th><?=$this->Paginator->sort('user_id');?></th>
			<th><?=$this->Paginator->sort('first_name');?></th>
			<th><?=$this->Paginator->sort('last_name');?></th>
			<th><?=$this->Paginator->sort('RadioStation.name','Radio Name');?></th>
			<th><?=$this->Paginator->sort('position');?></th>
			<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?
	$i = 0;
	foreach ($staff as $member):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}

		/*if(!empty($album['Album']['violations'])){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		} */

		if(!$member['RadioStaffMember']['verified']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = ' class="yellow"';
			else
				$class = ' class="altyellow"';
		}
		
		if(!$member['RadioStaffMember']['verified'] && $member['RadioStaffMember']['approved']){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		}
		
		if($member['RadioStaffMember']['verified'] && !$member['RadioStaffMember']['approved']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = ' class="green"';
			else
				$class = ' class="altgreen"';
		}

	?>
	<tr<?=$class;?>>
		<td><? if($member['RadioStaffMember']['automatic']) echo "&infin;"; ?></td>
		<td><? // echo $this->Html->link($member['User']['username'], array('controller' => 'users', 'action' => 'view', $member['User']['id'])); ?></td>
		<td><?=$member['RadioStaffMember']['first_name']; ?>&nbsp;</td>
		<td><?=$member['RadioStaffMember']['last_name']; ?>&nbsp;</td>
		<td><?=$member['RadioStation']['name']; ?>&nbsp;</td>
		<td><?=$member['RadioStaffMember']['position']; ?>&nbsp;</td>
		<td class="actions">
			<?=$this->Html->link(__('Verify'), array('action' => 'admin_verify', $member['RadioStaffMember']['id'])); ?>
			<?=$this->Html->link(__('View'), array('action' => 'admin_view', $member['RadioStaffMember']['id'])); ?>
			<?=$this->Html->link(__('Playlist'), array('controller'=>'radio_staff_playlists','action' => 'admin_view', $member['RadioStaffMember']['id'])); ?>
			<?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $member['RadioStaffMember']['id'])); ?>
			<?=$this->Html->link(__('Delete'), array('action' => 'admin_delete', $member['RadioStaffMember']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $member['RadioStaffMember']['id'])); ?>
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
		<?=$this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?> | <?=$this->Paginator->numbers();?> | <?=$this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
