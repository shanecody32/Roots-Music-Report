<?=$this->Form->create('RadioAddress');?>
<?=$this->Form->input('country_id', array('options' => $countries, 'empty' => '(choose one)'),array('selected' =>$selected)); ?>
<?=$this->Format->address_form($country['Country']['address_format'],'RadioAddress'); ?>
<?=$this->Form->hidden('radio_station_id', array('value'=>$this->data['RadioAddress']['radio_station_id']));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Address'));?>