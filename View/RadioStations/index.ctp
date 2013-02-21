<div class="radioStations index">
	<h2><?php echo __('Radio Stations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('info');?></th>
			<th><?php echo $this->Paginator->sort('approved');?></th>
			<th><?php echo $this->Paginator->sort('verified');?></th>
			<th><?php echo $this->Paginator->sort('violations');?></th>
			<th><?php echo $this->Paginator->sort('automatic');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($radioStations as $radioStation):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $radioStation['RadioStation']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($radioStation['User']['username'], array('controller' => 'users', 'action' => 'view', $radioStation['User']['id'])); ?>
		</td>
		<td><?php echo $radioStation['RadioStation']['name']; ?>&nbsp;</td>
		<td><?php echo $radioStation['RadioStation']['type']; ?>&nbsp;</td>
		<td><?php echo $radioStation['RadioStation']['info']; ?>&nbsp;</td>
		<td><?php echo $radioStation['RadioStation']['approved']; ?>&nbsp;</td>
		<td><?php echo $radioStation['RadioStation']['verified']; ?>&nbsp;</td>
		<td><?php echo $radioStation['RadioStation']['violations']; ?>&nbsp;</td>
		<td><?php echo $radioStation['RadioStation']['automatic']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $radioStation['RadioStation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $radioStation['RadioStation']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $radioStation['RadioStation']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $radioStation['RadioStation']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Radio Station'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Emails'), array('controller' => 'radio_emails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Email'), array('controller' => 'radio_emails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Links'), array('controller' => 'radio_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Link'), array('controller' => 'radio_links', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Phone Numbers'), array('controller' => 'radio_phone_numbers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Phone Number'), array('controller' => 'radio_phone_numbers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Staff Members'), array('controller' => 'radio_staff_members', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Staff Member'), array('controller' => 'radio_staff_members', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Station Images'), array('controller' => 'radio_station_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station Image'), array('controller' => 'radio_station_images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Station Playlists'), array('controller' => 'radio_station_playlists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station Playlist'), array('controller' => 'radio_station_playlists', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Station Raw Datas'), array('controller' => 'radio_station_raw_datas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station Raw Data'), array('controller' => 'radio_station_raw_datas', 'action' => 'add')); ?> </li>
	</ul>
</div>