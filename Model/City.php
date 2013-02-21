<?php
class City extends AppModel {
	var $name = 'City';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
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

	var $hasMany = array(
		'RadioAddress' => array(
			'className' => 'RadioAddress',
			'foreignKey' => 'city_id',
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
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'city_id',
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
		'PostalCode' => array(
			'className' => 'PostalCode',
			'joinTable' => 'city_postal_codes',
			'with' => 'city_postal_codes',
			'foreignKey' => 'city_id',
			'associationForeignKey' => 'postal_code_id',
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
	);
	
	function add($value = null, $state_id = null, $country_id = null){
		if(!$value || !$country_id || !$state_id){
			return false;
		}
		unset($this->id);
		$city = $this->findByName($value);
		if(!$city){
			$city['City']['country_id'] = $country_id;
			$city['City']['state_id'] = $state_id;
			$city['City']['name'] = $value;
			$this->save($city);
			return $this->getLastInsertID();
		} else {
			return $city['City']['id'];
		}
	}

}
?>