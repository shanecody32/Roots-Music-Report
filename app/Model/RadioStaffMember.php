<?php
class RadioStaffMember extends AppModel {
	var $name = 'RadioStaffMember';
	var $displayField = 'on_air_name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $file_types = array('.csv');
	
	public $actsAs = array('Search.Searchable');
	
	var $belongsTo = array(
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foreignKey' => 'radio_station_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'RadioStaffPlaylist' => array(
			'className' => 'RadioStaffPlaylist',
			'foreignKey' => 'radio_staff_member_id',
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
		'RadioStaffAddress' => array(
			'className' => 'RadioStaffAddress',
			'foreignKey' => 'radio_staff_member_id',
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
		'RadioStaffPhoneNumber' => array(
			'className' => 'RadioStaffPhoneNumber',
			'foreignKey' => 'radio_staff_member_id',
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
		'RadioStaffPlaylistArchive' => array(
			'className' => 'RadioStaffPlaylistArchive',
			'foreignKey' => 'radio_staff_member_id',
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
		'RadioStaffLink' => array(
			'className' => 'RadioStaffLink',
			'foreignKey' => 'radio_staff_member_id',
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
		'RadioStaffImage' => array(
			'className' => 'RadioStaffImage',
			'foreignKey' => 'radio_staff_member_id',
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
	
	var $hasAndBelongsToMany = array(
		'Violation' => array(
			'className' => 'Violation',
			'joinTable' => 'radio_staff_member_violations',
			'foreignKey' => 'radio_staff_member_id',
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
		'SubGenre' => array(
			'className' => 'SubGenre',
			'foreignKey' => 'radio_staff_member_id',
			'joinTable' => 'radio_staff_member_sub_genres',
			'associationForeignKey' => 'sub_genre_id',
			'unique' => true,
		),
	);
	
	var $validate = array(
		'first_name' => array(
			'alphanumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'You must enter a first name using only Alphanumeric Characters',
				'allowEmpty' => false,
				'required' => true,
			)
		),
		'last_name' => array(
			'alphanumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'You must enter a first name using only Alphanumeric Characters',
				'allowEmpty' => false,
				'required' => true,
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
			)
		)
	); 
	
	var $filterArgs = array(
		array('name' => 'first_name', 'type'=>'query', 'method'=>'filterSearch', 'allowEmpty' => true),
		array('name' => 'sub_genres', 'type' => 'subquery', 'field'=>'RadioStaffMember.id', 'method'=>'filterGenre'),
		array('name' => 'genres', 'type' => 'subquery', 'field'=>'RadioStaffMember.id', 'method'=>'filterGenre'),
		array('name' => 'country', 'type' => 'subquery', 'field'=>'RadioStaffMember.id', 'method'=>'filterCountry'),
		array('name' => 'state', 'type' => 'subquery', 'field'=>'RadioStaffMember.id', 'method'=>'filterState'),
		array('name' => 'city', 'type' => 'subquery', 'field'=>'RadioStaffMember.id', 'method'=>'filterCity'),
		//array('name' => 'status', 'type' => 'subquery', 'field'=>'RadioStaffMember.id', 'method'=>'filterStatus'),
		//array('name' => 'not_approved', 'type'=>'query', 'method'=>'filterSearch', 'field'=>'!'),
	);
		
	function filterSearch($data, $field = null){
		
			
		if(!empty($data['first_name']) && !empty($data['last_name'])){
			if($data['starts_with'] == 1){
				$condition = array(
					$this->alias.'.first_name LIKE' => trim($data['first_name'])."%",
					$this->alias.'.last_name LIKE' => trim($data['last_name'])."%",
				);
			} elseif($data['exact'] == 1) {
				$condition = array(
					$this->alias.'.first_name' => trim($data['first_name']),
					$this->alias.'.last_name' => trim($data['last_name']))
				;
			} else {
				$condition = array(
					$this->alias.'.first_name LIKE' => "%".trim($data['first_name'])."%",
					$this->alias.'.last_name LIKE' => "%".trim($data['last_name'])."%"
				);
			}
		} elseif(!empty($data['first_name'])){
			if($data['starts_with'] == 1){
				$condition = array($this->alias.'.first_name LIKE' => trim($data['first_name'])."%");
			} elseif($data['exact'] == 1) {
				$condition = array($this->alias.'.first_name' => trim($data['first_name']));
			} else {
				$condition = array($this->alias.'.first_name LIKE' => "%".trim($data['first_name'])."%");
			}
		} elseif(!empty($data['last_name'])){
			if($data['starts_with'] == 1){
				$condition = array($this->alias.'.last_name LIKE' => trim($data['last_name'])."%");
			} elseif($data['exact'] == 1) {
				$condition = array($this->alias.'.last_name' => trim($data['last_name']));
			} else {
				$condition = array($this->alias.'.last_name LIKE' => "%".trim($data['last_name'])."%");
			}
		}
		
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
		if(isset($condition)){
			$search = array(
				'OR' => array(
					 $condition,
				)
			);
			return $search;
		} else { return array(); }
	}
	
	function filterGenre($data){
		if(!empty($data['sub_genres'])){
			return $this->getBySubGenre($data);
		} else {
			return $this->getByGenre($data);
		}
	}
	
	function filterCountry($data){
		$sub_genre_model = ClassRegistry::init('RadioStaffAddress');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStaffAddress.country_id'  => $data['country']), 
			'fields' => array('RadioStaffAddress.radio_staff_member_id'),
        ));		
		return $query;
	}
	
	function filterState($data){
		$sub_genre_model = ClassRegistry::init('RadioStaffAddress');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStaffAddress.state_id'  => $data['state']), 
			'fields' => array('RadioStaffAddress.radio_staff_member_id'),
        ));		
		return $query;
	}
	
	function filterCity($data){
		$sub_genre_model = ClassRegistry::init('RadioStaffAddress');
        $sub_genre_model->Behaviors->attach('Search.Searchable'); 
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStaffAddress.city_id'  => $data['city']), 
			'fields' => array('RadioStaffAddress.radio_staff_member_id'),
        ));		
		return $query;
	}
	
