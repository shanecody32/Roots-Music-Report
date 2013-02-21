<?php
class RadioSyndicatedStation extends AppModel {
	var $name = 'RadioSyndicatedStation';
	var $displayField = 'call_letters';
	var $validate = array(
		'call_letters' => array(
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
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'RadioSyndicatedDetail' => array(
			'className' => 'RadioSyndicatedDetail',
			'foreignKey' => 'radio_syndicated_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>