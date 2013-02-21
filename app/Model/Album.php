<?php
class Album extends AppModel {
	var $name = 'Album';
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


	);
	
	public $actsAs = array('Search.Searchable');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasOne = array(
		'AlbumImage' => array(
			'className' => 'AlbumImage',
			'foreignKey' => 'album_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AlbumStat' => array(
			'className' => 'AlbumStat',
			'foreignKey' => 'album_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $belongsTo = array(
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Label' => array(
			'className' => 'Label',
			'foreignKey' => 'label_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasAndBelongsToMany = array(
		'SubGenre' => array(
			'className' => 'SubGenre',
			'joinTable' => 'album_sub_genres',
			'with' => 'album_sub_genres',
			'foreignKey' => 'album_id',
			'associationForeignKey' => 'sub_genre_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Song' => array(
			'className' => 'Song',
			'joinTable' => 'album_tracks',
			'with' => 'AlbumTracks',
			'foreignKey' => 'album_id',
			'associationForeignKey' => 'song_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'AlbumTracks.track_num',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	var $hasMany = array(
		'RadioStaffPlaylist' => array(
			'className' => 'RadioStaffPlaylist',
			'foreignKey' => 'album_id',
			'dependent' => false,
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
			'foreignKey' => 'album_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AlbumWeeklyGenreChartArchive' => array(
			'className' => 'AlbumWeeklySubGenreChartArchive',
			'foreignKey' => 'album_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AlbumWeeklyGenreChart' => array(
			'className' => 'AlbumWeeklySubGenreChart',
			'foreignKey' => 'album_id',
			'dependent' => false,
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
	
	var $filterArgs = array(
		array('name' => 'name', 'type'=>'query', 'method'=>'filterSearch', 'allowEmpty' => true),
		array('name' => 'sub_genres', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterGenre'),
		//array('name' => 'genres', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterGenre'),
		//array('name' => 'country', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterCountry'),
		//array('name' => 'state', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterState'),
		//array('name' => 'city', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterCity'),
		//array('name' => 'status', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterStatus'),
		//array('name' => 'not_approved', 'type'=>'query', 'method'=>'filterSearch', 'field'=>'!'),
	);
		
	function filterSearch($data, $field = null){
		
			
		if(!empty($data['name'])){
			if($data['starts_with'] == 1){
				$condition = array(
					$this->alias.'.name LIKE' => trim($data['name'])."%",
				);
			} elseif($data['exact'] == 1) {
				$condition = array(
					$this->alias.'.name' => trim($data['name']),
				);
			} else {
				$condition = array(
					$this->alias.'.name LIKE' => "%".trim($data['name'])."%",
				);
			}
		} 
		
		$this->approvedCheck($condition, $data);
		
		$this->statusCheck($condition, $data);
		
		if(isset($condition)){
			$search = array(
				'OR' => array(
					 $condition,
				)
			);
			return $search;
		} else { return array(); }
	}

	function approvedCheck(&$condition, $data){
		if(isset($data['not_approved']) || isset($data['approved'])){
			if(!isset($data['not_approved'])){
				$data['not_approved'] = false;
			}
			if(!isset($data['approved'])){
				$data['approved'] = false;
			}
			
			if($data['not_approved'] && $data['approved']){
				$condition[0] = '0';
			} elseif($data['approved']){
				$condition[$this->alias.'.approved'] = '1';
			} elseif($data['not_approved']){
				$condition[$this->alias.'.approved'] = '0';
			}
		}	
	}
	
	function statusCheck(&$condition, $data){
		if(isset($data['status'])){
			if($data['status'] == 'all'){
				$condition[$this->alias.'.id !='] = 0;
			} elseif($data['status'] == 'verified') {
				$condition[$this->alias.'.verified'] = 1;
			} elseif($data['status'] == 'unverified') {
				$condition[$this->alias.'.verified'] = 0;
			} else {
				$condition[$this->alias.'.approved'] = 0;
			}
		}
	}
	
	function filterGenre($data){
		if(!empty($data['sub_genres'])){
			return $this->getBySubGenre($data);
		} else {
			return $this->getByGenre($data);
		}
	}
	
	
	function getBySubGenre($data){
		$sub_genre_model = ClassRegistry::init('BandSubGenre'); // load join model, the HABTM relationship model
//		$sub_genre_model->Behaviors->attach('Containable', array('autoFields' => false)); // additional containable info if needed
        $sub_genre_model->Behaviors->attach('Search.Searchable'); // set join model to behavior searchable
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('BandSubGenre.sub_genre_id'  => $data['sub_genres']), // field needed to find, selecting the appropriate join table
//			'contain' => array('SubGenre'), // additional containable info if needed
			'fields' => array('BandSubGenre.band_id'), // the field the object you are filtering belongs to
        ));
		return $query;
	}
	
	function getByGenre($data){
		$sub_genre_model = ClassRegistry::init('RadioStaffMemberGenre');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStaffMemberGenre.genre_id'  => $data['genres']), 
			'fields' => array('RadioStaffMemberGenre.radio_staff_member_id'),
        ));		
		return $query;	
	}
	
	

	function DetermineGenresForCharting(){
		set_time_limit('1800');
		$this->Behaviors->attach('Containable');
		$this->contain(array('Song.SubGenre'));
		
		$to_save = array();
		
		$albums = $this->find('all');
		foreach($albums as $album){
			$genre_counts = array();			
			foreach($album['Song'] as $song){
				if(!isset($genre_counts[$song['SubGenre']['id']])){
					$genre_counts[$song['SubGenre']['id']] = 1;
				}
				$genre_counts[$song['SubGenre']['id']] += 1;
				
			}
			if(!empty($album['Song'])) pr($album);
		}
	}
	
	
	function create($data = NULL){
		if(!$data){
			return false;
		}
		$data['name'] = trim($data['name']);
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
			$result = $this->findByName($data['name']);
			if(!$result) return false;
		}
		return $result;
	}

	function add_genre($album_id = 0, $sub_genre_id = 0){
		if(!$album_id || !$sub_genre_id){
			return false;
		}
		$result = $this->find('first', array(
			'conditions' => array(
			   $this->alias.'.id'=>$album_id,
			)
		));
		foreach($result['SubGenre'] as $sub_genre){
			if($sub_genre['id'] == $sub_genre_id){
			  return true;  
			}
		}
		$result['SubGenre']['id'] = $sub_genre_id;
		return $this->save($result);
	}

	function add_song($album_id = 0, $song_id = 0){
		if(!$album_id || !$song_id){
			return false;
		}
		$result = $this->find('first', array(
			'conditions' => array(
			   $this->alias.'.id'=>$album_id,
			)
		));
		foreach($result['Song'] as $song){
			if($song['id'] == $song_id){
			  return true;
			}
		}
		$result['Song']['id'] = $song_id;
		return $this->save($result);
	}

	function album_duplicate_check($data){
		if(!$data){
			return false;
		}
		$this->Behaviors->attach('Containable');
		$album_check = $this->find('first', array(
			'conditions' => array(
				'Album.name' => $data['name'],
				'Album.id NOT' => $data['id'],
				'Album.band_id' => $data['band_id']
			),
			'contains' => array(
				'Song.SongStat',
				'AlbumStat',
				'RadioStationPlaylist',
				'RadioStaffPlaylist',
				'RadioStationRawData'
				
			)
		));
		
		if(!empty($album_check)){
			$album_check['AlbumStat']['tw_spins'] = $album_check['AlbumStat']['tw_spins'] + $data['AlbumStat']['tw_spins'];
			$album_check['AlbumStat']['lw_spins'] = $album_check['AlbumStat']['lw_spins'] + $data['AlbumStat']['lw_spins'];
			$album_check['AlbumStat']['total_spins'] = $album_check['AlbumStat']['total_spins'] + $data['AlbumStat']['total_spins'];
			$album_check['AlbumStat']['plays'] = $album_check['AlbumStat']['plays'] + $data['AlbumStat']['plays'];
			$album_check['AlbumStat']['downloads'] = $album_check['AlbumStat']['downloads'] + $data['AlbumStat']['downloads'];
			if(strtotime($album_check['AlbumStat']['first_charted']) < strtotime($data['AlbumStat']['first_charted'])){
				$album_check['AlbumStat']['first_charted'] = $data['AlbumStat']['first_charted'];
			}
			$this->save($album_check);
			//save song check, delete bad song stats

			$radio_playlist_model = ClassRegistry::init('RadioStationPlaylist');
			$playlists = $radio_playlist_model->find('all', array(
				'conditions'=> array(
					'album_id' => $data['id']
				)
			));
			foreach($playlists as $list){
				$radio_playlist_model->update_entry($list['RadioStationPlaylist']['id'],$list['RadioStationPlaylist']['band_id'], $album_check['Album']['id'], $list['RadioStationPlaylist']['song_id']);
			}

			/*$radio_staff_playlist_model = ClassRegistry::init('RadioStaffPlaylist');
			$playlists = $radio_staff_playlist_model->find('all', array(
				'conditions'=> array(
					'album_id' => $data['id']
				)
			));
			foreach($playlists as $list){
				$list['band_id'] = $data['Band']['id'];
				$list['album_id'] = $album_check['Album']['id'];
				$radio_playlist_model->save($list);
			}
			$radio_station_raw_data = ClassRegistry::init('RadioStationRawData');
			$playlists = $radio_staff_playlist_model->find('all', array(
				'conditions'=> array(
					'album_id' => $data['id']
				)
			));
			foreach($playlists as $list){
				$list['band_id'] = $data['Band']['id'];
				$list['album_id'] = $song_check['Album']['id'];
				$radio_playlist_model->save($list);
			} */
			$this->delete($data['id']);
		}
	}
	
	function merge($merge_to, $delete){
		$this->Behaviors->attach('Containable');
		$original = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.id' => $merge_to
			),
			'contain'=>array(
				'Label',
				'Song.SubGenre.Genre',
				'RadioStationPlaylist',
				'RadioStaffPlaylist',
				'AlbumStat'
			),
		));
		$delete = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.id' => $delete
			),
			'contain'=>array(
				'Label',
				'Song.SubGenre.Genre',
				'RadioStationPlaylist',
				'RadioStaffPlaylist',
				'AlbumStat'
			),
		));
		$delete = $this->combine($original, $delete);
		
		$this->delete($delete['Album']['id']);
		return $original;
	}
	function combine($to_keep, $delete){
		
		$to_keep['AlbumStat']['tw_spins'] = $to_keep['AlbumStat']['tw_spins'] + $delete['AlbumStat']['tw_spins'];
		$to_keep['AlbumStat']['lw_spins'] = $to_keep['AlbumStat']['lw_spins'] + $delete['AlbumStat']['lw_spins'];
		$to_keep['AlbumStat']['total_spins'] = $to_keep['AlbumStat']['total_spins'] + $delete['AlbumStat']['total_spins'];
		$to_keep['AlbumStat']['plays'] = $to_keep['AlbumStat']['plays'] + $delete['AlbumStat']['plays'];
		$to_keep['AlbumStat']['downloads'] = $to_keep['AlbumStat']['downloads'] + $delete['AlbumStat']['downloads'];
		if(strtotime($to_keep['AlbumStat']['first_charted']) < strtotime($delete['AlbumStat']['first_charted'])){
			$to_keep['AlbumStat']['first_charted'] = $delete['AlbumStat']['first_charted'];
		}
		$this->save($to_keep);

		
		if(isset($to_keep['Album'])){
			//add chart tables and archive tables
			$this->updateAllPlaylist($delete['Album']['id'], $to_keep['Album']['id'], 'RadioStaffPlaylists');
			$this->updateAllPlaylist($delete['Album']['id'], $to_keep['Album']['id'], 'RadioStationPlaylists');
			$this->updateAllOther($delete['Album']['id'], $to_keep['Album']['id'], 'AlbumTrack');
			$this->delete($delete['Album']['id']);
		} else {
			$this->updateAllPlaylist($delete['id'], $to_keep['id'], 'RadioStaffPlaylists');
			$this->updateAllPlaylist($delete['id'], $to_keep['id'], 'RadioStationPlaylists');
			$this->updateAllOther($delete['id'], $to_keep['id'], 'AlbumTrack');
			$this->delete($delete['id']);
		}
	}
	
	function updateAllPlaylist($id, $new_id, $model_name){
		$model = ClassRegistry::init($model_name);

		$entries = $model->find('all', array(
			'conditions' => array(
				'album_id' => $id
			)
		));

		foreach($entries as $entry){
			$entry[$model_name]['album_id'] = $new_id;
			$model->save($entry);
		}
	}
	
	function updateAllOther($id, $new_id, $model_name){
		$model = ClassRegistry::init($model_name);
		$entries = $model->find('all', array(
			'conditions' => array(
				'album_id' => $id
			)
		));

		foreach($entries as $entry){
			$entry[$model_name]['band_id'] = $new_id;
			$model->save($entry);
		}	
	}

	function deep_delete($to_delete, $parent = NULL){
		if(is_array($to_delete)){
			foreach($to_delete as $key => $destroy){
				if(!is_numeric($key) && $key != 'id'){
					$parent['parent'] = $key;
				}
				$parent['key'] = $key;
				$this->deepDelete($destroy, $parent);
			}
		} else {
			if($parent['key'] == 'id' && $parent['key'] != '0' && isset($to_delete)){
				if($parent['parent'] != $this->name){
					$this->$parent['parent']->delete($to_delete);
				} else {
					$this->delete($to_delete);
				}
			}
		}
	}
	
	


}
?>