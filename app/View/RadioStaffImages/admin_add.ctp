<?=$this->Form->create('RadioStaffImage', array('action' => 'admin_add_step_2', "enctype" => "multipart/form-data")); ?>
<?=$this->Form->input('image',array("type" => "file")); ?>
<?=$this->Form->hidden('staff_id', array('value'=>$staff_id)); ?>
<?=$this->Form->end('Upload'); ?>