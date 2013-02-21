<?=$this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151); ?>

<?=$this->Form->create('RadioStaffImage', array('action' => 'admin_add_step_3',"enctype" => "multipart/form-data")); ?>
<?=$this->Form->hidden($this->Display->fullName($staff['RadioStaffMember'])); ?>
<?=$this->Form->hidden('path', array('value'=>$folder)); ?>
<?=$this->Cropimage->createForm($uploaded["imagePath"], 151, 151);  ?>
<?=$this->Form->hidden('staff_id', array('value'=>$staff['RadioStaffMember']['id'])); ?>
<?=$this->Form->submit('Done', array("id"=>"save_thumb"));  ?>
<?=$this->Form->end();?>