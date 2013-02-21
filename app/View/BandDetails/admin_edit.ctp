<?=$this->Form->create('BandDetail');?>
<?=$this->Form->input('rs_band_id', array('type' => 'text', 'label'=>'Radio Submit Band Id'));?>
<?=$this->Form->hidden('band_id', array('value'=>$this->data['BandDetail']['band_id']));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Link'));?>