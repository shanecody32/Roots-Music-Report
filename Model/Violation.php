<?php
class Violation extends AppModel {
	var $name = 'Violation';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
	var $hasAndBelongsToMany = array(
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'joinTable' => 'radio_staff_member_violations',
			'foreignKey' => 'violation_id',
			'associationForeignKey' => 'radio_staff_member_id',
			'unique' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Band' => array(
			'className' => 'Band',
			'joinTable' => 'band_violations',
			'foreignKey' => 'violation_id',
			'associationForeignKey' => 'band_id',
			'unique' => false,
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
	
	function getViolationList(){
		$violations = $this->find('all', array(
			'conditions'=>array(
				'group'=>'reporter'
			)
		));
		if(empty($violations)){
			return false;
		}
		foreach($violations as $violation){
			$to_return[$violation[$this->alias]['id']] = strtoupper($violation[$this->alias]['type']) . ": ".$violation[$this->alias]['title'];
		}
		return $to_return;
	}

}