<?=$this->Form->create('RadioAddress');?>
<?=$this->Form->input('RadioAddress.country_id', array('options' => $countries, 'empty' => '(choose one)')); ?>
<?=$this->Format->address_form($country['Country']['address_format'],'RadioAddress'); ?>
<?=$this->Form->hidden('radio_station_id', array('value'=>$radio_id));?>
<?=$this->Form->end(__('Add Address'));?>