<?php
class SongWeeklyGenreChart extends AppModel {
	var $name = 'SongWeeklyGenreChart';
	var $displayField = 'spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'song_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
}
?>