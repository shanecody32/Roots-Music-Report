<?=$this->Form->create('RadioStationImage', array('action' => 'admin_add_step_2', "enctype" => "multipart/form-data")); ?>
<?=$this->Form->input('image',array("type" => "file")); ?>
<?=$this->Form->hidden('radio_id', array('value'=>$radio_id)); ?>
<?=$this->Form->end('Upload'); ?>