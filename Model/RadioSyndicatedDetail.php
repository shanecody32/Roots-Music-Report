<?php
class RadioSyndicatedDetail extends AppModel {
	var $name = 'RadioSyndicatedDetail';
	var $displayField = 'stations_playing';
	var $validate = array(
		'stations_playing' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'You must provide the number of stations your show is syndicated on. Numbers Only.',
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

	var $hasMany = array(
		'RadioSyndicatedStation' => array(
			'className' => 'RadioSyndicatedStation',
			'foreignKey' => 'radio_syndicated_detail_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>