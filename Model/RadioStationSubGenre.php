<?php
class RadioStationSubGenre extends AppModel {
	var $name = 'RadioStationSubGenre';

	
	var $belongsTo = array(
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foriegnKey' => 'radio_station_id',
		),
		'SubGenre' => array(
			'className' => 'SubGenre',
			'foriegnKey' => 'sub_genre_id',
		),
	);
	
}


?>