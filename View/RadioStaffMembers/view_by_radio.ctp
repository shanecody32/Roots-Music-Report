<div class="radioStations index">
	<h2><?php echo __('Staff for '.$staff[0]['RadioStation']['name']);?></h2>		
		
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
			<th><?php echo $this->Paginator->sort('position');?></th>
			<th class="actions"></th>
	</tr>
	<?php foreach ($staff as $member): ?>
	<tr>
		<td><?php echo $member['RadioStaffMember']['first_name']; ?>&nbsp;</td>
		<td><?php echo $member['RadioStaffMember']['last_name']; ?>&nbsp;</td>
		<td><?php echo $member['RadioStaffMember']['position']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View Profile'), array('action' => 'view', $member['RadioStaffMember']['id'])); ?>
			<?php echo $this->Html->link(__('Playlist'), array('controller'=>'radio_staff_playlist_archives','action' => 'view', $member['RadioStaffMember']['id'])); ?>
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
