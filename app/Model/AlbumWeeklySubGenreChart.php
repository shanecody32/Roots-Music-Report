<?php
class AlbumWeeklySubGenreChart extends AppModel {
	var $name = 'AlbumWeeklySubGenreChart';
	var $displayField = 'spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
}
?>