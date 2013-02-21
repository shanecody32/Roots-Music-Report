<?php
class ChartFunction extends AppModel {
	var $name = 'ChartFunction';
	var $uses = '';
	
	var $temp_chart_size = 200;
	var $weekly_chart_size = 50;
	
	function checkFinalized(){
		$staff_model = ClassRegistry::init('RadioStaffMember');
		$staff_model->Behaviors->attach('Containable');
		$staff = $staff_model->find('all', array(
			'conditions' => array(
				'RadioStaffMember.approved' => 1,
				'RadioStaffMember.reported' => 1,
				'RadioStaffMember.playlist_finalised' => 0
			),
			'contain' => array(
				'RadioStation'
			)
		));
		
		if(!$staff){
			return false;
		} else {
			return $staff;
		}
	}
	
	function setNotReported(){
		$staff_model = ClassRegistry::init('RadioStaffMember');
		$staff_model->Behaviors->attach('Containable');
		$staff = $staff_model->find('all', array(
			'conditions' => array(
				'RadioStaffMember.approved' => 1,
				'RadioStaffMember.reported' => 1,				
			),
		));
		
		foreach($staff as $key => $entry){
			$staff[$key]['RadioStaffMember']['reported'] = 0;
			$staff[$key]['RadioStaffMember']['lw_reported'] = 1;
		}
		$staff_model->saveAll($staff);
	}
	
	function checkNotReported(){
		$staff_model = ClassRegistry::init('RadioStaffMember');
		$staff_model->Behaviors->attach('Containable');
		$staff = $staff_model->find('all', array(
			'conditions' => array(
				'RadioStaffMember.approved' => 1,
				'RadioStaffMember.reported' => 0,
				'RadioStaffMember.lw_reported' => 1,				
			),
			'contain' => array('RadioStation'),
			'order' => array(
				'RadioStation.name' => 'ASC',
				'RadioStaffMember.first_name' => 'ASC'
			)
		));
		$to_save = array();
		foreach($staff as $key => $entry){
			if($entry['RadioStaffMember']['lw_reported'] == 1){
				$to_save[$key]['RadioStaffMember']['id'] = $entry['RadioStaffMember']['id'];
				$to_save[$key]['RadioStaffMember']['lw_reported'] = 0;
			}
		}
		$staff_model->saveAll($to_save);

		if(empty($staff)){
			return false;
		} else {
			return $staff;
		}
	}
	
	function getLastWeek(){
		$week_model = ClassRegistry::init('WeekEnding');
		return $week_model->last_week();
	}
	
	function thisWeek(){
		$week_model = ClassRegistry::init('WeekEnding');
		return $week_model->current_week();
	}
	
	function chartGenCheck($days){
		if(strtotime(date('Y-m-j')) > strtotime(date('Y-m-j', strtotime('+'.$days.' days', strtotime($this->thisWeek()))))){
			return true;
		}
		
		return true;
	}
	
	function updateWeekEnding(){
		$week_model = ClassRegistry::init('WeekEnding');
		return $week_model->update_week();
	}
	
	function compileRadioPlaylist(){
		set_time_limit('15000');
		$staff_model = ClassRegistry::init('RadioStaffMember');
		$staff_model->Behaviors->attach('Containable');
		$staff_members = $staff_model->find('all', array(
			'conditions' => array(
				'RadioStaffMember.approved' => 1,
				'RadioStaffMember.reported' => 1,
				'RadioStaffMember.playlist_finalised' => 1
			),
			'contain' => array(
				'RadioStaffPlaylist'
			)
		));
		
		$playlists = array();
		
		foreach($staff_members as $staff){
			foreach($staff['RadioStaffPlaylist'] as $list){
				$this->addToRadioList($list, $playlists, $staff['RadioStaffMember']['radio_station_id']);
			}
		}
		
		$radio_model = ClassRegistry::init('RadioStationPlaylist');
		if($radio_model->saveAll($playlists)){
			return true;
		} else {
			return false;
		}
	}
	
