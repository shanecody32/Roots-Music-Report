<?=$this->Form->create('RadioLink');?>
<?=$this->Form->input('link');?>
<? $options = array('website'=>'Website','facebook'=>'Facebook','myspace'=>'MySpace','twitter'=>'Twitter','blog'=>'Blog'); ?>
<?=$this->Form->input('type', array('options'=>$options,'empty'=>'(Select One)'), array('selected'=>$this->data['RadioLink']['type']));?>
<?=$this->Form->hidden('radio_station_id', array('value'=>$this->data['RadioLink']['radio_station_id']));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Link'));?>