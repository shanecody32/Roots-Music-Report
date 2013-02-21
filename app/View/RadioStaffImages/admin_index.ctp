<div class="radioStationImages index">
	<h2><?php echo __('Radio Station Images');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('radio_station_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('size');?></th>
			<th><?php echo $this->Paginator->sort('extention');?></th>
			<th><?php echo $this->Paginator->sort('width');?></th>
			<th><?php echo $this->Paginator->sort('height');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($radioStationImages as $radioStationImage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $radioStationImage['RadioStationImage']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($radioStationImage['RadioStation']['name'], array('controller' => 'radio_stations', 'action' => 'view', $radioStationImage['RadioStation']['id'])); ?>
		</td>
		<td><?php echo $radioStationImage['RadioStationImage']['name']; ?>&nbsp;</td>
		<td><?php echo $radioStationImage['RadioStationImage']['type']; ?>&nbsp;</td>
		<td><?php echo $radioStationImage['RadioStationImage']['size']; ?>&nbsp;</td>
		<td><?php echo $radioStationImage['RadioStationImage']['extention']; ?>&nbsp;</td>
		<td><?php echo $radioStationImage['RadioStationImage']['width']; ?>&nbsp;</td>
		<td><?php echo $radioStationImage['RadioStationImage']['height']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $radioStationImage['RadioStationImage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $radioStationImage['RadioStationImage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $radioStationImage['RadioStationImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $radioStationImage['RadioStationImage']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Radio Station Image'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Radio Stations'), array('controller' => 'radio_stations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station'), array('controller' => 'radio_stations', 'action' => 'add')); ?> </li>
	</ul>
</div>