	function addToRadioList($entry, &$playlists, $id){
		if(empty($playlists)){
			$playlists[] = array(
				'radio_station_id' => $id,
				'band_id' => $entry['band_id'],
				'song_id' => $entry['song_id'],
				'album_id' => $entry['album_id'],
				'spins' => $entry['spins']
			);
			return true;
		}
		
		foreach($playlists as $key => $value){
			if($this->playlistIsEqual($entry, $value, $id)){
				$playlists[$key]['spins'] = $playlists[$key]['spins'] + $entry['spins'];
				return true;
			}
		}
		$playlists[] = array(
			'radio_station_id' => $id,
			'band_id' => $entry['band_id'],
			'song_id' => $entry['song_id'],
			'album_id' => $entry['album_id'],
			'spins' => $entry['spins']
		);
		return true;
	}
	
	function totalSpins(){
		set_time_limit('1800');
		$radio_model = ClassRegistry::init('RadioStation');
		$radio_model->Behaviors->attach('Containable');
		$radio_stations = $radio_model->find('all', array(
			'contain' => array(
				'RadioStationPlaylist'
			)
		));

		$this->clearStats();
		
		foreach($radio_stations as $radio){
			foreach($radio['RadioStationPlaylist'] as $list){
				$this->addStats($list, $song_stats, $album_stats);
			}
		}	
	
		return true;	
	}
	
	function clearStats(){
		$song_stat_model = ClassRegistry::init('SongStat');
		$song_stat_model->recursive = -1;
		$song_stats = $song_stat_model->find('all', array(
			'conditions' => array(
				'tw_spins !=' => 0 
			)
		));
		
		
		
		$album_stat_model = ClassRegistry::init('AlbumStat');
		$album_stat_model->recursive = -1;
		$album_stats = $album_stat_model->find('all', array(
			'conditions' => array(
				'tw_spins !=' => 0 
			)
		));
		
		
		$i = 0;
		foreach($song_stats as $stat){
			$song_stats[$i]['SongStat']['lw_spins']	= $song_stats[$i]['SongStat']['tw_spins'];
			$song_stats[$i]['SongStat']['lw_stations'] = $song_stats[$i]['SongStat']['tw_stations'];
			$song_stats[$i]['SongStat']['tw_spins'] = 0;
			$song_stats[$i]['SongStat']['tw_stations'] = 0;
			$i++;
		}
		
		$j=0;
		foreach($album_stats as $stat){
			$album_stats[$j]['AlbumStat']['lw_spins'] = $album_stats[$j]['AlbumStat']['tw_spins'];
			$album_stats[$j]['AlbumStat']['lw_stations'] = $album_stats[$j]['AlbumStat']['tw_stations'];
			$album_stats[$j]['AlbumStat']['tw_spins'] = 0;
			$album_stats[$j]['AlbumStat']['tw_stations'] = 0;
			$j++;
		}		
		
		$song_stat_model->saveAll($song_stats);
		$album_stat_model->saveAll($album_stats);
	}
	
	function addStats($entry, &$song_stats, &$album_stats){
		// loop through stats and add spins for each stat.
		$i = 0;
		
		$song_stat_model = ClassRegistry::init('SongStat');
		$song_stat_model->recursive = -1;
		$song_stat = $song_stat_model->find('first', array(
			'conditions' => array(
				'song_id' => $entry['song_id'],
			)		
		));
		
		$song_stat['SongStat']['total_spins'] += $entry['spins'];
		$song_stat['SongStat']['tw_spins'] += $entry['spins'];
		$song_stat['SongStat']['total_stations'] += 1;
		$song_stat['SongStat']['tw_stations'] += 1;

		$album_stat_model = ClassRegistry::init('AlbumStat');
		$album_stat_model->recursive = -1;
		$album_stat = $album_stat_model->find('first', array(
			'conditions' => array(
				'album_id' => $entry['album_id'],
			)		
		));
		
		$album_stat['AlbumStat']['total_spins'] += $entry['spins'];
		$album_stat['AlbumStat']['tw_spins'] += $entry['spins'];
		$album_stat['AlbumStat']['total_stations'] += 1;
		$album_stat['AlbumStat']['tw_stations'] += 1;
				
		
		
		if($album_stat_model->save($album_stat) && $song_stat_model->save($song_stat)){
			unset($album_stat);
			unset($song_stat);
			return true;
		} else {
			unset($album_stat);
			unset($song_stat);
			return false;
		}		
	}
	
