<?=$this->Form->create('Album');?>
<?=$this->Form->input('name', array('label' => "Album Title"));?>
<?=$this->Form->input('Label.name', array('label' => "Label"));?>
<?=$this->Form->hidden('band_id', array('value'=>$band_id));?>
<?=$this->Form->end(__('Add Album'));?>