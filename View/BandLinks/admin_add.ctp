<?=$this->Form->create('BandLink');?>
<?=$this->Form->input('link');?>
<? $options = array('website'=>'Website','facebook'=>'Facebook','myspace'=>'MySpace','youtube'=>'YouTube','twitter'=>'Twitter','blog'=>'Blog', 'radio_submit'=>'Radio Submit'); ?>
<?=$this->Form->input('type', array('options'=>$options,'empty'=>'(Select One)'));?>
<?=$this->Form->hidden('band_id', array('value'=>$band_id));?>
<?=$this->Form->end(__('Add Link'));?>