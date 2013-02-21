<?=$this->Form->create('AlbumImage', array('action' => 'admin_add_step_2', "enctype" => "multipart/form-data")); ?>
<?=$this->Form->input('image',array("type" => "file")); ?>
<?=$this->Form->hidden('album_id', array('value'=>$album_id)); ?>
<?=$this->Form->end('Upload'); ?>