<?php
class RadioStaffImage extends AppModel {
	var $name = 'RadioStaffImage';
	var $displayField = 'filename';
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