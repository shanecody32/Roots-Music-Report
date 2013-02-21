<?php
class PostalCode extends AppModel {
	var $name = 'PostalCode';
	var $displayField = 'code';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
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
		)
	);

	var $hasMany = array(
		'RadioAddress' => array(
			'className' => 'RadioAddress',
			'foreignKey' => 'postal_code_id',
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
		'City' => array(
			'className' => 'City',
			'joinTable' => 'city_postal_codes',
			'with' => 'city_postal_codes',
			'foreignKey' => 'postal_code_id',
			'associationForeignKey' => 'city_id',
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
		$postal_code = $this->findByCode($value);
		if(!$postal_code){
			$postal_code['PostalCode']['country_id'] = $country_id;
			$postal_code['PostalCode']['state_id'] = $state_id;
			$postal_code['PostalCode']['code'] = $value;
			$this->save($postal_code);
			return $this->getLastInsertID();
		} else {
			return $postal_code['PostalCode']['id'];
		}
	}
	
}
?>