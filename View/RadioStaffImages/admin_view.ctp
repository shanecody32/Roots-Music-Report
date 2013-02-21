<div class="radioStationImages view">
<h2><?php echo __('Radio Station Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Radio Station'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($radioStationImage['RadioStation']['name'], array('controller' => 'radio_stations', 'action' => 'view', $radioStationImage['RadioStation']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['size']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Extention'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['extention']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Width'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['width']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Height'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $radioStationImage['RadioStationImage']['height']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Radio Station Image'), array('action' => 'edit', $radioStationImage['RadioStationImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Radio Station Image'), array('action' => 'delete', $radioStationImage['RadioStationImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $radioStationImage['RadioStationImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Station Images'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station Image'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Radio Stations'), array('controller' => 'radio_stations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station'), array('controller' => 'radio_stations', 'action' => 'add')); ?> </li>
	</ul>
</div>