	function getTempChart($genre, $type = 'song', $gtype = "sub_genre"){
		switch($gtype){
			case 'genre':
				$genre_model = ClassRegistry::init('Genre');
				$genre_model->recursive = -1;
				$genre = $genre_model->findByName(Inflector::humanize($genre));
				$table = 'genre';
				$chart = $this->getGenreTempChart($type, $genre);
				break;
			default:
				$genre_model = ClassRegistry::init('SubGenre');
				$genre_model->recursive = -1;
				$genre = $genre_model->findByName(Inflector::humanize($genre));
				$table = 'sub_genre';
				$chart = $this->getSubGenreTempChart($type, $table, $genre);
				break;
		}
		
		return $chart;
		
	}
	
	function getGenreTempChart($type, $genre){
		if($type == 'song'){
			$song_model = ClassRegistry::init('SongStat');
			$song_model->Behaviors->attach('Containable');
			//$staffs = $this->subQuery(array('field' => 'radio_staff_member_id', 'operation' => '>=', 'value' => 1,));
			$chart = $song_model->find('all', array(
				'conditions' => array(
					'SongStat.tw_spins !=' => 0,
				),
				'contain' => array(
					'Song.Band',
				),
				'order' => array(
					'tw_spins' => 'DESC',
					'tw_stations' => 'DESC',
					'lw_spins' => 'DESC',
					'lw_stations' => 'DESC',
					'lw_rank' => 'DESC'
				),
				'limit' => $this->temp_chart_size
			));
		} elseif($type == 'album'){
			$song_model = ClassRegistry::init('AlbumStat');
			$song_model->Behaviors->attach('Containable');
			$chart = $song_model->find('all', array(
				'conditions' => array(
					'AlbumStat.tw_spins !=' => 0,
				),
				'contain' => array(
					'Album.Band', 'Album.Label'
				),
				'order' => array(
					'tw_spins' => 'DESC',
					'tw_spins' => 'DESC',
					'tw_stations' => 'DESC',
					'lw_spins' => 'DESC',
					'lw_stations' => 'DESC',
					'lw_rank' => 'DESC'
				),
				'limit' => $this->temp_chart_size
			));
		}
		
		return $chart;
	}
	
	function getSubGenreTempChart($type, $table, $genre){
		switch(strtolower($type)){
			case 'song':
				$song_model = ClassRegistry::init('SongStat');
				$song_model->Behaviors->attach('Containable');
				$chart = $song_model->find('all', array(
					'conditions' => array(
						'SongStat.tw_spins !=' => 0,
						'Song.'.$table.'_id' => $genre[Inflector::Camelize($table)]['id'],
					),
					'contain' => array(
						'Song.Band',
					),
					'order' => array(
						'tw_spins' => 'DESC',
						'tw_stations' => 'DESC',
						'lw_spins' => 'DESC',
						'lw_stations' => 'DESC',
						'lw_rank' => 'DESC'
					),
					'limit' => $this->temp_chart_size
				));
				break;
			case 'album':
				$song_model = ClassRegistry::init('AlbumStat');
				$song_model->Behaviors->attach('Containable');
				$chart = $song_model->find('all', array(
					'conditions' => array(
						'AlbumStat.tw_spins !=' => 0,
						'Album.'.$table.'_for_charting' => $genre[Inflector::Camelize($table)]['id'],
					),
					'contain' => array(
						'Album.Band', 'Album.Label'
					),
					'order' => array(
						'tw_spins' => 'DESC',
						'tw_spins' => 'DESC',
						'tw_stations' => 'DESC',
						'lw_spins' => 'DESC',
						'lw_stations' => 'DESC',
						'lw_rank' => 'DESC'
					),
					'limit' => $this->temp_chart_size
				));
				break;
		}
		
		return $chart;
	}
	
