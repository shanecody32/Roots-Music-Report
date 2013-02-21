<?=$this->Form->create('RadioLink');?>
<?=$this->Form->input('link');?>
<? $options = array('website'=>'Website','facebook'=>'Facebook','myspace'=>'MySpace','youtube'=>'YouTube','twitter'=>'Twitter','blog'=>'Blog'); ?>
<?=$this->Form->input('type', array('options'=>$options,'empty'=>'(Select One)'));?>
<?=$this->Form->hidden('radio_station_id', array('value'=>$radio_id));?>
<?=$this->Form->end(__('Add Link'));?>