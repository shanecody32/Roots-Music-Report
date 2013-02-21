<?=$this->Form->create('BandLink');?>
<?=$this->Form->input('link');?>
<? $options = array('website'=>'Website','facebook'=>'Facebook','myspace'=>'MySpace','twitter'=>'Twitter','blog'=>'Blog', 'radio_submit'=>'Radio Submit'); ?>
<?=$this->Form->input('type', array('options'=>$options,'empty'=>'(Select One)'), array('selected'=>$this->data['BandLink']['type']));?>
<?=$this->Form->hidden('band_id', array('value'=>$this->data['BandLink']['band_id']));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Link'));?>