<?php
class RadioStaffLink extends AppModel {
	var $name = 'RadioStaffLink';
	var $displayField = 'link';
	var $validate = array(
		'link' => array(
			'url' => array(
				'rule' => 'url',
				'message' => 'You must enter a valid website address.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
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
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'foreignKey' => 'radio_staff_member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>