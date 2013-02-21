<?=$this->Form->create('BandImage', array('action' => 'admin_add_step_2', "enctype" => "multipart/form-data")); ?>
<?=$this->Form->input('image',array("type" => "file")); ?>
<?=$this->Form->hidden('band_id', array('value'=>$band_id)); ?>
<?=$this->Form->end('Upload'); ?>