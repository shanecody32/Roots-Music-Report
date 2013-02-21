<?=$this->Form->create('User');?>
<p>
<?=$this->Form->radio('group_id',$group_opt, array('legend' => 'User Group')); ?>
</p>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
<?=$this->Form->input('User.username', array('label' => 'Username')); ?>
<?=$this->Form->input('User.id', array('type'=>'hidden', 'value' => $this->request->data['User']['id'])); ?>		
<?=$this->Form->input('UserDetail.first_name', array('label'=>'First Name')); ?>
<?=$this->Form->input('UserDetail.last_name', array('label'=>'Last Name')); ?>
<?=$this->Form->input('UserDetail.email', array('label'=>'Email Address')); ?>
<?=$this->Form->end('Save Changes'); ?>