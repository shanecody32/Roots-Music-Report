<div class="radioStationImages form">
<?php echo $this->Form->create('RadioStationImage');?>
	<fieldset>
 		<legend><?php echo __('Edit Radio Station Image'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('radio_station_id');
		echo $this->Form->input('name');
		echo $this->Form->input('type');
		echo $this->Form->input('size');
		echo $this->Form->input('extention');
		echo $this->Form->input('width');
		echo $this->Form->input('height');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('RadioStationImage.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('RadioStationImage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Radio Station Images'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Radio Stations'), array('controller' => 'radio_stations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Radio Station'), array('controller' => 'radio_stations', 'action' => 'add')); ?> </li>
	</ul>
</div>