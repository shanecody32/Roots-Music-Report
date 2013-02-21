<?php
class SubGenre extends AppModel {
	var $name = 'SubGenre';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'sub_genre_id',
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
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'sub_genre_id',
			'dependent' => false,
		),
		
	);
	
	var $belongsTo = array(
		'Genre' => array(
			'className' => 'Genre',
			'foreignKey' => 'genre_id',
		)
	);


	var $hasAndBelongsToMany = array(
		'Album' => array(
			'className' => 'Album',
			'joinTable' => 'album_sub_genres',
			'with' => 'album_sub_genres',
			'foreignKey' => 'sub_genre_id',
			'associationForeignKey' => 'album_id',
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
		'RadioStation' => array(
			'className' => 'RadioStation',
			'joinTable' => 'radio_station_sub_genres',
			'with' => 'radio_station_sub_genres',
			'foreignKey' => 'sub_genre_id',
			'associationForeignKey' => 'radio_station_id',
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
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'foreignKey' => 'sub_genre_id',
			'joinTable' => 'radio_staff_member_sub_genres',
			'associationForeignKey' => 'radio_staff_member_id',
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
		'Band' => array(
			'className' => 'Band',
			'joinTable' => 'band_sub_genres',
			'with' => 'band_sub_genres',
			'foreignKey' => 'sub_genre_id',
			'associationForeignKey' => 'band_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	function getSubGenre($value){
		return $this->findByName($value);
	}
	
	function getAll($show_unknown = false){
		$this->recursive = -1;
		$conditions = array();
		if(!$show_unknown){
			$conditions['name !='] = 'Unknown';
		}
		return $this->find('list', array(
			'conditions' => $conditions,
			'order' => array(
				'name' => 'ASC'
			),
		));
	}

}
?>