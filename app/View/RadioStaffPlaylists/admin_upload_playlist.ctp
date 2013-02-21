Order:
<ul>
	<li>Artist</li>
	<li>Song</li>
	<li>Album</li>
	<li>Label</li>
	<li>Genre</li>
	<li>Spins</li>
</ul>
<?=$this->Form->create('RadioStaffPlaylist', array('enctype' => 'multipart/form-data','admin'=>'1')); ?>
<?=$this->Form->input('file',array('label'=>'Playlist File','type' => 'file')); ?>
<?=$this->Form->hidden('radio_staff_member_id', array('value' => $staff_id)); ?>
<?=$this->Form->end(__('Upload File'));?>