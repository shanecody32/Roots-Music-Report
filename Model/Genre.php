<?php
class Genre extends AppModel {
	var $name = 'Genre';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'SubGenre' => array(
			'className' => 'SubGenre',
			'foreignKey' => 'genre_id',
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
	
	function getGenre($value){
		return $this->findBySubGenre($value);
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