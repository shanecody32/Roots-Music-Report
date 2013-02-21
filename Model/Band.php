<?php
class Band extends AppModel {
	var $name = 'Band';
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

		// Function Specific Variables

		var $file_types = array('.csv');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'BandDetail' => array(
			'className' => 'BandDetail',
			'foreignKey' => 'band_id',
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
	var $hasMany = array(
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'band_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'Album.created ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'BandImage' => array(
			'className' => 'BandImage',
			'foreignKey' => 'band_id',
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
		'BandLink' => array(
			'className' => 'BandLink',
			'foreignKey' => 'band_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => array('BandLink.type'=>'ASC'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'band_id',
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
		'RadioStaffPlaylist' => array(
			'className' => 'RadioStaffPlaylist',
			'foreignKey' => 'band_id',
			'dependent' => true,
		),
		'RadioStationPlaylist' => array(
			'className' => 'RadioStationPlaylist',
			'foreignKey' => 'band_id',
			'dependent' => true,
		),
		'RadioStationRawData' => array(
			'className' => 'RadioStationRawData',
			'foreignKey' => 'band_id',
			'dependent' => true,
		),
	);
	
	var $belongsTo = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);


	var $hasAndBelongsToMany = array(
		'SubGenre' => array(
			'className' => 'SubGenre',
			'joinTable' => 'band_sub_genres',
			'with' => 'band_sub_genres',
			'foreignKey' => 'band_id',
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
		'Violation' => array(
			'className' => 'Violation',
			'joinTable' => 'band_violations',
			'foreignKey' => 'band_id',
			'associationForeignKey' => 'violation_id',
			'unique' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
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
		
		$this->stateCheck($condition, $data);
		$this->countryCheck($condition, $data);
		$this->cityCheck($condition, $data);
		
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
	
	function stateCheck(&$condition, $data){
		if(isset($data['state']) && !empty($data['state'])){
			$condition[$this->alias.'.state_id'] = $data['state'];
		}
	}
	
	function countryCheck(&$condition, $data){
		if(isset($data['country']) && !empty($data['country'])){
			$condition[$this->alias.'.country_id'] = $data['country'];
		}
	}
	
	function cityCheck(&$condition, $data){
		if(isset($data['city']) && !empty($data['city'])){
			$condition[$this->alias.'.city_id'] = $data['city'];
		}
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
	
	
	function add_genre($band_id = 0, $genre_id = 0){
		if(!$band_id || !$genre_id){
			return false;
		}
		$result = $this->find('first', array(
			'conditions' => array(
			   $this->alias.'.id'=>$band_id,
			)
		));
		foreach($result['SubGenre'] as $genre){
			if($genre['id'] == $genre_id){
			  return true;  
			}
		}
		$result['SubGenre']['id'] = $genre_id;
		return $this->save($result);
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

	function process_file($file = Null){
		set_time_limit('15000');
		if($file){
			$file_handle = fopen($file['tmp_name'], "r");
			while(!feof($file_handle)){
				$line = fgetcsv($file_handle);
				$loc = $this->get_location($this->cleanIt($line[4]));
				if($loc['type'] == 'state'){
					$band['state_id'] = $loc['loc'];
					$band['country_id'] = $loc['country'];
				} elseif($loc['type'] == 'country' && !empty($loc['loc'])) {
					$band['country_id'] = $loc['loc'];
				}
				$band['name'] = $this->cleanIt($line[0]);
				$this->recursive = -1;
				$band = $this->add($band, 'name', false);
				if($band){
					$label_model = ClassRegistry::init('Label');
					unset($label);
					$label['name'] = $this->cleanIt($line[2]);
					$label = $label_model->add($label, 'name', false);
					$label_model->recursive	= -1;
					
					$genre_model = ClassRegistry::init('SubGenre');
					unset($genre);
					$genre = $this->fixGenre($line[3]);
					$genre_model->recursive	= -1;
					$genre = $genre_model->getSubGenre($this->cleanIt($genre));
					$album_model = ClassRegistry::init('Album');
					unset($album);
					$album = array('name'=>$this->cleanIt($line[1]),'band_id'=>$band['Band']['id'], 'label_id'=>$label['Label']['id'], 'sub_genre_for_charting' => $genre['SubGenre']['id']);
					$album = $album_model->add($album, 'name', false);
					$poo = $album_model->add_genre($album['Album']['id'], $genre['SubGenre']['id']);
				}
			}
			fclose($file_handle);
		}
		return false;
	}
	
	function fixGenre($genre){
		if($genre == 'TRUECOUNTRY'){
			return 'TRUE COUNTRY';
		}
		if($genre == 'COWBOYWESTERN'){
			return 'COWBOY WESTERN';
		}
		if($genre == 'POPCOUNTRY'){
			return 'POP COUNTRY';
		}
		if($genre == 'OTHER'){
			return 'UNKNOWN';
		}
		if($genre == 'ROCK'){
			return 'ROOTS ROCK';
		}
		if($genre == 'COUNTRY'){
			return 'ROOTS/AMERICANA COUNTRY';
		}
		if($genre == 'HIPHOPRNB'){
			return 'Hip Hop/R&B';
		}
		if($genre == 'HARDROCK'){
			return 'HARD ROCK';
		}
		if($genre == 'ALTROCK'){
			return 'Alternative Rock';
		}
		
		return $genre;
	}
	
	function cleanIt($string){
		return $this->replaceComma(ucwords(strtolower(trim($string))));
	}
	
	function replaceComma($value){
		return str_replace('%',',',$value);
	}
	

	function get_location($loc = Null){
		if(!$loc){
			return false;
		}
		$location = array();
		$state_model = ClassRegistry::init('State');
		$state = $state_model->findByName($loc);
		if (!$state) {
			$state = $state_model->findByAbbrv($loc);
		}
		$location['type'] = '';
		$location['loc'] = '';
		$location['country'] = '';
		
		if ($state) {
			$location['type'] = 'state';
			$location['loc'] = $state['State']['id'];
			$location['country'] = $state['State']['country_id'];
		} else {
			$country_model = ClassRegistry::init('Country');
			$country = $country_model->findByName($loc);
			if($country){
				$location['type'] = 'country';
				$location['loc'] = $country['Country']['id'];
			}
		}
		return $location;
	}

	function merge($merge_to, $delete){
		$this->Behaviors->attach('Containable');
		$original = $this->find('first',array(
			'conditions' => array(
				'Band.id' => $merge_to
			),
			'contain'=>array(
				'Album.Label',
				'Album.AlbumStat',
				'Album.Song.SubGenre.Genre',
				'Song.RadioStationPlaylist',
				'Song.RadioStaffPlaylist',
				'Song.SongStat',
				'RadioStaffPlaylist',
				'RadioStationPlaylist',
				'RadioStationRawData'
			),
		));
		$delete = $this->find('first',array(
			'conditions' => array(
				'Band.id' => $delete
			),
			'contain'=>array(
				'Album.Label',
				'Album.AlbumStat',
				'Song.SubGenre.Genre',
				'Song.RadioStationPlaylist',
				'Song.RadioStaffPlaylist',
				'Song.SongStat',
				'RadioStaffPlaylist',
				'RadioStationPlaylist',
				'RadioStationRawData'
			),
		));
		$this->combine($original, $delete);
		
		return $original;
	}

	function combine($to_keep, $delete){
		$album_model = ClassRegistry::init('Album');
		$song_model = ClassRegistry::init('Song');
		$radio_play_model = ClassRegistry::init('RadioStationPlaylist');
		$genres = array();
		
		foreach($delete['Song'] as $dsong){
			foreach($to_keep['Song'] as $ksong){
				if(strtolower($dsong['name']) == strtolower($ksong['name'])){
					$this->Song->combine($ksong, $dsong);
				}
			}		
		}
		
		foreach($delete['Album'] as $dalbum){
			foreach($to_keep['Album'] as $kalbum){
				if(strtolower($dalbum['name']) == strtolower($kalbum['name'])){
					$this->Album->combine($kalbum, $dalbum);
				}
			}		
		}
				
		$this->updateAllPlaylist($delete, $to_keep, 'RadioStaffPlaylist');
		$this->updateAllPlaylist($delete, $to_keep, 'RadioStationPlaylist');
		
		$this->updateAllOther($delete['Band']['id'], $to_keep['Band']['id'], 'Song');
		$this->updateAllOther($delete['Band']['id'], $to_keep['Band']['id'], 'Album');
		$this->updateAllOther($delete['Band']['id'], $to_keep['Band']['id'], 'BandSubGenre');
		
		$this->delete($delete['Band']['id']);
		
		return $delete;
	}
	
	function updateAllPlaylist($delete, $to_keep, $model_name){
		$model = ClassRegistry::init($model_name);
		if(!empty($delete[$model_name])){
			foreach($delete[$model_name] as $d){
				foreach($to_keep[$model_name] as $k){
					if(($d['band_id'] != $k['band_id'])	&& ($d['album_id'] == $k['album_id']) && ($d['song_id'] == $k['song_id'])){
						$k['spins'] = $d['spins'] + $k['spins'];
						$model->save($k);
						$model->delete($d['id']);
					} else {
						$d['band_id'] = $k['band_id'];
						$model->save($d);
					}
				}		
			}
		}
	}
	
	function updateAllOther($id, $new_id, $model_name){
		$model = ClassRegistry::init($model_name);
		$entries = $model->find('all', array(
			'conditions' => array(
				'band_id' => $id
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