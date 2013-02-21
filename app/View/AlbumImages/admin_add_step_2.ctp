<?=$this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151); ?>
<h1>Select a thumbnail for your Image</h1>
<?=$this->Form->create('AlbumImage', array('action' => 'admin_add_step_3',"enctype" => "multipart/form-data")); ?>
<?=$this->Form->hidden($album['Album']['name']); ?>
<?=$this->Form->hidden('path', array('value'=>$folder)); ?>
<?=$this->Cropimage->createForm($uploaded["imagePath"], 151, 151);  ?>
<?=$this->Form->hidden('album_id', array('value'=>$album['Album']['id'])); ?>
<?=$this->Form->submit('Done', array("id"=>"save_thumb"));  ?>
<?=$this->Form->end();?>