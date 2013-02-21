
<?=$this->Form->create('RadioStationPlaylist', array('enctype' => 'multipart/form-data','admin'=>'1')); ?>
<?=$this->Form->input('file',array('label'=>'Playlist File','type' => 'file')); ?>
<?=$this->Form->hidden('radio_station_id', array('value' => $radio_id)); ?>
<?=$this->Form->end(__('Upload File'));?>