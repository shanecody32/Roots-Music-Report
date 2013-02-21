<?=$this->Form->create('RadioStaffMember', array('enctype' => 'multipart/form-data','admin'=>'1')); ?>
<?=$this->Form->input('submittedfile',array('label'=>'File To Convert','type' => 'file')); ?>

<?=$this->Form->end(__('Upload File'));?>