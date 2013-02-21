<?=$this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151); ?>

<?=$this->Form->create('BandImage', array('action' => 'admin_add_step_3',"enctype" => "multipart/form-data")); ?>
<?=$this->Form->hidden($band['Band']['name']); ?>
<?=$this->Form->hidden('path', array('value'=>$folder)); ?>
<?=$this->Cropimage->createForm($uploaded["imagePath"], 151, 151);  ?>
<?=$this->Form->hidden('band_id', array('value'=>$band['Band']['id'])); ?>
<?=$this->Form->submit('Done', array("id"=>"save_thumb"));  ?>
<?=$this->Form->end();?>