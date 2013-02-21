<?=$this->Form->create('RadioPhoneNumber');?>
<?=$this->Form->input('phone');?>
<?=$this->Form->input('type');?>
<?=$this->Form->hidden('radio_station_id', array('value'=>$this->data['RadioPhoneNumber']['radio_station_id']));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Number'));?>