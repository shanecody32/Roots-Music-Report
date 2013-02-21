<?=$this->Form->create('Song');?>
<?=$this->Form->input('name', array('label' => "Song Title"));?>
<?=$this->Form->input('sub_genre_id', array('label' => "Genre", 'options'=>$sub_genres));?>
<?=$this->Form->hidden('album_id', array('value'=>$album_id));?>
<?=$this->Form->end(__('Add Song'));?>