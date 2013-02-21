<?=$this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151); ?>

<?=$this->Form->create('RadioStationImage', array('action' => 'admin_add_step_3',"enctype" => "multipart/form-data")); ?>
<?=$this->Form->hidden($radio['RadioStation']['name']); ?>
<?=$this->Form->hidden('path', array('value'=>$folder)); ?>
<?=$this->Cropimage->createForm($uploaded["imagePath"], 151, 151);  ?>
<?=$this->Form->hidden('radio_id', array('value'=>$radio['RadioStation']['id'])); ?>
<?=$this->Form->submit('Done', array("id"=>"save_thumb"));  ?>
<?=$this->Form->end();?>