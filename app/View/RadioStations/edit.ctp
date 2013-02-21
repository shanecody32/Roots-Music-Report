<div class="radioStations form">
<?php echo $this->Form->create('RadioStation');?>
	<fieldset>
 		<legend><?php echo __('Edit Radio Station'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('type');
		echo $this->Form->input('info');
		echo $this->Form->input('approved');
		echo $this->Form->input('verified');
		echo $this->Form->input('violations');
		echo $this->Form->input('automatic');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('RadioStation.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('RadioStation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Radio Stations'), array('action' => 'index'));?></li>
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