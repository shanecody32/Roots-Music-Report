
<?=$this->Form->create('RadioStaffPlaylist', array('enctype' => 'multipart/form-data','admin'=>'1')); ?>
<?=$this->Form->input('file',array('label'=>'Playlist File','type' => 'file')); ?>
<?=$this->Form->hidden('radio_staff_member_id', array('value' => $staff_id)); ?>
<?=$this->Form->end(__('Upload File'));?>