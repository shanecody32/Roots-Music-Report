<?=$this->Form->create('User');?>
<?=$this->Form->input('User.old_password', array('label' => 'Existing Password', 'type'=>'password')); ?>
<?=$this->Form->input('User.password', array('label' => 'New Password', 'type'=>'password')); ?>
<?=$this->Form->input('User.password_check', array('label' => 'Repeat New Password', 'type'=>'password')); ?>
<?=$this->Form->input('User.id', array('type'=>'hidden', 'value' => $this->request->data['User']['id'])); ?>
<?=$this->Form->end('Save Changes'); ?>