	function check_file_type($file = Null){
		if($file){
			$length = strlen($file['name']);
			$characters = 4;
			$start = $length - $characters;
			$file_ext = substr($file['name'] , $start ,$characters);
			foreach($this->file_types as $type){
				if(strtolower($file_ext) == $type){
					return true;
				}
			}
		}
		return false;
	}


	function generateWeeklyCharts($type, $type2 = 'song', $genre_type = 'SubGenre'){
		$genre_model = ClassRegistry::init($genre_type);
		$genre_model->recursive = -1;
		$genres = $genre_model->find('all');
		$this->truncate($type);
		
		foreach($genres as $genre){
			$this->makeWeeklyChart($genre[$genre_type]['id'], $type, $type2, $genre_type);
		}	
	}
	
	function makeWeeklyChart($genre_id, $type, $type2, $genre_type = 'SubGenre'){
		$chart = array();
		$stat_model_name = Inflector::humanize($type2);		
		$stat_model = ClassRegistry::init($stat_model_name.'Stat');
		$stat_model->Behaviors->attach('Containable');			
			
		$to_find = array(
				'conditions' => array(
					$stat_model_name.'Stat.tw_spins !=' => 0,	
					$stat_model_name.'.verified' => 0,
					$stat_model_name.'.approved' => 0,
				),
				'order' => array(
					'tw_spins' => 'DESC',
					'tw_stations' => 'DESC',
					'lw_spins' => 'DESC',
					'lw_stations' => 'DESC',
					'lw_rank' => 'DESC'
				),
				'contain' => array($stat_model_name),
				'limit' => $this->weekly_chart_size
			);
		
		if($type == 'song_weekly_sub_genre_charts'){
			$to_find['conditions']['Song.sub_genre_id'] = $genre_id;
		} elseif($type == 'album_weekly_sub_genre_charts'){
			$to_find['conditions']['Album.sub_genre_for_charting'] = $genre_id;
		} elseif($type == 'song_weekly_genre_charts'){
			$to_find['conditions'][] = 'Song.sub_genre_id IN (SELECT id FROM rmr_second_draft.sub_genres AS SubGenre WHERE SubGenre.genre_id = '.$genre_id.')';
		} elseif($type == 'album_weekly_genre_charts'){
			$to_find['conditions'][] = 'Album.sub_genre_for_charting IN (SELECT id FROM rmr_second_draft.sub_genres AS SubGenre WHERE SubGenre.genre_id = '.$genre_id.')';
		} else {
			return false;
		}
		
		$results = $stat_model->find('all', $to_find);
		$i = 1;
		$chart = array();
		foreach($results as $entry){
			if($entry[$stat_model_name.'Stat']['lw_rank']){
				$movement = $entry[$stat_model_name.'Stat']['lw_rank'] - $i;
			} else {
				$movement = 0;
			}
			
			$chart[] = array(
				Inflector::classify($type) => array(
					Inflector::underscore($genre_type).'_id' => $genre_id,
					strtolower($type2).'_id' => $entry[$stat_model_name]['id'],
					'rank' => $i,
					'last_rank' => $entry[$stat_model_name.'Stat']['lw_rank'],
					'movement' => $movement,
					'stations' => $entry[$stat_model_name.'Stat']['tw_stations'],
					'spins' => $entry[$stat_model_name.'Stat']['tw_spins'],
					'weeks_on' => $entry[$stat_model_name.'Stat']['weeks_on'] + 1, // change to consecutive weeks on chart - add to song_stats	
					'week_ending' => $this->thisWeek()
				)				
			);
			$i++;
		}

		$chart_model = ClassRegistry::init(Inflector::classify($type));
		$chart_model->Behaviors->attach('Containable');
		$chart_model->saveAll($chart);
	}
	
	
	function archivePlaylist($model){
		$playlist_model = ClassRegistry::init($model.'Playlist');
		$playlist_model->recursive = -1;
		set_time_limit('15000');
		$playlist = $playlist_model->find('all');
		if(!$playlist){
			return false;
		}
		
		$to_archive = array();
		$i = 0;
		foreach($playlist as $entry){
			$to_archive[$i][$model.'PlaylistArchive'] = $entry[$model.'Playlist'];
			unset($to_archive[$i][$model.'PlaylistArchive']['id']);
			$to_archive[$i][$model.'PlaylistArchive']['week_ending'] = $this->thisWeek();
			$i++;
		}
		
		$archive_model = ClassRegistry::init($model.'PlaylistArchive');
		if($archive_model->saveAll($to_archive)){
			$playlist_model->deleteAll(array(1=>1));
			return true;
		} else {
			return false;
		}
	
	
	}
	
