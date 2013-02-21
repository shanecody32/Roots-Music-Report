<?=$this->Form->create('Song');?>
<?=$this->Form->input('name', array('label' => "Song Title"));?>
<?=$this->Form->input('sub_genre_id', array('label' => "Sub Genre"));?>
<?=$this->Form->hidden('album_id', array('value'=>$album_id));?>
<?=$this->Form->hidden('id', array('value'=>$song_id));?>
<?=$this->Form->end(__('Save Changes'));?>
