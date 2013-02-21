<? // for DW ?>
<?=$this->Form->create('RadioStaffMember');?>
<?=$this->Form->input('radio_station_id', array('value'=>$radio_id, 'type'=>'hidden')); ?>
<?=$this->Form->input('first_name'); ?>
<?=$this->Form->input('last_name'); ?>
<?=$this->Form->input('email'); ?>
<?=$this->Form->end('Create Staff Member'); ?>