	function getBySubGenre($data){
		$sub_genre_model = ClassRegistry::init('RadioStaffMemberSubGenre'); // load join model, the HABTM relationship model
//		$sub_genre_model->Behaviors->attach('Containable', array('autoFields' => false)); // additional containable info if needed
        $sub_genre_model->Behaviors->attach('Search.Searchable'); // set join model to behavior searchable
		$query = $sub_genre_model->getQuery('all', array(
			'conditions' => array('RadioStaffMemberSubGenre.sub_genre_id'  => $data['sub_genres']), // field needed to find, selecting the appropriate join table
//			'contain' => array('SubGenre'), // additional containable info if needed
			'fields' => array('RadioStaffMemberSubGenre.radio_staff_member_id'), // the field the object you are filtering belongs to
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
			
			while(!feof($file_handle)){
				$line = fgetcsv($file_handle);
				$country = $country_model->findByName($this->cleanIt($line[11]));
				$data['RadioStation']['type'] = $line[13];
				$data['RadioStation']['name'] = trim($line[0]);
				$data['RadioLink'][0]['link'] = trim($line[12]);
				$data['RadioEmail'][0]['email'] = trim($line[3]);
				$data['RadioTerrestrialDetail']['call_letters'] = strtoupper($this->cleanIt($line[0]));
				$data['RadioInternetDetail']['hits'] = 0; 
				$data['RadioSyndicatedDetail']['stations_playing'] = 0;
				$data['RadioSatelliteDetail']['service_provider'] = 0;
				$data['RadioPhoneNumber'][0]['phone'] = trim($line[4]);
				$data['RadioAddress'][0]['country_id'] = $country['Country']['id'];
				$data['RadioAddress'][0]['address_1'] = $this->cleanIt($line[5]);
				$data['RadioAddress'][0]['address_2'] = $this->cleanIt($line[6]);
				$data['RadioAddress'][0]['address_3'] = $this->cleanIt($line[7]);
				$data['RadioAddress'][0]['city'] = $this->cleanIt($line[8]);
				$data['RadioAddress'][0]['state'] = $this->cleanIt($line[9]);
				$data['RadioAddress'][0]['zip'] = trim($line[10]);
				$this->add($data);
				unset($data);
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
		if($radio['RadioStaffMember']['playlist_finalised'])
			$radio['RadioStaffMember']['playlist_finalised'] = 0;
		else
			$radio['RadioStaffMember']['playlist_finalised'] = 1;
		return $this->save($radio);
	}
	
	function reported_toggle($id, $switch = true){
		$radio = $this->findById($id);
		if($switch == true && $radio['RadioStaffMember']['reported'] == 0){
			$radio['RadioStaffMember']['reported'] = 1;
			return $this->save($radio);
		}

		if($switch == false && $radio['RadioStaffMember']['reported'] == 1){
			$radio['RadioStaffMember']['reported'] = 0;
			return $this->save($radio);
		}
	}

	function get_user_notes($id){
	
	}
	
	// created to parse staff violations, and to act as switch for specific user notes
	function get_staff_notes($staff){
		$notes = array(
			'applied' 	=> false,
			'approved' 	=> false,
			'verified' 	=> false,
		);
		
		if($staff[$this->alias]['applied']){
			$notes['applied'] = true;
		}
		if($staff[$this->alias]['approved']){
			$notes['approved'] = true;
		}
		if($staff[$this->alias]['verified']){
			$notes['verified'] = true;
		}

		return $notes;
	}
	
	function add($user_id, $radio_id, $position){
		$user_model = ClassRegistry::init('User');
		$user = $user_model->findById($user_id);
		$data[$this->alias]['user_id'] = $user_id;
		$data[$this->alias]['first_name'] = $user['UserDetail']['first_name'];
		$data[$this->alias]['last_name'] = $user['UserDetail']['last_name'];
		$data[$this->alias]['email'] = $user['UserDetail']['email'];
		$data[$this->alias]['applied'] = 1;
		$data[$this->alias]['station_control'] = 1;
		$data[$this->alias]['radio_station_id'] = $radio_id;
		$data[$this->alias]['position'] = $position;
		return $this->save($data);	
	}
	
	function addViolation($id, $v_id){
		$data[$this->alias]['id'] = $id;
		$data[$this->alias]['violation_id'] = $v_id;
		return $this->save($data);
	}
	


}
?>