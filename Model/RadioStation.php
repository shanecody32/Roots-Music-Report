<?php
class RadioStation extends AppModel {
	var $name = 'RadioStation';
	var $displayField = 'name';
	
	var $file_types = array('.csv');
	
	public $actsAs = array('Search.Searchable');
	
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter the station or show name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter the station or show name.',
			),
		),
	); 
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $hasOne = array(
		'RadioInternetDetail' => array(
			'className' => 'RadioInternetDetail',
			'foreignKey' => 'radio_station_id',
		),
		'RadioSatelliteDetail' => array(
			'className' => 'RadioSatelliteDetail',
			'foreignKey' => 'radio_station_id',
		),
		'RadioSyndicatedDetail' => array(
			'className' => 'RadioSyndicatedDetail',
			'foreignKey' => 'radio_station_id',
		),
		'RadioTerrestrialDetail' => array(
			'className' => 'RadioTerrestrialDetail',
			'foreignKey' => 'radio_station_id',
		)
	);


	var $hasMany = array(
		'RadioAddress' => array(
			'className' => 'RadioAddress',
			'foreignKey' => 'radio_station_id',
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
		'RadioEmail' => array(
			'className' => 'RadioEmail',
			'foreignKey' => 'radio_station_id',
		),
		'RadioLink' => array(
			'className' => 'RadioLink',
			'foreignKey' => 'radio_station_id',
		),
		'RadioPhoneNumber' => array(
			'className' => 'RadioPhoneNumber',
			'foreignKey' => 'radio_station_id',
		),
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'foreignKey' => 'radio_station_id',
		),
		'RadioStationImage' => array(
			'className' => 'RadioStationImage',
			'foreignKey' => 'radio_station_id',
		),
		'RadioStationPlaylist' => array(
			'className' => 'RadioStationPlaylist',
			'foreignKey' => 'radio_station_id',
		),
		'RadioStationPlaylistArchive' => array(
			'className' => 'RadioStationPlaylistArchive',
			'foreignKey' => 'radio_station_id',
		),
		'RadioStationRawData' => array(
			'className' => 'RadioStationRawData',
			'foreignKey' => 'radio_station_id',
		)
	);
	
	var $hasAndBelongsToMany = array(
		'SubGenre' => array(
			'className' => 'SubGenre',
			'joinTable' => 'radio_station_sub_genres',
			'foreignKey' => 'radio_station_id',
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
		'Genre' => array(
			'className' => 'Genre',
			'joinTable' => 'radio_station_genres',
			'foreignKey' => 'radio_station_id',
			'associationForeignKey' => 'genre_id',
			'unique' => true,

		),
	);
	
	var $filterArgs = array(
		array('name' => 'search', 'type'=>'query', 'method'=>'filterSearch'),
		array('name' => 'sub_genres', 'type' => 'subquery', 'field'=>'RadioStation.id', 'method'=>'filterGenre'),
		array('name' => 'genres', 'type' => 'subquery', 'field'=>'RadioStation.id', 'method'=>'filterGenre'),
		array('name' => 'country', 'type' => 'subquery', 'field'=>'RadioStation.id', 'method'=>'filterCountry'),
		array('name' => 'state', 'type' => 'subquery', 'field'=>'RadioStation.id', 'method'=>'filterState'),
		array('name' => 'city', 'type' => 'subquery', 'field'=>'RadioStation.id', 'method'=>'filterCity'),
		array('name' => 'status', 'type' => 'subquery', 'field'=>'RadioStation.id', 'method'=>'filterStatus'),
		array('name' => 'not_approved', 'type'=>'query', 'method'=>'filterSearch', 'field'=>'!'),
	);
		
	function filterSearch($data, $field = null){
		if(empty($data['search']) && empty($data['sub_genre']) && empty($data['genre'])){
			return array();
		}
		
		if($data['starts_with'] == 1){
			$condition = array($this->alias.'.'.$data['field'].' LIKE' => trim($data['search'])."%");
		} elseif($data['exact'] == 1) {
			$condition = array($this->alias.'.'.$data['field'] => trim($data['search']));
		} else {
			$condition = array($this->alias.'.'.$data['field'].' LIKE' => "%".trim($data['search'])."%");
		}
		
		if(isset($data['not_approved']) || isset($data['approved'])){
			if($data['not_approved'] && $data['approved']){
				$condition[0] = '0';
			} elseif($data['approved']){
				$condition[$this->alias.'.approved'] = '1';
			} elseif($data['not_approved']){
				$condition[$this->alias.'.approved'] = '0';
			}
		}
		
		$search = array(
			'OR' => array(
				 $condition,
			)
		);
		return $search;
	}
	
	function filterGenre($data){
		if(!empty($data['sub_genres'])){
			return $this->getBySubGenre($data);
		} else {
			return $this->getByGenre($data);
		}
	}
	
	function filterCountry($data){
		$sub_genre_model = ClassRegistry::init('RadioAddress');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioAddress.country_id'  => $data['country']), 
			'fields' => array('RadioAddress.radio_station_id'),
        ));		
		return $query;
	}
	
	function filterState($data){
		$sub_genre_model = ClassRegistry::init('RadioAddress');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioAddress.state_id'  => $data['state']), 
			'fields' => array('RadioAddress.radio_station_id'),
        ));		
		return $query;
	}
	
	function filterCity($data){
		$sub_genre_model = ClassRegistry::init('RadioAddress');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioAddress.city_id'  => $data['city']), 
			'fields' => array('RadioAddress.radio_station_id'),
        ));		
		return $query;
	}
	function filterApproved(){
		if(!empty($data['not_approved'])){
			$condition[$this->alias.'.approved'] = 0;
		
			return $this->getQuery('all', array(
				'conditions' => array(
					'OR' => array(
						$condition,
					)
				), 
				'fields' => array('RadioStation.id'),
			));
		}
	
	}
	function filterStatus($data){
		$condition = array();
		
		
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
		$search = array(
			
		);
		$query = $this->getQuery('all', array(
			'conditions' => array(
				'OR' => array(
					$condition,
				)
			), 
			'fields' => array('RadioStation.id'),
        ));
		
		return $query;
	}
	
	function getBySubGenre($data){
		$sub_genre_model = ClassRegistry::init('RadioStationSubGenre'); // load join model, the HABTM relationship model
//		$sub_genre_model->Behaviors->attach('Containable', array('autoFields' => false)); // additional containable info if needed
        $sub_genre_model->Behaviors->attach('Search.Searchable'); // set join model to behavior searchable
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStationSubGenre.sub_genre_id'  => $data['sub_genres']), // field needed to find, selecting the appropriate join table
//			'contain' => array('SubGenre'), // additional containable info if needed
			'fields' => array('RadioStationSubGenre.radio_station_id'), // the field the object you are filtering belongs to
        ));
		return $query;
	}
	
	function getByGenre($data){
		$sub_genre_model = ClassRegistry::init('RadioStationGenre');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStationGenre.genre_id'  => $data['genres']), 
			'fields' => array('RadioStationGenre.radio_station_id'),
        ));		
		return $query;	
	}
	
	/*
	radio station = name - type
	*/
	
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
			$i = 0;
			$data = array();
			$country_model = ClassRegistry::init('Country');
			$staffdata = array();
			while(!feof($file_handle)){
				$line = fgetcsv($file_handle);
				$country = $country_model->findByName($this->cleanIt($line[12]));
				$data['RadioStation']['type'] = $line[0];
				$data['RadioStation']['name'] = trim($line[1]);
				$data['RadioLink'][0]['link'] = trim($line[13]);
				$data['RadioEmail'][0]['email'] = trim($line[4]);
				$data['RadioTerrestrialDetail']['call_letters'] = strtoupper($this->cleanIt($line[1]));
				$data['RadioPhoneNumber'][0]['phone'] = $this->cleanPhoneNumber($line[5]);
				$data['RadioAddress'][0]['country_id'] = $country['Country']['id'];
				$data['RadioAddress'][0]['address_1'] = $this->cleanIt($line[6]);
				$data['RadioAddress'][0]['address_2'] = $this->cleanIt($line[7]);
				$data['RadioAddress'][0]['address_3'] = $this->cleanIt($line[8]);
				$data['RadioAddress'][0]['city'] = $this->cleanIt($line[9]);
				$data['RadioAddress'][0]['state'] = $this->cleanIt($line[10]);
				$data['RadioAddress'][0]['zip'] = trim($line[11]);
				$staffdata['RadioStaffAddress'][0]['attention_to'] = trim($line[2])." ".trim($line[3]);
				$radio = $this->add($data);
				//echo $radio['RadioStation']['id']."<hr />";
				if($radio){
					
					$staffdata['RadioStaffMember']['radio_station_id'] = $radio['RadioStation']['id'];
					$staffdata['RadioStaffMember']['orig_username'] = trim($line[1]);
					$staffdata['RadioStaffMember']['first_name'] = trim($line[2]);
					$staffdata['RadioStaffMember']['last_name'] = trim($line[3]);
					$staffdata['RadioStaffLink'][0]['link'] = trim($line[13]);
					$staffdata['RadioStaffMember']['email'] = trim($line[4]);
					$staffdata['RadioStaffPhoneNumber'][0]['phone'] = $this->cleanPhoneNumber($line[5]);
					$staffdata['RadioStaffAddress'][0]['address_1'] = $this->cleanIt($line[6]);
					$staffdata['RadioStaffAddress'][0]['address_2'] = $this->cleanIt($line[7]);
					$staffdata['RadioStaffAddress'][0]['address_3'] = $this->cleanIt($line[8]);
					$staffdata['RadioStaffAddress'][0]['city_id'] = $radio['RadioAddress'][0]['city_id'];
					$staffdata['RadioStaffAddress'][0]['state_id'] = $radio['RadioAddress'][0]['state_id'];
					$staffdata['RadioStaffAddress'][0]['country_id'] = $radio['RadioAddress'][0]['country_id'];
					$staffdata['RadioStaffAddress'][0]['postal_code_id'] = $radio['RadioAddress'][0]['postal_code_id'];
					$staffdata['RadioStaffAddress'][0]['attention_to'] = $staffdata['RadioStaffMember']['first_name']. " " .$staffdata['RadioStaffMember']['last_name'];
					$staffdata['RadioStaffLink'][0]['type'] = 'website';
					$staffdata['RadioStaffPhoneNumber'][0]['type'] = 'primary';
					$staffdata['RadioStaffEmail'][0]['type'] = 'primary';
					$staff_model = ClassRegistry::init('RadioStaffMember');
					$staff_model->saveAll($staffdata, array('validate' => false));
				}
				unset($data);
				unset($staffdata);
			}
			fclose($file_handle);
			
		}
		return false;
	}
	
	function cleanIt($string){
		return $this->replaceComma(ucwords(strtolower(trim($string))));
	}
	
	function replaceComma($value){
		return str_replace('%',',',$value);
	}
	

	function finalise_toggle($id = 0){
		if(!$id){
			return false;
		}
		$radio = $this->findById($id);
		if($radio['RadioStation']['playlist_finalised'])
			$radio['RadioStation']['playlist_finalised'] = 0;
		else
			$radio['RadioStation']['playlist_finalised'] = 1;
		return $this->save($radio);
	}
	
	function reported_toggle($id, $switch = true){
		$radio = $this->findById($id);
		if($switch == true && $radio['RadioStation']['reported'] == 0){
			$radio['RadioStation']['reported'] = 1;
			return $this->save($radio);
		}
		
		if($switch == false && $radio['RadioStation']['reported'] == 1){
			$radio['RadioStation']['reported'] = 0;
			return $this->save($radio);
		}
	}
	
	function setData(&$data){
		$data['RadioLink'][0]['link'] = str_replace('http://', 'www.', $data['RadioLink'][0]['link']);
		$data['RadioLink'][0]['link'] = str_replace('www.', '', $data['RadioLink'][0]['link']);
		$data['RadioLink'][0]['link'] = 'http://www.' . $data['RadioLink'][0]['link'];

		switch ($data['RadioStation']['type']) {
			case 'terrestrial':
				unset($data['RadioInternetDetail']);
				unset($data['RadioSyndicatedDetail']);
				unset($data['RadioSatelliteDetail']);
				break;
			case 'internet':
				unset($data['RadioTerrestrialDetail']);
				unset($data['RadioSyndicatedDetail']);
				unset($data['RadioSatelliteDetail']);
				break;
			case 'syndicated':
				unset($data['RadioTerrestrialDetail']);
				unset($data['RadioInternetDetail']);
				unset($data['RadioSatelliteDetail']);
				break;
			case 'satellite':
				unset($data['RadioTerrestrialDetail']);
				unset($data['RadioInternetDetail']);
				unset($data['RadioSyndicatedDetail']);
				break;
		} 
		
		$data['RadioLink'][0]['type'] = 'website';
		$data['RadioPhoneNumber'][0]['type'] = 'primary';
		$data['RadioPhoneNumber'][0]['phone'] = $this->cleanPhoneNumber($data['RadioPhoneNumber'][0]['phone']);
		$data['RadioEmail'][0]['type'] = 'primary';		
		
		if (!empty($data['RadioAddress'][0]['state'])) {
			$state_model = ClassRegistry::init('State');
			$state['name'] = $data['RadioAddress'][0]['state'];
			$state['country_id'] = $data['RadioAddress'][0]['country_id'];
			$state = $state_model->add($state, 'name');
			$data['RadioAddress'][0]['state_id'] = $state['State']['id'];
		} else {
			$data['RadioAddress'][0]['state_id'] = 0;
		}
		
		
		if ($data['RadioAddress'][0]['zip']) {
			$postal_code_model = ClassRegistry::init('PostalCode');
			$postal = array();
			$postal['PostalCode'] = array('zip' => $data['RadioAddress'][0]['zip'], 'state_id'=>$data['RadioAddress'][0]['state_id'], 'country_id'=>$data['RadioAddress'][0]['country_id']);
			$postal_code = $postal_code_model->add(
				$postal,
				'code'
			);
			
			$data['RadioAddress'][0]['postal_code_id'] = $postal_code['PostalCode']['id'];
		}
		
		if ($data['RadioAddress'][0]['city']) {
			$city_model = ClassRegistry::init('City');
			$city = array();
			$city['PostalCode'] = array('city' => $data['RadioAddress'][0]['city'], 'state_id'=>$data['RadioAddress'][0]['state_id'], 'country_id'=>$data['RadioAddress'][0]['country_id']);
			$city = $city_model->add(
				$city,
				'name'
			);
			$data['RadioAddress'][0]['city_id'] = $city['City']['id'];
		}
		/* problem with save
		if ($data['RadioAddress'][0]['city']) {
			$city_model = ClassRegistry::init('City');
			$data['RadioAddress'][0]['city_id'] = $city_model->add(
				$data['RadioAddress'][0]['city'],
				$data['RadioAddress'][0]['state_id'], 
				$data['RadioAddress'][0]['country_id']
			);
		} */
		if (isset($data['RadioAddress'][0]['city_id']) && isset($data['RadioAddress'][0]['postal_code_id'])){
			$city_code_join_model = ClassRegistry::init('CityPostalCode');
			$city_code_join_model->add($data['RadioAddress'][0]['city_id'], $data['RadioAddress'][0]['postal_code_id']);
		}		
	}
	
	
	
	function merge($merge_to, $delete){
		$this->Behaviors->attach('Containable');
		$original = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.id' => $merge_to
			),
			'contain'=>array(
				'RadioStationPlaylist',
				'RadioStaffMember',
				'RadioStationImage',
				'RadioPhoneNumber',
				'RadioAddress',
				'RadioLink',
				'RadioEmail'
			),
		));
		$delete = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.id' => $delete
			),
			'contain'=>array(
				'RadioStationPlaylist',
				'RadioStaffMember',
				'RadioStationImage',
				'RadioPhoneNumber',
				'RadioAddress',
				'RadioLink',
				'RadioEmail'
			),
		));
		$delete = $this->combine($original, $delete);
		
		$this->delete($delete['RadioStation']['id']);
		return $original;
	}

	function combine($original, $delete){
		
		$radio_playlist_model = ClassRegistry::init('RadioStationPlaylist');
		$playlists = $radio_playlist_model->find('all', array(
			'conditions'=> array(
				'radio_station_id' => $delete['RadioStation']['id']
			)
		));
		foreach($playlists as $list){
			$radio_playlist_model->update_entry($list['RadioStationPlaylist']['id'], $list['RadioStationPlaylist']['band_id'], $list['RadioStationPlaylist']['Album_id'], $list['RadioStationPlaylist']['song_id'],$original['RadioStation']['id']);
		}
		
		$this->update_model('RadioStaffMember', $original['RadioStation']['id'], $delete['RadioStation']['id']);
		$this->update_model('RadioStationImage', $original['RadioStation']['id'], $delete['RadioStation']['id']);
		$this->update_model('RadioPhoneNumber', $original['RadioStation']['id'], $delete['RadioStation']['id']);
		$this->update_model('RadioAddress', $original['RadioStation']['id'], $delete['RadioStation']['id']);
		$this->update_model('RadioLink', $original['RadioStation']['id'], $delete['RadioStation']['id']);
		$this->update_model('RadioEmail', $original['RadioStation']['id'], $delete['RadioStation']['id']);
		
		return $delete;
	}

	function update_model($model = null, $id = 0, $delete_id = 0){
		$model_container = ClassRegistry::init($model);
		$entries = $model_container->find('all', array(
			'conditions'=> array(
				Inflector::underscore($this->name).'_id' => $delete_id
			)
		));
		foreach($entries as $entry){
			$entry[$model][Inflector::underscore($this->name).'_id'] = $id;
			$model_container->save($entry);
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