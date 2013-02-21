<?php
class RadioSatelliteDetail extends AppModel {
	var $name = 'RadioSatelliteDetail';
	var $displayField = 'channel_name';
	var $validate = array(
		'channel_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Channel name must be entered.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'channel_number' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Channel number must be entered.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'service_provider' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Service provider must be entered.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
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