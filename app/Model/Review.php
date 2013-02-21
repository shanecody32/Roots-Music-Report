<?php
class Review extends AppModel {
	var $name = 'Review';
	var $displayField = 'review';
	var $validate = array(
		'review' => array(
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

	var $belongsTo = array(
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
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
		'SubGenre' => array(
			'className' => 'SubGenre',
			'foreignKey' => 'sub_genre_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	
	var $filterArgs = array(
		array('name' => 'band_name', 'type'=>'query', 'method'=>'filterSearch', 'allowEmpty' => true),
		array('name' => 'sub_genres', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterGenre'),
		//array('name' => 'genres', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterGenre'),
		//array('name' => 'country', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterCountry'),
		//array('name' => 'state', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterState'),
		//array('name' => 'city', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterCity'),
		//array('name' => 'status', 'type' => 'subquery', 'field'=>'Band.id', 'method'=>'filterStatus'),
		//array('name' => 'not_approved', 'type'=>'query', 'method'=>'filterSearch', 'field'=>'!'),
	);
		
	function filterSearch($data, $field = null){
		if(!empty($data['band_name']) && !empty($data['album_name'])){
			if($data['starts_with'] == 1){
				$condition = array(
					'Band.name LIKE' => trim($data['band_name'])."%",
					'Album.name LIKE' => trim($data['album_name'])."%",
				);
			} elseif($data['exact'] == 1) {
				$condition = array(
					'Band.name' => trim($data['band_name']),
					'Album.name' => trim($data['album_name']))
				;
			} else {
				$condition = array(
					'Band.name LIKE' => "%".trim($data['band_name'])."%",
					'Album.name LIKE' => "%".trim($data['album_name'])."%"
				);
			}
		} elseif(!empty($data['band_name'])){
			if($data['starts_with'] == 1){
				$condition = array('Band.name LIKE' => trim($data['band_name'])."%");
			} elseif($data['exact'] == 1) {
				$condition = array('Band.name' => trim($data['band_name']));
			} else {
				$condition = array('Band.name LIKE' => "%".trim($data['band_name'])."%");
			}
		} elseif(!empty($data['album_name'])){
			if($data['starts_with'] == 1){
				$condition = array('Album.name LIKE' => trim($data['album_name'])."%");
			} elseif($data['exact'] == 1) {
				$condition = array('Album.name' => trim($data['album_name']));
			} else {
				$condition = array('Album.name LIKE' => "%".trim($data['album_name'])."%");
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
	
	
	function create_review($data = null){
		$error = false;
		$band_model = ClassRegistry::init('Band');

		$band = $band_model->add($data['Band'], 'name');
		if(!$band){
			$error = true;
		}
		
		if(isset($data['Album']['compilation']) && $data['Album']['compilation']){
			$band_id = 1;
		} elseif(isset($data['Album']['soundtrack']) && $data['Album']['soundtrack']){
			$band_id = 2;
		} else {
			$band_id = $band['Band']['id'];
		}
		$band_link_model = ClassRegistry::init('BandLink');
		$data['BandLink']['band_id'] = $band_id;
		$band = $band_link_model->add($data['BandLink'], array('band_id','link'));
		
		$label_model = ClassRegistry::init('Label');
		$label = $label_model->add($data['Label'], 'name');
				
		$data['Album']['band_id'] = $band_id;
		$data['Album']['label_id'] = $label['Label']['id'];

		$album_model = ClassRegistry::init('Album');
		$album = $album_model->add($data['Album'], array('name','band_id'));
		if(!$album['Album']['sub_genre_for_charting']){
			$album['Album']['sub_genre_for_charting'] = $data['Review']['sub_genre_id'];
			$album_model->save($album);
		}

		$album_stat_model = ClassRegistry::init('AlbumStat');
		$aStat['album_id'] = $album['Album']['id'];
		if(!$album_stat_model->add($aStat, 'album_id')){
			echo 'Error AlbumStat';
		}
			
		$band_model->add_genre($band['Band']['id'],$data['Review']['sub_genre_id']);
		$album_model->add_genre($album['Album']['id'],$data['Review']['sub_genre_id']);
		

		if(!$error){
			if(isset($data['Review']['id'])){
				$review['id'] = $data['Review']['id'];
			}
			$review['user_id'] = $data['Review']['user_id'];
			$review['band_id'] = $band['Band']['id'];
			$review['album_id'] = $album['Album']['id'];
			$review['sub_genre_id'] = $data['Review']['sub_genre_id'];
			$review['review'] = $data['Review']['review'];
			$review['rating'] = $data['Review']['rating'];	
			if(isset($data['Review']['created'])){
				$review['created'] = date("Y-m-d", strtotime($data['Review']['created']));
				$review['modified'] = date("Y-m-d", strtotime($data['Review']['created']));
			}
			$review['edited_by'] = $data['Review']['user_id'];			
		} else {
			return false;	
		}
		
		if($this->save($review)){
			return $review;	
		} else {
			return false;
		} 
	}
}
?>