	function archiveCharts(){
		$this->archiveChart('album_monthly_sub_genre');
		$this->archiveChart('album_weekly_sub_genre');	
		$this->archiveChart('song_weekly_sub_genre');
		$this->archiveChart('song_monthly_sub_genre');
	}
	
	function archiveChart($model){
		$chart_model = ClassRegistry::init(Inflector::camelize($model.'_chart'));
		$chart_model->recursive = -1;
		set_time_limit('15000');
		$chart = $chart_model->find('all');
		if(!$chart){
			return false;
		}
		
		$to_archive = array();
		$i = 0;
		foreach($chart as $entry){
			$to_archive[$i][Inflector::camelize($model.'_chart_archive')] = $entry[Inflector::camelize($model.'_chart')];
			unset($to_archive[$i][Inflector::camelize($model.'_chart_archive')]['id']);
			$i++;
		}
		
		$archive_model = ClassRegistry::init(Inflector::camelize($model.'_chart_archive'));
		if($archive_model->saveAll($to_archive)){
			return true;
		} else {
			return false;
		}
	}
	
	function setLastRank($model_name){
		$chart_model = ClassRegistry::init($model_name.'WeeklySubGenreChart');
		$chart_model->Behaviors->attach('Containable');
		$chart = $chart_model->find('all', array(
			'contain' => array(
				$model_name.'.'.$model_name.'Stat'
			)
		));
		
		$album_stats = array();
		
		$i = 0;
		foreach($chart as $entry){
			$album_stats[$i][$model_name.'Stat']['lw_rank'] = $entry[$model_name.'WeeklySubGenreChart']['rank'];
			$album_stats[$i][$model_name.'Stat']['id'] = $entry[$model_name][$model_name.'Stat']['id'];
			if($entry[$model_name][$model_name.'Stat']['first_charted'] = '0000-00-00'){
				$album_stats[$i][$model_name.'Stat']['first_charted'] = $entry[$model_name.'WeeklySubGenreChart']['week_ending'];
			}
			if($entry[$model_name][$model_name.'Stat']['hr_achieved'] == 0 || $entry[$model_name.'WeeklySubGenreChart']['rank'] <= $entry[$model_name][$model_name.'Stat']['hr_achieved']){
				$album_stats[$i][$model_name.'Stat']['hr_achieved'] = $entry[$model_name.'WeeklySubGenreChart']['rank'];
				$album_stats[$i][$model_name.'Stat']['hr_week'] = $entry[$model_name.'WeeklySubGenreChart']['week_ending'];
			}
			$i++;
		}
		$album_model = ClassRegistry::init($model_name.'Stat');
		$album_model->saveAll($album_stats);
		
	}
	
