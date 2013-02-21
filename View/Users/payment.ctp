<? // DW ?>

<?=$this->Form->create('User');?>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
Your email address will be used as your username.
<?=$this->Form->input('UserDetail.email', array('label'=>'Your Email Address')); ?>
<?=$this->Form->input('UserDetail.email_check', array('label'=>'Verify Email Address')); ?>
<?=$this->Form->input('User.password', array('label' => 'Choose Password', 'type'=>'password')); ?>
<?=$this->Form->input('User.password_check', array('label' => 'Verify Password', 'type'=>'password')); ?>	
<?=$this->Form->input('User.type', array('type'=>'hidden', 'value'=>$type)); ?>   
<?=$this->Form->input('UserDetail.first_name', array('label'=>'Your First Name')); ?>
<?=$this->Form->input('UserDetail.last_name', array('label'=>'Your Last Name')); ?>
<?=$this->Form->input('UserDetail.primary_phone', array('label'=>'Your Phone Number')); ?>
<? array_pop($countries); ?>
<?=$this->Form->input('UserAddress.country_id', array('options' => $countries, 'empty' => '(choose one)', 'selected'=>'225')); ?>
<?=$this->Format->address_form($country['Country']['address_format'],'UserAddress'); ?>
<?=$this->Form->input('UserDetail.agreed_to_terms', array('type'=>'checkbox', 'label'=>'I have read and agree to all user terms and conditions, and privacy policy.')); ?>
<?=$this->Form->end('Sign Up'); ?>