<?php
class RadioAddress extends AppModel {
	var $name = 'RadioAddress';
	var $displayField = 'address_1';
	var $validate = array(
		'address_1' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must provide an address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'country_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must select a country.',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state' => array(
			'rule' => array('checkCountry'),
			'message' => 'The country you have selected must have a State or Provence.',
		),
		'city' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a city.',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'zip' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a zip or postal code.',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	function checkCountry($data, $check){
		if($this->data['RadioAddress']['country_id'] == 225 || $this->data['RadioAddress']['country_id'] == 39){
			if(empty($this->data['RadioAddress']['state'])){
				return false;
			}
		}
		return true;
	}
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
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
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PostalCode' => array(
			'className' => 'PostalCode',
			'foreignKey' => 'postal_code_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foreignKey' => 'radio_station_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>