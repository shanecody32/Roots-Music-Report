<?php
class Song extends AppModel {
	var $name = 'Song';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'band_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SubGenre' => array(
			'className' => 'SubGenre',
			'foreignKey' => 'sub_genre_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'RadioStaffPlaylist' => array(
			'className' => 'RadioStaffPlaylist',
			'foreignKey' => 'song_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RadioStationPlaylist' => array(
			'className' => 'RadioStationPlaylist',
			'foreignKey' => 'song_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RadioStationRawData' => array(
			'className' => 'RadioStationRawData',
			'foreignKey' => 'song_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SongWeeklyGenreChartArchive' => array(
			'className' => 'SongWeeklySubGenreChartArchive',
			'foreignKey' => 'song_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SongWeeklyGenreChart' => array(
			'className' => 'SongWeeklySubGenreChart',
			'foreignKey' => 'song_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		
	);

		var $hasOne = array(
			'SongStat' => array(
			'className' => 'SongStat',
			'foreignKey' => 'song_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
		);

	var $hasAndBelongsToMany = array(
		'Album' => array(
			'className' => 'Album',
			'joinTable' => 'album_tracks',
			'with' => 'AlbumTracks',
			'foreignKey' => 'song_id',
			'associationForeignKey' => 'album_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'created DESC',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
		
	function create($data = NULL){
		if(!$data){
			return false;
		}
		$data['name'] = Inflector::humanize(strtolower(trim($data['name'])));
		$result = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.name' => $data['name'],
				$this->alias.'.band_id' => $data['band_id']
			)
		));
		if(!$result){
			unset($this->id);
			$data['seo_name'] = strtolower(Inflector::slug($data['name']));
			$result = $this->save($data);
			$result = $this->find('first',array(
				'conditions' => array(
					$this->alias.'.name' => $data['name'],
					$this->alias.'.band_id' => $data['band_id']
				)
			));
		}
		return $result;
	}

	function combine($to_keep, $delete){
		$to_keep['SongStat']['tw_spins'] = $to_keep['SongStat']['tw_spins'] + $delete['SongStat']['tw_spins'];
		$to_keep['SongStat']['lw_spins'] = $to_keep['SongStat']['lw_spins'] + $delete['SongStat']['lw_spins'];
		$to_keep['SongStat']['total_spins'] = $to_keep['SongStat']['total_spins'] + $delete['SongStat']['total_spins'];
		$to_keep['SongStat']['plays'] = $to_keep['SongStat']['plays'] + $delete['SongStat']['plays'];
		$to_keep['SongStat']['downloads'] = $to_keep['SongStat']['downloads'] + $delete['SongStat']['downloads'];
		if(strtotime($to_keep['SongStat']['first_charted']) < strtotime($delete['SongStat']['first_charted'])){
			$to_keep['SongStat']['first_charted'] = $delete['SongStat']['first_charted'];
		}
		$this->save($to_keep);
		
		//add chart tables and archive tables
		$this->updateAllPlaylists($delete['id'], $to_keep['id'], 'RadioStaffPlaylists');
		$this->updateAllPlaylists($delete['id'], $to_keep['id'], 'RadioStationPlaylists');	
		$this->delete($delete['id']);
	}
	
	function updateAllPlaylists($id, $new_id, $model_name){
		$model = ClassRegistry::init($model_name);
		$entries = $model->find('all', array(
			'conditions' => array(
				'song_id' => $id
			)
		));
		
		foreach($entries as $entry){
			$entry[$model_name]['song_id'] = $new_id;
			$model->save($entry);
		}
	}
	
	function song_duplicate_check($data){
		pr($data);
	
		/*if(!$data){
			return false;
		}
		$this->Behaviors->attach('Containable');
		$song_check = $this->find('first', array(
			'conditions' => array(
				'Song.name' => $data['name'],
				'Song.id NOT' => $data['id'],
				'Song.band_id' => $data['band_id']
			),
			'contains' => array(
				'SongStat',
				'Band',
				'AlbumTrack.Album',
				'RadioStationPlaylist',
				'RadioStaffPlaylist',
				'RadioStationRawData'
			)
		));

		if(!empty($song_check)){
			$song_check['SongStat']['tw_spins'] = $song_check['SongStat']['tw_spins'] + $data['SongStat']['tw_spins'];
			$song_check['SongStat']['lw_spins'] = $song_check['SongStat']['lw_spins'] + $data['SongStat']['lw_spins'];
			$song_check['SongStat']['total_spins'] = $song_check['SongStat']['total_spins'] + $data['SongStat']['total_spins'];
			$song_check['SongStat']['plays'] = $song_check['SongStat']['plays'] + $data['SongStat']['plays'];
			$song_check['SongStat']['downloads'] = $song_check['SongStat']['downloads'] + $data['SongStat']['downloads'];
			if(strtotime($song_check['SongStat']['first_charted']) < strtotime($data['SongStat']['first_charted'])){
				$song_check['SongStat']['first_charted'] = $data['SongStat']['first_charted'];
			}
			$this->save($song_check);
			//save song check, delete bad song stats

			$radio_playlist_model = ClassRegistry::init('RadioStationPlaylist');
			$playlists = $radio_playlist_model->find('all', array(
				'conditions'=> array(
					'song_id' => $data['id']
				)
			));
			foreach($playlists as $list){
				$radio_playlist_model->update_entry($list['RadioStationPlaylist']['id'],$song_check['Song']['band_id'], $list['Album']['id'], $song_check['Song']['id']);
			}

			$radio_staff_playlist_model = ClassRegistry::init('RadioStaffPlaylist');
			$playlists = $radio_staff_playlist_model->find('all', array(
				'conditions'=> array(
					'song_id' => $data['id']
				)
			));
			pr($data);
			pr($song_check);
			foreach($playlists as $list){
				$list['band_id'] = $data['id'];
				$list['album_id'] = $song_check['Album']['id'];
				$list['song_id'] = $song_check['Song']['id'];
				$radio_playlist_model->save($list);
			}
			$radio_station_raw_data = ClassRegistry::init('RadioStationRawData');
			$playlists = $radio_staff_playlist_model->find('all', array(
				'conditions'=> array(
					'song_id' => $data['id']
				)
			));
			foreach($playlists as $list){
				$list['band_id'] = $data['Band']['id'];
				$list['album_id'] = $song_check['Album']['id'];
				$list['song_id'] = $song_check['Song']['id'];
				$radio_playlist_model->save($list);
			}
			$this->delete($data['id']);
		} */
	}

	function merge($merge_to, $delete){
		$this->Behaviors->attach('Containable');
		$original = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.id' => $merge_to
			),
			'contain'=>array(
				'SubGenre.Genre',
				'RadioStationPlaylist',
				'RadioStaffPlaylist',
				'RadioStationRawData',
				'Album.Label'
			),
		));
		$delete = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.id' => $delete
			),
			'contain'=>array(
				'SubGenre.Genre',
				'RadioStationPlaylist',
				'RadioStaffPlaylist',
				'RadioStationRawData',
				'Album.Label'
			),
		));
		$delete = $this->combine($original, $delete);
		
		$this->delete($delete[$this->alias]['id']);
		return $original;
	}

	function combine2($original, $delete){
		$album_track_model = ClassRegistry::init('AlbumTrack');
		$album_model = ClassRegistry::init('Album');

		// go trough delete and compare change ids
		$album_track_model->create($delete['Album']['id'], $original['Song']['id']);
		
		$radio_playlist_model = ClassRegistry::init('RadioStationPlaylist');
		$playlists = $radio_playlist_model->find('all', array(
			'conditions'=> array(
				'album_id' => $delete['Album']['id']
			)
		));
		foreach($playlists as $list){
			$radio_playlist_model->update_entry($list['RadioStationPlaylist']['id'],$list['RadioStationPlaylist']['band_id'], $list['RadioStationPlaylist']['album_id'], $original['Song']['id']);
		}
		
		$album_track_model->deleteAll(array('AlbumTrack.song_id' => $delete['Song']['id']));
		
		return $delete;
	}


}
?>