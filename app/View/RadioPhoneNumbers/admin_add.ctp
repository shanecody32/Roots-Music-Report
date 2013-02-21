<?=$this->Form->create('RadioPhoneNumber');?>
<?=$this->Form->input('phone');?>
<?=$this->Form->input('type');?>
<?=$this->Form->hidden('radio_station_id', array('value'=>$radio_id));?>
<?=$this->Form->end(__('Add Number'));?>