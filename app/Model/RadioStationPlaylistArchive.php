<?php
class RadioStationPlaylistArchive extends AppModel {
	var $name = 'RadioStationPlaylistArchive';
	var $displayField = 'spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foreignKey' => 'radio_station_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'song_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);	
	
	function count_band_spins_by_week($track_it){
		$spins_by_week = array();
		$week_counted = array();
		$i = '0';	
		foreach($track_it as $entry){
			
			if(!in_array($entry['RadioStationPlaylistArchive']['week_ending'], $week_counted)){
				$week_counted[] = $entry['RadioStationPlaylistArchive']['week_ending'];
				$spins_by_week[$entry['RadioStationPlaylistArchive']['week_ending']] = array('spins'=>array(), 'radio'=>array());
				$spins_by_week[$entry['RadioStationPlaylistArchive']['week_ending']]['spins'] = $entry['RadioStationPlaylistArchive']['spins'];
				$entry['RadioStation']['spins'] = $entry['RadioStationPlaylistArchive']['spins'];
				$spins_by_week[$entry['RadioStationPlaylistArchive']['week_ending']]['radio'][$entry['RadioStation']['name']] = $entry['RadioStation'];
			} else {
				$spins_by_week[$entry['RadioStationPlaylistArchive']['week_ending']]['spins'] += $entry['RadioStationPlaylistArchive']['spins'];
				$entry['RadioStation']['spins'] = $entry['RadioStationPlaylistArchive']['spins'];
				$spins_by_week[$entry['RadioStationPlaylistArchive']['week_ending']]['radio'][$entry['RadioStation']['name']] = $entry['RadioStation'];
			}
		}	
		return $spins_by_week;
	}
	
	//must be ran after count_spins_by_week
	function count_band_spins_by_week_and_album($track_it){
		$spins = array();
		$week_counted = array();	

		foreach($track_it as $entry){
			$spins[$entry['RadioStationPlaylistArchive']['week_ending']][$entry['Album']['name']]['spins'] = 0;
		}	
		foreach($track_it as $entry){
			$spins[$entry['RadioStationPlaylistArchive']['week_ending']][$entry['Album']['name']]['spins'] += $entry['RadioStationPlaylistArchive']['spins'];
			$entry['RadioStation']['spins'] = $entry['RadioStationPlaylistArchive']['spins'];
			$spins[$entry['RadioStationPlaylistArchive']['week_ending']][$entry['Album']['name']]['radio'][$entry['RadioStation']['name']] = $entry['RadioStation'];
		}
		return $spins;
	}
	function count_band_spins_by_week_and_song($track_it){
		$spins = array();
		$week_counted = array();	

		foreach($track_it as $entry){
			$spins[$entry['RadioStationPlaylistArchive']['week_ending']][$entry['Song']['name']]['spins'] = 0;
		}	
		foreach($track_it as $entry){
			$spins[$entry['RadioStationPlaylistArchive']['week_ending']][$entry['Song']['name']]['spins'] += $entry['RadioStationPlaylistArchive']['spins'];
			$entry['RadioStation']['spins'] = $entry['RadioStationPlaylistArchive']['spins'];
			$spins[$entry['RadioStationPlaylistArchive']['week_ending']][$entry['Song']['name']]['radio'][$entry['RadioStation']['name']] = $entry['RadioStation'];
		}
		return $spins;
	}
	
}
?>