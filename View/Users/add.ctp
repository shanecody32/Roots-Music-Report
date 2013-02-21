<?=$this->Form->create('User');?>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
<?=$this->Form->input('User.id', array('type'=>'hidden', 'value' => $this->request->data['User']['id'])); ?>		
<?=$this->Form->input('UserDetail.first_name', array('label'=>'First Name')); ?>
<?=$this->Form->input('UserDetail.last_name', array('label'=>'Last Name')); ?>
<?=$this->Form->input('UserDetail.email', array('label'=>'Email Address')); ?>
<?=$this->Form->input('UserDetail.email_check', array('label'=>'Verify Email Address')); ?>
<?=$this->Form->input('UserDetail.primary_phone', array('label'=>'Phone Number')); ?>
<?=$this->Form->input('UserAddress.address_1', array('label'=>'Address')); ?>
<?=$this->Form->input('UserAddress.address_2', array('label'=>false)); ?>
<?=$this->Form->input('UserAddress.address_3', array('label'=>false)); ?>
<?=$this->Form->input('UserAddress.city_id', array('label'=>'City')); ?>
<?=$this->Form->input('UserAddress.state_id', array('label'=>'State')); ?>
<?=$this->Form->input('UserAddress.country_id', array('label'=>'Country')); ?>
<?=$this->Form->input('UserAddress.postal_code_id', array('label'=>'Zip/Postal Code')); ?>
<?=$this->Form->end('Save Changes'); ?>