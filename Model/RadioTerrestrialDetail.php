<?php
class RadioTerrestrialDetail extends AppModel {
	var $name = 'RadioTerrestrialDetail';
	var $displayField = 'call_letters';
	var $validate = array(
		'call_letters' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'You must enter the station\'s call sign.',
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