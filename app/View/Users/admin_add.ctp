<?=$this->Form->create('User');?>
<p>
<?=$this->Form->radio('group_id',$group_opt, array('legend' => 'User Group', 'default' => 'reporter')); ?>
</p>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
<?=$this->Form->input('UserDetail.first_name', array('label'=>'Your First Name')); ?>
<?=$this->Form->input('UserDetail.last_name', array('label'=>'Your Last Name')); ?>
<?=$this->Form->input('UserDetail.email', array('label'=>'Your Email Address')); ?> Your email will be used to login.
<?=$this->Form->input('UserDetail.email_check', array('label'=>'Verify Email Address')); ?>
<?=$this->Form->input('User.password', array('label' => 'Choose Password', 'type'=>'password')); ?>
<?=$this->Form->input('User.password_check', array('label' => 'Verify Password', 'type'=>'password')); ?>	

<?=$this->Form->end('Add User'); ?>