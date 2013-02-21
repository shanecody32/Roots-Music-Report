<?=$this->Form->create('Album');?>
<?=$this->Form->input('name', array('label' => "Album Title"));?>
<?=$this->Form->input('Label.name', array('label' => "Label"));?>
<?=$this->Form->input('sub_genre_for_charting', array('empty'=>'Select One', 'options'=>$sub_genres, 'label'=>'Album Charts As Genre')); ?>
<?=$this->Form->hidden('band_id', array('value'=>$band_id));?>
<?=$this->Form->hidden('id', array('value'=>$album_id));?>
<?=$this->Form->end(__('Save Changes'));?>