<?php
class RadioStationGenre extends AppModel {
	var $name = 'RadioStationGenre';

	
	var $belongsTo = array(
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foriegnKey' => 'radio_station_id',
		),
		'Genre' => array(
			'className' => 'Genre',
			'foriegnKey' => 'genre_id',
		),
	);
	
}


?>