	function unlockAllPlaylist(){
		$staff_model = ClassRegistry::init('RadioStaffMember');
		$staff_model->Behaviors->attach('Containable');
		$staff = $staff_model->find('all', array(
			'conditions' => array(
				'RadioStaffMember.playlist_finalised' => 1
			),
		));
		
		foreach($staff as $key => $entry){
			$staff[$key]['RadioStaffMember']['playlist_finalised'] = 0;
		}
		$staff_model->saveAll($staff);
	}

	/*
	Array(
		[id] => ''
		[radio_staff_member_id] => ''
		[band_id] => ''
		[song_id] => ''
		[album_id] => ''
		[spins] => ''
		)
	*/
	function playlistIsEqual($first, $second, $radio_id = 0){
		if($first['band_id'] == $second['band_id']){
			if($first['song_id'] == $second['song_id']){
				if($first['album_id'] == $second['album_id']){
					if($second['radio_station_id'] == $radio_id){
						echo 'yeah';
						return true;
					}
				}
			}
		}
		return false;
	}
	
	function radio_from_staff_playlists(){
		$radio_playlist_model = ClassRegistry::init('RadioStationPlaylist');		
		$radio_model = ClassRegistry::init('RadioStation');
		
		$radio_model->Behaviors->attach('Containable');
		
		$radio_stations = $radio_model->find('all', array(
			'conditions' => array(
				'active' => 1,
			),
			'contain' => 'RadioStaffMember'
		));
		
		foreach($radio_stations as $station){
			if(!$station['RadioStation']['automatic'] || !$station['RadioStation']['compiled']){
				$radio_playlist_model->delete_entire_playlist($station['RadioStation']['id']);
				$this->merge_staff_playlists($station);
			}
		}
	}
	
	function merge_staff_playlists($station){
		$staff_playlist_model = ClassRegistry::init('RadioStaffPlaylist');
		$radio_playlist_model = ClassRegistry::init('RadioStationPlaylist');
		$staff_playlist_model->Behaviors->attach('Containable');
		
		$radio_playlist = array();
		
		foreach($station['RadioStaffMember'] as $member){
			if($member['playlist_finalised'] && $member['approved'] && !$member['violations']){
				$playlists = $staff_playlist_model->find('all', array(
					'conditions' => array(
						'radio_staff_member_id' => $member['id']
					),
					'contain' => ''
				));
				foreach($playlists as $entry){
					$radio_playlist_model->add_to_list($entry['RadioStaffPlaylist'], $station['RadioStation']['id'], false);
				}	
			}
		}
	}
	
	function compare_lists($radio_playlists, $member_playlists){
		
	}
	
	function createStatTables(){
		set_time_limit('15000');
		$song_model = ClassRegistry::init('Song');
		$song_model->Behaviors->attach('Containable');
		$songs = $song_model->find('all', array('contain'=>'SongStat'));
		
		$song_stat_model = ClassRegistry::init('SongStat');
		$song_stat_model->recursive = -1;
		
		$song_stats = array();
		
		foreach($songs as $song){
			if(!empty($song['SongStat'])){
				$song_stats[]['song_id'] = $song['Song']['id'];		
			}
		}
		$song_stat_model->saveAll($song_stats);
		
		
		$album_model = ClassRegistry::init('Album');
		$album_model->Behaviors->attach('Containable');
		$albums = $album_model->find('all', array('contain'=>'AlbumStat'));
		
		$album_stat_model = ClassRegistry::init('AlbumStat');
		$album_stat_model->recursive = -1;
		
		$album_stats = array();
		
		foreach($albums as $album){
			if(!empty($album['AlbumStat'])){
				$album_stats[]['album_id'] = $album['Album']['id'];		
			}
		}
		$album_stat_model->saveAll($album_stats);
	}

}
?>